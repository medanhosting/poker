<?php

	require "config";
	
	if (get_magic_quotes_gpc()){
	
		$_POST['content']=stripslashes($_POST['content']);
	}
	$RES = file_put_contents($_SERVER["DOCUMENT_ROOT"].$_POST["path"], $_POST["content"]);
	
	if ($RES!==FALSE) {echo "Записано ".$RES." байт (".round($RES/1024,2)."Кб)";
		Logger::addReport("file_manager",Logger::STATUS_INFO, "Перезаписан файл {$_POST['path']}. Записано $RES байт.");
	}else {
		echo "Ошибка записи!";
		Logger::addReport("file_manager",Logger::STATUS_ERROR, "Не удалось записать файл {$_POST['path']}!");
	}
		
?>	