<?php

	require "config";
	#print_r($_POST);
	#print_r($_FILES);
	
	foreach($_FILES as $file){
		echo Imager::uploadImage($file,$_POST['folder']);
	}