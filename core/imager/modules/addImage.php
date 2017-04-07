<?php

	require "config";
	
	echo Imager::uploadImage($_FILES['file'],$_POST['folder']);