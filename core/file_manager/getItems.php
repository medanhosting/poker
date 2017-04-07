<?php
require "config";
# Скрипт, возвращающий HTML-список файлов для основного окна приложения по запросу.

	$dirName = $_POST["address"];	
	$dir = opendir($_SERVER["DOCUMENT_ROOT"].$dirName);
	chdir($_SERVER["DOCUMENT_ROOT"].$dirName);
	
	$dirs = array();
	$files = array();
	
	while($handle = readdir($dir)){
		if (is_dir($handle)) 
			if (($handle!=".")&&($handle!="..")) array_push($dirs,$handle); else ;
		 else array_push($files,$handle);
		
	}
	asort($dirs);
	asort($files);
	
	if ($dirName=="/")$dirName="";
		foreach($dirs as $handle){
			echo "<li class='folder' data-addr='$dirName/$handle'>$handle</li>";
		}
		foreach($files as $handle){
			$ext = explode(".",$handle);
			$cl = $ext[count($ext)-1];
			$cl = trim(strtolower($cl));
			
			$back = "";
			if (($cl=='jpg')||($cl=='png')||($cl=='gif')||($cl=='jpeg')||($cl=='ico')) 
				$back = "style='background-image: url($dirName/$handle)!important;'";
				
			echo "<li class='file $cl' $back data-addr='$dirName/$handle'>$handle</li>";
		}
?>