<?php

	require "config";
	
	if(FileManager::addFile($_POST['target'],$_POST['name']))
		echo "Файл создан успешно!";
	else echo "Ошибка создания файла!"
	
	
?>