<?php

	require "config";
	
	if (isset($_FILES["file"]["name"])){
		echo "Trying to save..";
		$DIR = "/".$_COOKIE["dir"];
		$NAME = $_FILES["file"]["name"];
		
		chdir($DIR);
		$RESOURCE = opendir($DIR);
		$IS = false;


		while ($T = readdir($RESOURCE)){
			if ((!is_dir($T))&&($T == $NAME)) {$IS = true; }

		}

		if ($IS) { echo "<br/> <b> File already exists! File was overwritten</b>";}  else{

			echo " <i> Saving... </i>";
			
		}
		file_put_contents($NAME, file_get_contents($_FILES["file"]["tmp_name"]));	
	


	}
	
?>