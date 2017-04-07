<?php

#require_once "../lib/sql_class.php";

class RCatalog{

	public $name;
	private $dataStr;
	private $tables;
	private $data;
	private $sql;

	public function __construct($name){
		$this->name = $name;
		$this->sql = new SQLConnection();
		$this->dataStr = $this->sql->fetch_array("SELECT tables FROM cata_catalogs WHERE name='$name'","$0");
		$this->data = json_decode($this->dataStr);
		$this->tables= array();
		
		for ($i=0; $i<count($this->data); $i++){
			$this->data[$i] = (array)$this->data[$i]; 
			$this->tables[$i] = $this->data[$i]["tableName"];
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

	public function addItem($data, $parentId, $nest=0){
		$table = $this->tables[$nest];
		
		for ($i=0; $i<count($data); $i++){
			$data[$i]=",'".$data[$i]."'";
		}

		$this->sql->query("INSERT INTO $table VALUES (default, $parentId, $data)");
		if (mysqli_error()){return false;}
		return true;
	}

	public function getSchemaJSON($lvl=-1){
		if ($lvl==-1) return $this->dataStr;
		return $this->data[$lvl];
	}

	public function toArray(){
		return $this->sql->getCatalog($this->tables);
	}

	public function getItemsAt($nest=0){
		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest]);		
		$result = array();		
		while($raw = mysqli_fetch_assoc($res)){ array_push($result,$raw);}
		return $result;
	}

	public function getItemAt($id, $nest=0){
		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest]." WHERE id=".$id );		
		$result = array();		
		while($raw = mysqli_fetch_assoc($res)){ array_push($result,$raw);}
		return $result;
	}

	public function getChildrenOf($id, $nest=0){
		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest+1]." WHERE parent=".$id );		
		$result = array();		
		while($raw = mysqli_fetch_assoc($res)){ array_push($result,$raw);}
		return $result;
	}

	public function getNest(){
		return count($this->tables);
	}
	
	public function getParentOf($id, $nest){
		$res = $this->sql->query("SELECT * FROM ".$this->tables[$nest]." WHERE id=".$id );				
		$raw = mysqli_fetch_assoc($res);
		$result = $raw["parent"];
		return $result;
	}

	public function getSiblingsOf($id, $nest){

		if ($nest==0) {return $this->getItemsAt(0);}
		$parent = (integer)$this->sql->fetch_array("SELECT parent FROM ".$this->tables[$nest]." WHERE id=".$id, "$0");
		return $this->getChildrenOf($parent, $nest-1);
		
	}

	public function editValuesOf($id, $nest, $data){
		$table = $this->tables[$nest];
		$result = true;
		foreach($data as $key => $value){
			$this->sql->query("UPDATE ".$table." SET $key='$value' WHERE id=$id");
			if (mysqli_error()) $result = false;
		}
		return $result;
	}

	public function addItemTo($id, $nest, $data=null){
		
		if (!$data){
			$table = $this->tables[$nest];
			$data = $this->data[$nest];
			$vals="";
			for($i=1; $i<count($data); $i++){
				$vals.=",' '";
			}			
			if ($nest==0){	
						
				$this->sql->query("INSERT INTO ".$table." VALUES(default $vals)");
				
			}else{
				
				$this->sql->query("INSERT INTO ".$table." VALUES(default, $id $vals)");
				
			}			
			if (mysqli_error()){ return false;} return true;
		}
		return false;
	}
	
}

?>