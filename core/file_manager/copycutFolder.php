<?php
	require "config";
	
	//print_r($_POST);
	$target = $_SERVER["DOCUMENT_ROOT"].$_POST["target"];
	$addr = $_SERVER["DOCUMENT_ROOT"].$_POST["addr"];
	
	
	$folderName = $_POST["filename"];
	
	mkdir($target."/".$folderName);
	$target = $target."/".$folderName;
	
	copyF($addr, $target);
	
	function copyF($dirname, $dirdestination){
		$dir = opendir($dirname);
		while($file = readdir($dir)){
		
			if(is_file($dirname."/".$file)){
				copy("$dirname/$file","$dirdestination/$file");
				if ($_POST["operation"]=="cut") unlink("$dirname/$file");
			}
			
			if((is_dir("$dirname/$file"))&&($file!=".")&&($file!="..")){
			
				mkdir("$dirdestination/$file");
				copyF("$dirname/$file","$dirdestination/$file");
			}
		}
		closedir($dir);
	}
	
	if ($_POST["operation"]=="cut"){
		removeF($addr);
	}
	
	function removeF($dir){		
   		 if ($objs = glob($dir."/*")) {
   		    foreach($objs as $obj) {
   		      is_dir($obj) ? removeDirectory($obj) : unlink($obj);
   		    }
   		 }
   		 rmdir($dir);		
	}
?>