<?php
	require "config";
	
	$parent = $_GET['parent'];
	$name = $_GET['name'];
	
	$Q = "INSERT INTO cata_manual VALUES (default, $parent,  0,'$name','', '','')";
	$sql->query($Q);
	
	if(mysqli_error()) echo mysqli_error();