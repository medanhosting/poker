<?php
	require "config";
	
	$target = $_SERVER["DOCUMENT_ROOT"].$_POST["path"];
	
	chdir($target);
	foreach($_FILES as $descr => $file){
	
		$name = $file["name"];
		$fileName = $name;
		$i=0;
		while(file_exists($fileName))$fileName=$name."(".($i++).")";
		file_put_contents($fileName,file_get_contents($file["tmp_name"]));
		
	}
?>