<?php

	#  Создание каталога переменных окружения системы
	#
	
	sleep(0.5);
	require_once "../lib/sql_class.php";
	$data = file_get_contents("temp_mysql");
	$data = explode('[|]',$data);
	
	$sql = new SQLConnection($data[0],$data[1],$data[2],$data[3]);
	
	$sql->query("DELETE FROM cata_catalogs WHERE name='cata_env'");
	$sql->query('INSERT INTO cata_catalogs VALUES (default,  \'cata_env\', 1, \'{"cata_env_items":{"title":"TEXT", "name":"VARCHAR(255)", "value":"TEXT"}}\',\'\')');
	echo "O".mysqli_error();
	
	$sql->query("DROP TABLE IF EXISTS cata_env_items");
	$sql->query("CREATE TABLE cata_env_items (id INT PRIMARY KEY AUTO_INCREMENT, c_order_id INT, title TEXT, name VARCHAR(255), value TEXT)");
	echo "K".mysqli_error();
?>