<?php
	
	$data = json_decode(file_get_contents("../points/points.json"),true);
	$result = array();
	
	foreach($data as $d=>$v){
		
		$size = $v['size'];
		if($size<1024){
			$size = $size." б.";
		}else{
			if($size<1024*1024){
				$size = (round(100*$size/1024)/100)." Кб";
			}else{
				$size = (round(100*$size/(1024*1024))/100)." Мб";
			}
		}
		
		$title = strtotime($d);
		$title = date("d.m.Y H:i",$title);
		
		$contains=[];
		if($v['mysql']=='1') $contains[]="Бэкап базы данных MySQL";
		if($v['files']=='1') $contains[]="Бэкап файлов сайта";
		
		$contains = implode($contains, ", ");
		
		$result[]=array(
			"date"=>$d
			,"title"=>$title
			,"size"=>$size
			,"contains"=>$contains
		);
	}
	$result = array_reverse($result);
	
	echo json_encode($result);