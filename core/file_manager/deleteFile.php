<?php

	require "config";
	
	if(FileManager::removeFile($_POST['path'], $_POST['name'])){
		echo "Файл удален успешно!";
	}
	else echo "Ошибка удаления файла!";
	
?>