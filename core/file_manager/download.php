<?php
	
	require "config";
	
	$content = file_get_contents($_SERVER["DOCUMENT_ROOT"].$_GET["target"]);
	$filename = basename($_GET["target"]);
	header("Content-Disposition: attachment; filename=$filename");
	header("Content-type: application/octet-stream");
	header("Content-length: ".filesize($_SERVER["DOCUMENT_ROOT"].$_GET["target"]));
	
	echo $content;
?>