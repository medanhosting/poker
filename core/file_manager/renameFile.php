<?php
	require "config";
	$dirName = $_POST["path"];
	$oldName = $_POST["name"];
	$name = $_POST["newname"];
	#print_r($_POST);
	
	chdir($_SERVER["DOCUMENT_ROOT"].$dirName);
	if(!is_file($name)){
		rename($oldName, $name);
	}

?>