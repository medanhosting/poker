<?php

	require_once "../lib/RTemplates.php";
	$catalog = new RCatalog("cata_templates");
	
	$data = array($_POST["name"]);
	$catalog->addItem($data);
	
	require_once "getFolders.php";

?>