<?php
	
	#Module for Pagen
	
	require_once "../lib/RCatalog.php";
	require_once $_SERVER[DOCUMENT_ROOT]."/core/lib/RImages.php";
	
	require_once "config";

	#print_r($_FILES);
	
	$file = $_FILES["file"];
	$id = 5; #Folder to upload to

	$tmp_name = $file["tmp_name"];
	$filename = $file["name"];

	$catalog = new RCatalog("cata_images");
	$filename = md5(rand(0,10000000))."_id".$id."_".$filename;
	
	$id = $catalog->addItem(array("$filename",'Empty','Empty',$file["size"],'img'), $id,0);
	
	file_put_contents( $SYSPATH."/".$filename, file_get_contents($tmp_name));
	echo $PATH.'/'.$filename;
?>