<?php

	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/utils/Utils.php";
	
	if(!isset($_GET['for'])) die("");
	
	$id = $_GET['for'];
	$url = RImages::getURL($id);
	$img= $_SERVER['DOCUMENT_ROOT'].$url;
	
	$ext = explode(".", $img);
	$ext = strtolower($ext[count($ext)-1]);
	
	
	
	#echo file_get_contents($url);
	
	list($width, $height) = getimagesize($img);
	
	if($_GET['h']){
		$h = $_GET['h'];
		$scale = $h/$height;
		$w = $width*$scale;
	}
	
	if($_GET['w']){
		$w = $_GET['w'];
		$scale = $w/$width;
		$h = $height*$scale;
	}
	
	if($_GET['ar']){
		$scale= floatval($_GET['scale']);
		$h = $height*$scale;
		$w = $width*$scale;
	}
	
	if($ext=="jpg"){
		header("Content-Type: image/jpeg");
		$image = imagecreatefromjpeg($img);
		$aimage = imagecreatetruecolor($w, $h);	
		imagecopyresampled($aimage, $image, 0, 0, 0, 0, $w, $h, $width, $height); 
		imagejpeg($aimage, NULL, 100); 
		die();
	}
		
	if($ext=="png"){
		header("Location: $url");
		die();
		
	}
	