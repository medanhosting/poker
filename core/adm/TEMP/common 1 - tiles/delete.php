<?php

	require_once "config";
	
	$id = $_POST['id'];
	
	$catalog->remove($id);
	echo mysqli_error();
	
	require_once "list.php";

?>