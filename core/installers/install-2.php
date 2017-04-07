<?php

	# Создание таблицы виртуальных директориев для хранения
	# Cata-каталогов
	
	sleep(0.5);
	require_once "../lib/sql_class.php";
	$data = file_get_contents("temp_mysql");
	$data = explode('[|]',$data);
	
	$sql = new SQLConnection($data[0],$data[1],$data[2],$data[3]);
	$sql->query("DROP TABLE IF EXISTS cata_catalogs");
	$sql->query("CREATE TABLE cata_catalogs(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100), type INT, tables TEXT, skin TEXT)");
	//print_r($sql->getTables());
	
	if (mysqli_error()=="") echo "OK";
?>