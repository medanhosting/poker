<?php

	require "config";
	$images = Imager::getImages($_GET['id']);
	
	#print_r($images);
	
	foreach($images as $i){
		echo "<li> <div class='console'> <span>{$i['id']}</span> <input type='button' class='removeImage' data-id='{$i['id']}' value='X' /></div> ".RImages::getPreview($i['id'],["h"=>120])."</li>";
	}