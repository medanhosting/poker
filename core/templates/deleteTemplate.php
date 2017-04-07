<?php
	require_once "../lib/RTemplates.php";
	$id = $_POST["id"];
	$parent = $_POST["parent"];
	
	$catalog = new RCatalog("cata_templates");
	$catalog->remove($id,1);
	
	$id = $parent;
	require_once "getList.php";
?>