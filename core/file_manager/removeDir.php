<?php
	require "config";
	
	$target = $_SERVER["DOCUMENT_ROOT"].$_POST["addr"];
	echo $target;

	function removeDir($dir){
	
		$handler = opendir($dir);
		while($file = readdir($handler)){
		
			if (is_file($dir."/".$file)) unlink("$dir/$file"); else
			if((is_dir($dir."/".$file))&&($file!=".")&&($file!="..")){
				removeDir("$dir/$file");
			}
		}
		closedir($handler);
		return rmdir($dir);
	}
	
	if(removeDir($target)){
		Logger::addReport("file_manager",Logger::STATUS_INFO,"Удалена папка $target со всем содержимым.");
	}else{
		Logger::addReport("file_manager",Logger::STATUS_WARN,"Не удалось удалить папку $target со всем содержимым!");
	}
?>