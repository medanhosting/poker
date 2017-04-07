<?php

	require "config";
	if(!$_POST['name']) die("<li class='error'>Не передана папка для удаления!</p>");
	
	$res = Imager::addFolder($_POST['name']);
	if(!$res) die ("<li class='error'> Папка с таким названием уже существует!</li>");
	
	$name = $_POST['name'];
	echo "<li data-id='$res'> <h3> $name </h3> <input type='button' class='remove' value='X' data-id='$res'/></li>";