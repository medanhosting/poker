<?php
  require $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $sql = new SQLConnection;
   if(isset($_POST['show_entry_fee'])){
   		$temp = $sql->getArray("SELECT id FROM cata_settings_vars WHERE `key`='show_entry_fee'");
	    if(!$_POST['show_entry_fee'])
	    	$_POST['show_entry_fee'] = 0;
	   	if(count($temp)){
	   		$sql->query("UPDATE cata_settings_vars SET `value`={$_POST['show_entry_fee']} WHERE `key`='show_entry_fee'");
	   	}else{
	   		$sql->query("INSERT INTO cata_settings_vars VALUES('', 'show_entry_fee', 'test', {$_POST['show_entry_fee']},2,'')");
	   	}
   	}
   	

    $sql->query("UPDATE poker_cache_tournaments SET point_fee={$_POST['fee']}, point_enabled={$_POST['enabled']}, lateregminutes={$_POST['latereg']},restart_time={$_POST['restart']} WHERE name='{$_POST['tournament']}'");
    
    if(mysqli_error()){
        die(json_encode(array("status"=>"ERROR","message"=>"An unexpected error occured.".mysqli_error())));
    }
    die(json_encode(array("status"=>"OK","data"=>"")));