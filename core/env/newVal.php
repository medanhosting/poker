<?php
	$id = $_POST["id"];
	$val = $_POST["val"];
	
	require_once "../lib/RCatalog.php";
	
	$catalog = new RCatalog("cata_env");
	$tables = $catalog->getTables();
	$table = $tables[count($tables)-1];
	
	$sql = new SQLConnection();
	$sql->query("UPDATE $table SET value='$val' WHERE id=$id");
	
	require_once "envList.php";

?>