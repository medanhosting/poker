<?php
	require "config";
	
	$id=-1;
	$id=$_GET['id'];
	
	$Q = "DELETE FROM cata_manual WHERE id=$id";
	$sql->query($Q);
	
	if(mysqli_error()) echo mysqli_error();