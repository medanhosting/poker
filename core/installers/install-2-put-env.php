<?php
	# Запись переменных окружения в каталог окружения
	#
	
	sleep(0.5);
	require_once "../lib/sql_class.php";
	$data = file_get_contents("temp_mysql");
	$data = explode('[|]',$data);
	
	$sql = new SQLConnection($data[0],$data[1],$data[2],$data[3]);
	
	$sql->query("INSERT INTO cata_env_items VALUES (default, 1, 'Хост базы MySQL(только чтение)','mysql_hostname','".$data[0]."')");
	$sql->query("INSERT INTO cata_env_items VALUES (default, 2, 'Имя пользователя базы MySQL(только чтение)','mysql_username','".$data[1]."')");
	$sql->query("INSERT INTO cata_env_items VALUES (default, 3, 'Пароль базы MySQL(только чтение)','mysql_password','".$data[2]."')");
	$sql->query("INSERT INTO cata_env_items VALUES (default, 4, 'Имя базы MySQL(только чтение)','mysql_maindb','".$data[3]."')");
	
	
	if (mysqli_error()=="") echo "OK"; else echo mysqli_error();
?>