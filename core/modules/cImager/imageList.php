<?php

	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/utils/Utils.php";
	
	$folder = $_GET['folder'];
	
	$imgs = RImages::getImages($folder);
	foreach($imgs as $img){
		echo "<li data-id='".$img["id"]."' data-src='".RImages::getURL($img['id'])."' >".RImages::getImage($img['id'],"data-folder='{$folder}' data-id='{$img['id']}'",["h"=>150])."</li>";
	}