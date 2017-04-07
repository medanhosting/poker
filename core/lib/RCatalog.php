<?php
#
# Version 1.18.1 for 06/01/2016
# 
# JSON Schema changed
# Added getSkinFor, getSkinTypeFor, getSkinTitleFor methods
# renewed ordering and swapping
# 

require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/sql_class.php";
@include_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/Logger.php";

class RCatalog{

	public $name;
	private $dataStr;
	private $tables;
	private $data;
	private $sql;
	private $skin;
	private $lastQuery;
	
	public function __construct($name){
		$this->name = $name;
		$this->sql = new SQLConnection();
		$this->dataStr = $this->sql->fetch_array("SELECT tables FROM cata_catalogs WHERE name='$name'","$0");
		$this->data = json_decode($this->dataStr,true);
		
		$this->skinStr = $this->sql->fetch_array("SELECT skin FROM cata_catalogs WHERE name='$name'","$0");
		$this->skin = json_decode($this->skinStr,true);
		
		$this->tables= array();
		$i=0;
		foreach ($this->data as $table=>$val){
			$this->data[$i] = $val; 
			$this->tables[$i] =$table;
			$i++;
		}
		
	}


	public function out($attr){
		echo '<pre>';
		print_r($attr);
		echo '</pre>';
	}
	
	public function getTables(){
		return $this->tables;
	} 
	
	public function getLastQuery(){
		return $this->lastQuery;
	}
	
	public function addItem($data, $parentId="", $nest=-1){
		$table = $this->tables[$nest+1];
		if(!$table){
		
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::addItem(".print_r($data,true).", $parentId, $nest)", Logger::STATUS_ERROR, "Не удалось создать элемент в каталоге ".$this->name.". Не удалось получить таблицу уровня.");
			else throw new Exception("$APP_NAME > RCatalog::addItem(".print_r($data,true).", $parentId, $nest) - Ошибка! Не удалось создать элемент в каталоге ".$this->name.". Не удалось получить таблицу уровня.");
			
			return false;
		}
		
		for ($i=0; $i<count($data); $i++){
			$data[$i]=",'".$data[$i]."'";
		}
		
		$data = implode($data,"");
		
		$maxId = $this->sql->getArray("SELECT MAX(c_order_id) FROM $table");
		$maxId = $maxId[0][0]*1 + 1;
		
		if ($parentId!=="") {
			$this->sql->query("INSERT INTO $table VALUES (default, $maxId, $parentId $data)");
			$this->lastQuery = "INSERT INTO $table VALUES (default, $maxId, $parentId $data)";
		} else{
			$this->sql->query("INSERT INTO $table VALUES (default, $maxId $data)");
			$this->lastQuery = "INSERT INTO $table VALUES (default, $maxId $data)";
			
		}
		if(mysqli_error()){
		
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::addItem(".print_r($data,true).", $parentId, $nest)", Logger::STATUS_ERROR,"Не удалось создать элемент в каталоге ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			else throw new Exception("$APP_NAME > RCatalog::addItem(".print_r($data,true).", $parentId, $nest) - Ошибка! Не удалось создать элемент в каталоге ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			
			return false;
		}else{
			Logger::addReport("$APP_NAME > RCatalog::addItem", Logger::STATUS_INFO,"Создан новый элемент в каталоге ".$this->name.".". print_r($data, true));
		}
		
			
		if (mysqli_error()){return false;}
		return true;
	}


	public function getSchemaJSON($lvl=-1){
		if ($lvl==-1) return $this->dataStr;
		return $this->data[$lvl];
	}
	
	public function getData(){
		return $this->data;
	}

	public function getSkin($lvl=-1){
		#if ($lvl==-1) return $this->dataStr;
		return $this->skin;
	}
	
	public function getSkinFor($name, $nest){
		$table = $this->getTables();
		$table = $table[$nest];
		$skin = $this->skin[$table];
		$skin = $skin[$name];
		return $skin;
	}
	public function getSkinTypeFor($name, $nest){
		$skin = $this->getSkinFor($name, $nest);
		return $skin[type];
	}
	
	public function getSkinTitleFor($name, $nest){
		$skin = $this->getSkinFor($name, $nest);
		return $skin[title];
	}
	
	public function toArray(){
		return $this->sql->getCatalog($this->tables);
	}

	public function getItemsAt($nest=0){
		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest]." ORDER BY c_order_id desc");
		$this->lastQuery =  "SELECT * FROM ".$this->tables[$nest]." ORDER BY c_order_id desc";
		
		if(mysqli_error()){
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::getItemsAt($nest)", Logger::STATUS_ERROR,"Не удалось получить элементы каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			else throw new Exception("$APP_NAME > RCatalog::getItemsAt($nest). Не удалось получить элементы каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			return [];		
		}
		
		$result = array();		
		while($raw = mysqli_fetch_assoc($res)){ array_push($result,$raw);}
		return $result;
	}

	public function getItemAt($id, $nest=0){
		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest]." WHERE id=".$id );
		$this->lastQuery="SELECT * FROM ".$this->tables[$nest]." WHERE id=".$id;
		
		if(mysqli_error()){
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::getItemAt($id, $nest)", Logger::STATUS_ERROR,"Не удалось получить элемент каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			else throw new Exception("$APP_NAME > RCatalog::getItemAt($id, $nest). Не удалось получить элемент каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			return null;		
		}
			
		$result = array();		
		while($raw = mysqli_fetch_assoc($res)){ array_push($result,$raw);}
		return $result[0];
	}

	public function getChildrenOf($id, $nest=0){
		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest+1]." WHERE parent=".$id." order by c_order_id desc");
		$this->lastQuery="SELECT * FROM ".$this->tables[$nest+1]." WHERE parent=".$id." order by c_order_id desc";
		
		if(mysqli_error()){
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::getChildrenOf($id, $nest)", Logger::STATUS_ERROR,"Не удалось получить элементы каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			else throw new Exception("$APP_NAME > RCatalog::getChildrenOf($id, $nest). Не удалось получить элементы каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			return [];		
		}
				
		$result = array();		
		while($raw = mysqli_fetch_assoc($res)){ array_push($result,$raw);}
		return $result;
	}

	public function getNest(){
		return count($this->tables);
	}

	public function getName(){
		return $this->name;
	}
	
	public function getParentOf($id, $nest){
		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest]." WHERE id=".$id );
		$this->lastQuery="SELECT * FROM ".$this->tables[$nest]." WHERE id=".$id;
		
		if(mysqli_error()){
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::getParentOf($id, $nest)", Logger::STATUS_ERROR,"Не удалось получить родителя элемента каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			else throw new Exception("$APP_NAME > RCatalog::getParentOf($id, $nest). Не удалось получить родителя элемента каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			
			return [];		
		}
		
		$raw = mysqli_fetch_assoc($res);
		$result = $raw["parent"];
		return $result;
	}

	public function getSiblingsOf($id, $nest){

		if ($nest==0) {return $this->getItemsAt(0);}
		$parent = (integer)$this->sql->fetch_array("SELECT parent FROM ".$this->tables[$nest]." WHERE id=".$id." ORDER BY c_order_id", "$0");
		return $this->getChildrenOf($parent, $nest-1);
		
	}

	public function editValuesOf($id, $nest, $data){
		$table = $this->tables[$nest];
		$result = true;
		foreach($data as $key => $value){
			
			$this->sql->query("UPDATE ".$table." SET `$key`='$value' WHERE id=$id");
			$this->lastQuery="UPDATE ".$table." SET `$key`='$value' WHERE id=$id";
			
			if (mysqli_error()){
				if(class_exists("Logger"))
					Logger::addReport("$APP_NAME > RCatalog::editValuesOf($id, $nest,".print_r($data,true).")", Logger::STATUS_ERROR,"Не удалось изменить поле $key элемента каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
				else throw new Exception("$APP_NAME > RCatalog::editValuesOf($id, $nest,".print_r($data,true)."). Не удалось изменить поле $key элемента каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
				return false;
			}
			
		}
		return $result;
	}

	public function addItemTo($id=0, $nest=-1){
		
			$table = $this->tables[$nest+1];			
			$data = $this->data[$nest+1];
			
			$vals="";
						
			for($i=0; $i<count($data); $i++){
				$vals.=",' '";
			}
			
			$maxId = $this->sql->getArray("SELECT MAX(c_order_id) FROM $table");
			$maxId = $maxId[0][0]*1 + 1;
					
			if ($nest==-1){		
				$Q = "INSERT INTO ".$table." VALUES(default, $maxId $vals)";		
			}else{ 
				$Q = "INSERT INTO ".$table." VALUES(default, $maxId, $id $vals)";				
			}
			
			$this->sql->query($Q);
			$this->lastQuery = $Q;
				
			if (mysqli_error()){
				if(class_exists("Logger"))
					Logger::addReport("$APP_NAME > RCatalog::addItemTo($id, $nest)", Logger::STATUS_ERROR,"Не удалось добавить элемент в каталог ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
				else throw new Exception("$APP_NAME > RCatalog::addItemTo($id, $nest). Не удалось добавить элемент в каталог ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
				return false;
			} 
			
			$new = $this->sql->fetch_array("SELECT MAX(id) FROM $table",'$0');
			return $new[0];
		return false;
	}
	
	public function swap($id1, $id2, $nest){	
		$table = $this->tables[$nest];
		
		
    		$id1 = $this->sql->getArray("SELECT c_order_id FROM $table WHERE id=$id1");
    		$id1=$id1[0][0];
    		$id2 = $this->sql->getArray("SELECT c_order_id FROM $table WHERE id=$id2");
    		$id2=$id2[0][0];
    		
    		$this->sql->query("UPDATE $table SET c_order_id=-1 WHERE c_order_id=$id1");
    		$this->sql->query("UPDATE $table SET c_order_id=$id1 WHERE c_order_id=$id2");
    		$this->sql->query("UPDATE $table SET c_order_id=$id2 WHERE c_order_id=-1");
		
		if($nest!=0){
		    $a = $this->sql->getArray("SELECT id, parent FROM $table WHERE c_order_id=$id1");
		    $a = $a[0];
		    $b = $this->sql->getArray("SELECT id, parent FROM $table WHERE c_order_id=$id2");
		    $b = $b[0];
		    
		    $this->sql->query("UPDATE  $table SET parent = {$b['parent']} WHERE id={$a['id']}");
		    $this->sql->query("UPDATE  $table SET parent = {$a['parent']} WHERE id={$b['id']}");
		    
		}

		if (!mysqli_error()){ return true;}
		return false;
	}

	public function setParentId($id, $nest, $parent){
		if ($nest==0) return false;
		$table = $this->tables[$nest-1];
		$temp = $this->sql->fetch_array("SELECT id FROM $table WHERE id=$parent","$0 ");
		if (strlen($temp)<2) {return false;}

		$table = $this->tables[$nest];
		$this->sql->query("UPDATE $table SET parent=$parent WHERE id=$id");
		$this->sql->lastQuery = "UPDATE $table SET parent=$parent WHERE id=$id";
		
		 
		if (mysqli_error()) {
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::setParentId($id, $nest, $parent)", Logger::STATUS_ERROR,"Не удалось изменить родителя элемента каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			else throw new Exception("$APP_NAME > RCatalog::setParentId($id, $nest, $parent). Не удалось изменить родителя элемента каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			return false;
		}		
		return true;		
	}

	public function moveItemTo($id, $nest, $parent){
		return $this->setParentId($id, $nest, $parent);
	}

	public function moveItemsTo($items, $nest, $parent){
		$result = true;
		for ($i=0; $i<count($items); $i++){
			$result = ($result&&($this->moveItemTo($items[$i],$nest, $parent)));
		}
	}

	public function removeItemAt($id, $nest=0){
		$table = $this->tables[$nest];
		
		$chk = $this->sql->getArray("SELECT * FROM $table WHERE id=$id");
		if(!count($chk)){
			Logger::addReport("$APP_NAME > RCatalog::removeItemAt($id, $nest)", Logger::STATUS_WARN,"Попытка удалить элемент из каталога ".$this->name." Такого элемента не существует.");
			return true;
		}
		
		$this->sql->query("DELETE FROM $table WHERE id=$id");
		$this->lastQuery = "DELETE FROM $table WHERE id=$id";
		 
		if (mysqli_error()) {
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::removeItemAt($id, $nest)", Logger::STATUS_ERROR,"Не удалось удалить элемент из каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			else throw new Exception("$APP_NAME > RCatalog::removeItemAt($id, $nest). Не удалось удалить элемент из каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			return false;
		}	
			
		return true;
	}
	
	public function remove($id, $nest=0){
	    if($nest==($this->getNest()-1))
		    return $this->removeItemAt($id, $nest);
		    
		$children = $this->getChildrenOf($id, $nest);
		foreach($children as $ch){
		    $this->remove($ch['id'],$nest+1);
		}
		return $this->removeItemAt($id, $nest);
	}

	public function getByQuery($id, $nest, $query){
		if(!($this->tables[$nest+1])){
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::getByQuery($id, $nest, $query)", Logger::STATUS_ERROR,"Не удалось получить элементы из каталога ".$this->name.". Уровня $nest не существует.");
			else throw new Exception("$APP_NAME > RCatalog::getByQuery($id, $nest, $query). Не удалось получить элементы из каталога ".$this->name.". Уровня $nest не существует.");
			
			return [];
		}
		
		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest+1]." WHERE parent=$id AND $query" );
		$this->lastQuery = "SELECT * FROM ".$this->tables[$nest+1]." WHERE parent=$id AND $query";
		
		if (mysqli_error()) {
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::getByQuery($id, $nest, $query)", Logger::STATUS_ERROR,"Не удалось получить элементы из каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			else throw new Exception("$APP_NAME > RCatalog::getByQuery($id, $nest, $query). Не удалось получить элементы из каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			return []; 
		}
		
		$result = array();		
		while($raw = mysqli_fetch_assoc($res)){ array_push($result,$raw);}
		return $result;	
	}

	public function getAllByQuery($nest, $query){

		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest]." WHERE $query" );
		$this->lastQuery = "SELECT * FROM ".$this->tables[$nest]." WHERE $query" ;
		
		if (mysqli_error()) {
			if(class_exists("Logger"))
				Logger::addReport("$APP_NAME > RCatalog::getAllByQuery($nest, $query)", Logger::STATUS_ERROR,"Не удалось получить элементы из каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			else throw new Exception("$APP_NAME > RCatalog::getAllByQuery($nest, $query). Не удалось получить элементы из каталога ".$this->name.". Ошибка на уровне SQL: ".mysqli_error()." << ".$this->lastQuery);
			return [];
		}
				
		$result = array();		
		while($raw = mysqli_fetch_assoc($res)){ array_push($result,$raw);}
		return $result;	
	}

}

?>