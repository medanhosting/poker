<?php

	require_once "../../lib/sql_class.php";
	require_once "../catalog_class.php";

	
	$name = $_POST["catalog"];
	$nest = $_POST["level"];
	$id = $_POST["parent"];

	$catalog = new RCatalog($name);
	
?>