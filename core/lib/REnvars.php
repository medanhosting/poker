<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/catalog_class.php";

class REnvars{

	public static function get($key){
		$catalog = new RCatalog("cata_env");
		$result = $catalog->getAllByQuery(0,"name='$key'");
		$result = $result[0];
		return $result["value"];
	}
	
	public static function set($key, $value){
		
		$catalog= new RCatalog("cata_env");
		
		$result = $catalog->getAllByQuery(0,"name='$key'");
		$count = count($result);
		
		if (!$count){
			$catalog->addItem(array("",$key,$value));
		}else{
			$id= $result[0]["id"];
			$data = array();
			$data["value"]=$value;
			$catalog->editValuesOf($id,0,$data);
		}
	}



}

?>