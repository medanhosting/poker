<?php

	# Установка пакета стандартных приложений.
	# Файловый менеджер, MySQL консоль, Каталоги Cata, переменные окружения 
	
	sleep(0.5);
	require_once "../lib/sql_class.php";
	$data = file_get_contents("temp_mysql");
	$data = explode('[|]',$data);

	$dir = $_SERVER['DOCUMENT_ROOT']."/core/";
		
	$sql = new SQLConnection($data[0],$data[1],$data[2],$data[3]);
	

	$sql->query("INSERT INTO cata_apps_folders VALUES (default, 1, 'Dev Tools', 1)");
	$sql->query("INSERT INTO cata_apps_folders VALUES (default, 2, 'Общедоступные инструменты', 0)");
	
	//File Manager
	$sql->query("INSERT INTO cata_apps_items VALUES (default, 0 ,1,'file_manager','Файловый менеджер','file_manager.png','file_manager/','1.19','',2)");
	
	//MySQL-manager - Dev Tools
	$sql->query("INSERT INTO cata_apps_items VALUES (default,1, 1,'mysql','MySQL-консоль','mysql.png','mysql/','1.19','',1)");
	
	//Retar Cata catalogs - Dev Tools
	$sql->query("INSERT INTO cata_apps_items VALUES (default,2, 1,'cata','Каталоги Retar Cata','cata.png','cata/','1.19','',2)");
	
	//Image Storage
	$sql->query("INSERT INTO cata_apps_items VALUES (default, 3 ,1,'imager','Хранилище изображений','imager.png','imager/','1.19','',2)");
	touch($dir."/imager/.uninstalled");
	
	
	
	//Template Manager - Dev Tools - deprecated and removed
	# Отмена установки менеджера шаблонов - устаревшее приложение
	#$sql->query("INSERT INTO cata_apps_items VALUES (default,4, 1,'templates','Управление шаблонами', 'templates.png', 'templates/','1.17','' ,2)");
	#require_once "install-packages/templates.php";
	
	$sql->query("INSERT INTO cata_apps_folders VALUES (default,3,'Система', 1)");
	
	//Info & Tutorials- System
	$sql->query("INSERT INTO cata_apps_items VALUES (default, 10, 3,'info','Справка','info.png','info/','1.19','',3)");
	
	//Settings - System
	$sql->query("INSERT INTO cata_apps_items VALUES (default,5, 3,'settings','Настройки','settings.png','settings/','1.17','',3)");
	require_once "install-packages/settings.php";
	
	#//Environment vars - Система - deprecated and removed;
	#$sql->query("INSERT INTO cata_apps_items VALUES (default, 3, 3,'env','Переменные окружения','env.png','env/','1.19','',2)");
	
	//Logger - Система
	$sql->query("INSERT INTO cata_apps_items VALUES (default, 8, 3,'logger','Система отчетов','logger.png','logger/','1.19','',2)");
	
	//Application Manager - General
	$sql->query("INSERT INTO cata_apps_items VALUES (default,6, 2,'appmanager','Менеджер приложений Core','appmanager.png','appmanager/','1.19','',2)");	
		
	//PAGEN - Administrating
	$sql->query("INSERT INTO cata_apps_items VALUES (default, 3, 4,'content','Управление страницами (Pagen)','content.png','content/','1.19','',2)");
	touch($dir."/content/.uninstalled");
	
	//Core Users - System
	$sql->query("INSERT INTO cata_apps_items VALUES (default,7, 3,'users','Пользователи','users.png','users/','1.19','',3)");
	
	// Создаем категорию приложений администрирования
	$sql->query("INSERT INTO cata_apps_folders VALUES (default, 4, 'Приложения администрирования', 3)");
	
	
	echo (mysqli_error()=="") ? "OK" : mysqli_error();
?>