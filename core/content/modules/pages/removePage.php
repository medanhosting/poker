<?php
	
	require "config";
	
	$id = $_GET[id];
	if(!$id) die();
	
	#$parent = $sql->fetch_array("select parent from $table where id=$id","$0");
	$sql->query("DELETE FROM $table WHERE id=$id");
	
	$id=$_GET[parent];
	
	
	require "list.php";

?>