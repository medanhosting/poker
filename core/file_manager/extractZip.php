<?php
	require "config";
	$zip = new ZipArchive;
	
	#print_r($_GET);
	
	$file = $_GET['file'];
	$path = $_GET['file'];
	
	$path = explode("/", $path);
	$name = $path[count($path)-1];
	
	
	$path = str_replace($name, "", $file);
	
	#echo $path, ' ', $name, ' ', $file;
	
	$file = $_SERVER['DOCUMENT_ROOT'].$file;
	$zip->open($file);
	
	$name=explode(".zip",$name);
	$name = implode("",$name);
	
	if(isset($_GET['target'])) $name = $_GET['target'];
	
	if(!isset($_GET['current'])){
		$target = $_SERVER['DOCUMENT_ROOT'].$path.$name;
	}else{
		$target = $_SERVER['DOCUMENT_ROOT'].$path;
	}
	
	if(!is_dir($target)) mkdir($target,0777);
	
	$zip->extractTo($target);
?>