<?php


	$_POST['content']=stripcslashes($_POST['content']);
	$RES = file_put_contents("/".$_COOKIE['dir'].$_POST['filename'], $_POST["content"]);
	//file_put_contents("/".$_COOKIE["dir"]."tmp_file", $_POST["content"]);
	if ($RES) echo "Записано ".$RES." байт (".round($RES/1024,2)."Кб)"; else 
	echo "Ошибка записи!";
?>	