<?php

	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/utils/Utils.php";
	
	$file = $_FILES["file"];
	$name = $file["name"];
	$addr = $file["tmp_name"];
	
	$folder = $_POST['folder'];

	$r = RImages::addImage($folder, $file);
	
	if ($r) echo "<li data-id='$r' data-src='".RImages::getURL($r)."' >".RImages::getImage($r,"data-folder='{$folder}' data-id='{$r}'",["h"=>150])."</li>";