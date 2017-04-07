<?php
	require "config";
	
	$catalog->addItem(array("Новый элемент слайдера","","http://example.com/pages/1",0,""),$_GET['parent'],0);
	
	echo mysqli_error();