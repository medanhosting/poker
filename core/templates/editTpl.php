<?php
	
	require_once "../lib/RTemplates.php";
	$catalog = new RCatalog("cata_templates");
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$template = $_POST['template'];
	
	$edited = $catalog->editValuesOf($id, 1, $_POST);
	
	
	require_once "editor.php";
	
	
	
?>