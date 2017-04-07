<?php
	
	$id = $_POST["id"];
	$title = urldecode($_POST["title"]);
	$description = urldecode($_POST["description"]);

	require_once "../lib/sql_class.php";
	require_once "../lib/RCatalog.php";
	require_once "config";
	
	$catalog = new RCatalog("images");
	$current = $catalog->getItemAt($id,1);
	
	$current["title"]=$title;
	$current["description"] = $description;
	
	$filename = $_FILES["file"]["name"] ;
	$filename = md5(rand(0,10000000))."_id".$id."_".$filename;

	if ($_FILES["file"]["size"]){
		unlink($PATH."/".$current["url"]);
		file_put_contents($PATH."/".$filename, file_get_contents($_FILES["file"]["tmp_name"]));
		$current["url"] = $filename;
		$current["size"] = $_FILES["file"]["size"];
	}
	
	if ($catalog->editValuesOf($id,1,$current)){
		die("Данные записаны успешно!");
	}else  print_r($current);

	 die("Ошибка записи!");
?>