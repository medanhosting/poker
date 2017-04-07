<?php
	require_once "../lib/sql_class.php";
	require_once "../lib/RCatalog.php";
	require_once "config";
	
	$id = $_POST["id"];
	$catalog = new RCatalog("cata_images");
	$item = $catalog->getItemAt($id, 1);
	$url = $item["url"];
	
	unlink($SYSPATH."/".$url);
	$catalog->removeItemAt($id,1);
?>