<?php
	require "config";
	

	$folder = $_GET['folder'];
	$folder = explode("/",$_GET['folder']);
	$folder=$folder[count($folder)-1];
	
	$_GET['path']=str_replace($folder,"",$_GET['folder']);
	$_GET['folder']=$folder;
	
	
	$zipName = $_GET['folder'].".zip";
	$zipLocation = $_SERVER['DOCUMENT_ROOT'].$_GET['path'].$zipName;
	
	if(is_file($zipLocation)) unlink($zipLocation);
	
	$zip = new ZipArchive;
	$zip->open($zipLocation,ZipArchive::CREATE);
	
	
	function contentOf($folder){
		global $zip;
		
		$result = array();
		$c = scandir($folder);
		foreach($c as $item){
			if($item==".") continue;
			if($item=="..") continue;
			if($item=="/") continue;
			
			$name = $folder."/".$item;
			$archName = str_replace($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$_GET['folder']."/", "", $name);
			
			if (is_file($name)) {
				$result[]=$name." [$archName]";
				$zip->addFile($name, $archName);
			}
			if (is_dir($name)) {
				$zip->addEmptyDir($archName);
				$result[$name." [$archName]"] = contentOf($name);
			}
		}
		
		return $result;
	}
	
	$folder = $_SERVER['DOCUMENT_ROOT'].$_GET['path'].$_GET['folder'];
	$content = contentOf($folder);
	

	$zip->close();
?>