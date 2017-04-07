<?php
	require "config";
	
	$dirName=$_POST["target"];
	$name = $_POST["name"];
	
	chdir($_SERVER["DOCUMENT_ROOT"].$dirName);
	$dir = opendir($_SERVER["DOCUMENT_ROOT"].$dirName);
	
	while($handle = readdir($dir)){
		if (is_dir($handle)){
			if($handle==$name) die();
		}
	} 
	
	
	if(@mkdir($name, 0777)){
		Logger::addReport("file_manager",Logger::STATUS_INFO,"Создана папка $name");
	}else{
		Logger::addReport("file_manager",Logger::STATUS_WARN,"Не удалось создать папку $name!");
	}
?>