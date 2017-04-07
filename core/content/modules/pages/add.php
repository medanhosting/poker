<?php
	
	require "config";
	
	$id = $_GET['id'];
	if(!$id) $id=0;
	
	$sql->query("INSERT INTO $table VALUES (default, $id, '','', 'Новая страница', '', '', 0, '', '') ");
	echo mysqli_error();
	require "list.php";

?>