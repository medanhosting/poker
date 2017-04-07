<?php
	require "config";
	$catalog->editValuesOf($_POST['id'],1,$_POST);
	//echo mysqli_error();
	