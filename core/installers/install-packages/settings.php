<?php
	require_once "../lib/sql_class.php";
	$data = file_get_contents("temp_mysql");
	$data = explode('[|]',$data);
	
	$sql = new SQLConnection($data[0],$data[1],$data[2],$data[3]);
	
	
	
	$sql->query("DROP TABLE IF EXISTS cata_settings_vars");
	$sql->query("CREATE TABLE cata_settings_vars (id INT PRIMARY KEY AUTO_INCREMENT, `key` VARCHAR(250), title varchar(250), `value` TEXT, `type` INT, variants TEXT)");
	
	echo mysqli_error();
	
	//Тип - тип поля для ввода настройки в системе. 1 - простое текстовое, 2- число, 3 - выбор из select. Если установлено 3, то в variants необходимо описать список вариантов с разделителем [|]
	$sql->query("INSERT INTO cata_settings_vars VALUES(default, 'theme', 'Тема', 'Modern',3, 'Modern[|]Minimalistic[|]Пользовательская настройка')");
	$sql->query("INSERT INTO cata_settings_vars VALUES(default, 'logout_timeout', 'Максимальное время сеанса, мин', '1200',2,'')");
	
	
	
	echo mysqli_error();
?>