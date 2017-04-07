<?php
	require "config";
	$sliders = $catalog->getItemsAt(0);
	
	foreach($sliders as $slider){
		echo "<li data-id='{$slider['id']}'><h3>[{$slider['id']}]{$slider['title']}</h3> <div class='buttons'> <input type='button' class='removeSlider' data-id='{$slider['id']}'/><input type='button' class='editSlider' data-id='{$slider['id']}'></div></li>";
	}