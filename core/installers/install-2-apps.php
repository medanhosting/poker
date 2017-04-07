<?php

	#	Создание каталога приложений cata_apps 
	#
	
	sleep(0.5);
	require_once "../lib/sql_class.php";
	$data = file_get_contents("temp_mysql");
	$data = explode('[|]',$data);
	
	$sql = new SQLConnection($data[0],$data[1],$data[2],$data[3]);
	
	$sql->query("DELETE FROM cata_catalogs WHERE name='cata_apps'");
	$sql->query('INSERT INTO cata_catalogs VALUES (default, \'cata_apps\', 2, \'{"cata_apps_folders":{"title":"VARCHAR(300)","type":"INT"},"cata_apps_items":{"name":"VARCHAR(300)","title":"VARCHAR(250)","icon":"VARCHAR(300)","link":"VARCHAR(300)","version":"VARCHAR(10)","information":"TEXT","type":"INT"}}\',\'\')');
	echo "O".mysqli_error();
	
	$sql->query("DROP TABLE IF EXISTS cata_apps_folders");
	$sql->query("CREATE TABLE cata_apps_folders (id INT PRIMARY KEY AUTO_INCREMENT, c_order_id INT, title TEXT, type INT)");
	
	$sql->query("DROP TABLE IF EXISTS cata_apps_items");
	$sql->query("CREATE TABLE cata_apps_items (id INT PRIMARY KEY AUTO_INCREMENT,c_order_id INT, parent INT, name VARCHAR(300), title VARCHAR(250), icon VARCHAR(300),link VARCHAR(300), version VARCHAR(10), information TEXT, type INT)");
	
	
	echo "K".mysqli_error();
?>