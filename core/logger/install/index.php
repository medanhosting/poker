<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/RCatalog.php";
		
	if(!$_GET['ignoremarker'])
		if(!is_file("../.uninstalled")) header("Location: ../");
	
	# 1.Создать таблицу для хранения всех записей
	# 2.Добавить приложение в список приложений, если не сделано
	# 3.Добавить системный класс для работы с логами
	# 4.Внести первую запись в лог
	
	
	$sql = new SQLConnection;
	$Q = "DROP TABLE IF EXISTS cata_logger_journal";
	$sql->query($Q);
	echo mysqli_error();
	
	$Q = "CREATE TABLE cata_logger_journal(
		`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT
		,`date` DATETIME
		,`milliseconds` INT
		,`status` INT
		,`user` VARCHAR(500)
		,`app` VARCHAR(200)
		,`content` MEDIUMTEXT 
	)";
	$sql->query($Q);
	
	if(mysqli_error()) die(mysqli_error());
	
	$res = AppManager::installLocalApp(array('logger','Система отчетов', "logger.png", "logger/", "1.19", "Стандартная система сбора отчетов приложений системы", 2), Appmanager::CATEGORY_SYSTEM, "/core/logger/install/icon.png");
	
	
	if($res){
		if($_GET['ignoremarker']){
			unlink("../.uninstalled");
			die("OK");
		}
		unlink("../.uninstalled");
		header("Location: ../");
	}
	
?>