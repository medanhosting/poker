<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/sql_class.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";
	
	$sql = new SQLConnection();

	$sql->query("DROP TABLE IF EXISTS `cata_manual`");
	if(mysqli_error()){
		Logger::addReport("info",Logger::STATUS_ERROR,"Не удалось удалить таблицу cata_manual для установки справочной системы! Ошибка на уровне SQL: ".mysqli_error());
		die();
	}else{
		Logger::addReport("info",Logger::STATUS_WARN,"Удалена таблица cata_manual для установки справочной системы.");
		
	}
	
	$Q = "CREATE TABLE cata_manual(
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
		,parent INT
		,`type` INT
		,title VARCHAR(1000)
		,content MEDIUMTEXT
		,shorthand TEXT
		,data TEXT
	)";
	
	$sql->query($Q);
	
	if(mysqli_error()){
		Logger::addReport("info",Logger::STATUS_ERROR,"Не удалось создать таблицу cata_manual для установки справочной системы! Ошибка на уровне SQL: ".mysqli_error());
		die();
	}else{
		Logger::addReport("info",Logger::STATUS_INFO,"Создана таблица cata_manual для установки справочной системы.");	
		
	}
	
	unlink(".uninstalled");
	
	