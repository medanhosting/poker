<?php

	require_once "../lib/RTemplates.php";
	$catalog = new RCatalog("cata_templates");
	
	
	$catalog->remove($_POST["id"]);
	
	require_once "getFolders.php";

?>