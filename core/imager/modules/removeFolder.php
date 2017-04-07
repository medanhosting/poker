<?php

	require "config";
	if(!$_GET['id']) die("Не передана папка для удаления!");
	
	Imager::removeFolder($_GET['id']);
	if(!mysqli_error()) echo "OK";
	else echo mysqli_error();