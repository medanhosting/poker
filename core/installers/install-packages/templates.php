<?php
	require_once "../lib/sql_class.php";
	$data = file_get_contents("temp_mysql");
	$data = explode('[|]',$data);
	
	$sql = new SQLConnection($data[0],$data[1],$data[2],$data[3]);
	
	$sql->query("DELETE FROM cata_catalogs WHERE name='cata_templates'");
	$sql->query('INSERT INTO cata_catalogs VALUES (default, \'cata_templates\', 2, \'{"cata_templates_folders":{name":"VARCHAR(250)"},"cata_templates_items":{"name":"VARCHAR(250)","title":"VARCHAR(250)","nest":"INT","template":"TEXT"}}\',\'\')');
	echo mysqli_error();
	
	$sql->query("DROP TABLE IF EXISTS cata_templates_folders");
	$sql->query("CREATE TABLE cata_templates_folders (id INT PRIMARY KEY AUTO_INCREMENT, c_order_id INT, name VARCHAR(250))");
	
	$sql->query("DROP TABLE IF EXISTS cata_templates_items");
	$sql->query("CREATE TABLE cata_templates_items (id INT PRIMARY KEY AUTO_INCREMENT, c_order_id INT, parent INT,name VARCHAR(250), title VARCHAR(250), nest INT DEFAULT 0, template TEXT )");
	
	
	echo mysqli_error();
?>