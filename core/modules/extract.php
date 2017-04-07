<?php
	$point = $_GET['point'];
	$json = json_decode(file_get_contents("../points/points.json"), true);
	
	
	$data = $json[$point];
	#print_r($data);
	
	$dir = "../points/$point" ;


	if($data['mysql']=='1'){
	
		/* Extracting data to database */
		$mysqldata = file_get_contents($_SERVER['DOCUMENT_ROOT']."/core/lib/mysql_data");
		$md = explode("[|]",$mysqldata);
		$username = $md[1];
		$password = $md[2];
		$db = $md[3];
		
		$command = "mysql -u $username -p$password $db < '{$dir}/db.sql'";
		system($command, $result);
		
	}
	
	if($data['files']=='1'){
		$base= $_SERVER["DOCUMENT_ROOT"]."/";
		
		
		function removeDir($dir){
			global $base;
			
			$items = scandir($base.$dir);
			foreach($items as $i){
			
				if($i==".") continue;
				if($i=="..") continue;
				if(strpos($dir,"core/backup")!=FALSE) continue;
				
				$item = $base.$dir."/".$i;
				if(is_file($item)) unlink($item);
				if(is_dir($item)){
					removeDir($dir."/".$i);
				}
			}
			
			if(strpos($dir,"core/backup")!=FALSE) return;
			
			
			if($dir!="") @rmdir($base.$dir);
			
		}
		
		removeDir("");
		
		$zip = new ZipArchive();
		$zip->open("../points/$point/files.zip");
		$zip->extractTo($base);
	}
	echo "\n Процесс восстановления завершен.";