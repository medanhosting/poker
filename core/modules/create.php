<?php

	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";
	
	
	$mysql = $_POST['mysql']==='true';
	$files = $_POST['files']==='true';
	if (!($mysql||$files)) die();
	
	
	$timestamp = date("Y-m-d H:i:s");
	$dir = "../points/$timestamp" ;
	
	if(is_dir($dir)) rmdir($dir);
	mkdir($dir);
	
	$size = 0;
	if($mysql){
	
		$sql = new SQLConnection();
		$mysqldata = file_get_contents($_SERVER['DOCUMENT_ROOT']."/core/lib/mysql_data");
		$md = explode("[|]",$mysqldata);
		$username = $md[1];
		$password = $md[2];
		$db = $md[3];
		
		$command = "mysqldump -u $username -p$password $db > '{$dir}/db.sql'";
		system($command, $result);
		
	
		$size = $size+filesize("{$dir}/db.sql");
	}
	
	if($files){
		
		$zip = new ZipArchive();
		$filename = $dir."/files.zip";
		touch($filename);
		$zip->open($filename);
		
		function addToZip($dirname){
			global $zip;
			$items = scandir($_SERVER['DOCUMENT_ROOT']."/".$dirname);
			
			foreach($items as $i){
			
				if($i==".") continue;
				if($i=="..") continue;
				
				
				$item = $dirname."/".$i;
				if(strpos($item, "core/backup/points")) continue;
				
				
				if(is_dir($_SERVER['DOCUMENT_ROOT']."/".$item)){
					$zip->addEmptyDir($item);
					addToZip($item);
					continue;
				}
				if(is_file($_SERVER['DOCUMENT_ROOT']."/".$item)){
					$zip->addFile($_SERVER['DOCUMENT_ROOT']."/".$item, $item);
					continue;
				}
			}
			
		}
		
		addToZip("");
		$zip->close();
		
		$size+=filesize($filename);
	}
	
	$json = file_get_contents("../points/points.json");
	$json = json_decode($json, true);
	

	
	
	$json[$timestamp]=array(
		"mysql" => $mysql?1:0
		,"files" => $files?1:0
		,"size" => $size
	);
	
	$json = json_encode($json);
	file_put_contents("../points/points.json",$json);
?>