<?php
	
	require_once "../../auth.php";	
	require_once "../../lib/REnvars.php";
	
	$sql = new SQLConnection();
	//Creating catalog
	
	$sql->query("DELETE FROM cata_catalogs WHERE name='cata_images'");
	$sql->query("DROP TABLE IF EXISTS cata_images_folders");
	$sql->query("DROP TABLE IF EXISTS cata_images_items");
	
	
	echo mysqli_error();
	touch("../.uninstalled");
	header("Location: ../");
?>