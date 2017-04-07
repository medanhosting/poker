<?php
	require "config";
	
	$targetDir = $_POST["target"];
	$itemDir = $_POST["addr"];
	$itemName = $_POST["filename"];
	
	chdir($_SERVER["DOCUMENT_ROOT"].$targetDir);
	
	$name = $itemName;
	$i=1;
	while(is_file($name)) $name = $itemName."(".($i++).")";

	file_put_contents($name, file_get_contents($_SERVER["DOCUMENT_ROOT"].$itemDir));
	if ($_POST["operation"]=="cut") unlink($_SERVER["DOCUMENT_ROOT"].$itemDir);
?>