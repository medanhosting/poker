<?php

	require_once "config";
	
	$id = $_POST['id'];
	$level = $_POST['level'] ? $_POST['level'] : 0;
	
	#print_r($_POST);
	$catalog->remove($id, $level);
	echo mysqli_error();
	
	if(!$level) require_once "list.php";

?>