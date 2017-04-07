<?php

	# Создание таблицы пользователей системы
	# Запись первого пользователя системы
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	
	sleep(0.5);
	require_once "../lib/sql_class.php";
	$data = file_get_contents("temp_mysql");
	$data = explode('[|]',$data);
	
	$sql = new SQLConnection($data[0],$data[1],$data[2],$data[3]);
	
	$sql->query("DROP TABLE IF EXISTS cata_users");
	$sql->query("CREATE TABLE cata_users(id INT PRIMARY KEY AUTO_INCREMENT, login VARCHAR(300), password VARCHAR(300), role INT, info TEXT, ssid VARCHAR(80))");
	$sql->query("INSERT INTO cata_users VALUES (default, '".$login."', '".md5($password)."', 1,'','')");
	
	echo (mysqli_error()=="") ? "OK" : mysqli_error();
?>