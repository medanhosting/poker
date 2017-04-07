<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RImages.php";

class RVars{


	public $catalog;
	
	public function __construct(){
	
		$this->catalog = new RCatalog("vars");
	}
	
	public function v($s){
	
		echo $this->get($s);
		
	}
	
	public function get($s){
		$i = $this->catalog->getAllByQuery(0,"title='$s'");
		if(count($i)==0) return "";
		return $i[0]['content'];
		
	}
}




?>