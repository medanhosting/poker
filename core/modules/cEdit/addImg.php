<?php
	
	$file = $_FILES["file"];
	$path = $_POST["path"];
	
	$name = $file["name"];
	$ext = explode(".",$name);
	$ext = $ext[count($ext)-1];
	
	$path = urldecode($path);
	$addr= $file["tmp_name"];
	$name = md5($name.rand()).".".$ext;
	
	
	if(!is_dir($_SERVER["DOCUMENT_ROOT"].$path)) mkdir($_SERVER["DOCUMENT_ROOT"].$path);
	
	file_put_contents($_SERVER["DOCUMENT_ROOT"].$path."".$name,file_get_contents($addr));
	echo $path."".$name;

?>