<?php
	$point = $_GET['point'];
	$json = json_decode(file_get_contents("../points/points.json"), true);
	
	
	if(is_file("../points/$point/db.sql")) unlink("../points/$point/db.sql");
	if(is_file("../points/$point/files.zip")) unlink("../points/$point/files.zip");
	if(is_dir("../points/$point")) rmdir("../points/$point");
	
	unset($json[$point]);
	file_put_contents("../points/points.json", json_encode($json));
	
	echo "OK";