<?php
	require "config";
	$sliders = $catalog->addItem(array("Новый слайдер",1,''));
	if(mysqli_error()) echo mysqli_error();
	