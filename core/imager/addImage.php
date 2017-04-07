<?php
	require_once "../lib/sql_class.php";
	require_once "../lib/RCatalog.php";
	require_once "config";

	$file = $_FILES["file"];
	$id = $_POST["id"];

	$tmp_name = $file["tmp_name"];
	$filename = $file["name"];

	$catalog = new RCatalog("cata_images");
	$filename = md5(rand(0,10000000))."_id".$id."_".$filename;
	
	$id = $catalog->addItem(array("$filename",'Empty','Empty',$file["size"],'img'), $id,0);
	
	file_put_contents( $SYSPATH."/".$filename,file_get_contents($tmp_name));
?>