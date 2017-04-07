<?php
	require "config";
	
	if (!isset($_POST['address'])){
		$dirName = $_SERVER["DOCUMENT_ROOT"];
		$dirTitle = "";
		
	}else{
		$dirName = $_SERVER["DOCUMENT_ROOT"].$_POST["address"];
		$dirTitle = $_POST['address'];
	}
		$dir = opendir($dirName);		
		chdir($dirName);
	
		$dirs = array();
		while ($handle = readdir($dir)){
			if (is_dir($handle)) 
				if (($handle!=".")&&($handle!=".."))
					array_push($dirs, $handle);
					
		}
		sort($dirs);
		
		foreach($dirs as $handle){
			echo "<li class='dir' data-addr='$dirTitle/".$handle."'>".$handle."<ul></ul></li>";
		}
	
	
?>