<?php

	require_once "../../config.inc";

	$name = $_GET['name'];
	
	$id = $_GET[id];
	$nest = $_GET[nest];
	
	$catalog = new RCatalog($name);
	
	$catalog->remove($id, $nest);
	echo mysqli_error();
?>