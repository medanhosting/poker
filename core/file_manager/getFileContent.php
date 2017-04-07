<?php
	require "config";
	
	$target = $_SERVER["DOCUMENT_ROOT"].$_POST["path"];
	echo file_get_contents($target);
?>