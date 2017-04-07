<?php

	require "config";	
	$catalog->swap($_GET['b'], $_GET['a'], 0);
	
	echo mysqli_error();
	
	require "list.php";
?>