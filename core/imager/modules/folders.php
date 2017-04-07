<?php

	require "config";
	$folders = Imager::getFolders();
	
	
	foreach($folders as $f){
		echo "<li data-id='{$f['id']}'> <h3>{$f['name']} </h3> <input type='button' class='remove' value='X' data-id='{$f['id']}'/></li>";
	}