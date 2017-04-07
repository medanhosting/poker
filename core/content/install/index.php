<?php

	require_once $_SERVER[DOCUMENT_ROOT]."/core/lib/sql_class.php";
	require_once $_SERVER[DOCUMENT_ROOT]."/core/lib/RCatalog.php";
	
	$sql = new SQLConnection;
	$table = "cata_content_pages";
	
	
	#Creating pages table
	$sql->query('DROP TABLE IF EXISTS cata_content_pages');
	$sql->query('CREATE TABLE cata_content_pages (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, parent INT DEFAULT 0, head TEXT, body MEDIUMTEXT, title VARCHAR(1000), keywords TEXT, description TEXT, template INT, url VARCHAR(2000), data TEXT)');
	
	#Creating templates catalog
	$sql->query("DELETE FROM cata_catalogs WHERE name='cata_content'");
	$sql->query('INSERT INTO cata_catalogs VALUES(default, \'cata_content\',3,\'{"cata_content_folders":{"title":"VARCHAR(1000)","data":"TEXT"},"cata_content_templates":{"body":"MEDIUMTEXT","head":"TEXT","title":"VARCHAR(1000)","data":"TEXT"},"cata_content_elements":{"title":"VARCHAR(1000)","code":"MEDIUMTEXT","default":"TEXT","isAtomic":"TINYINT","data":"TEXT"}}\',\'
{"cata_content_folders":{"title":{"type":"TEXTLINE","title":"Название папки"},"data":{"type":"FTEXT","title":"data"}},"cata_content_templates":{"body":{"type":"CTEXT","title":"body"},"head":{"type":"FTEXT","title":"head"},"title":{"type":"TEXTLINE","title":"title"},"data":{"type":"FTEXT","title":"data"}},"cata_content_elements":{"title":{"type":"TEXTLINE","title":"title"},"code":{"type":"CTEXT","title":"code"},"default":{"type":"PTEXT","title":"default"},"isAtomic":{"type":"TINYINT","title":"isAtomic"},"data":{"type":"PTEXT","title":"data"}}}\')');

	#Creating templates tables
	$sql->query('DROP TABLE IF EXISTS cata_content_folders');
	$sql->query('CREATE TABLE cata_content_folders (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, c_order_id INT, title VARCHAR(1000), data TEXT)');

	
	$sql->query('DROP TABLE IF EXISTS cata_content_templates');
	$sql->query('CREATE TABLE cata_content_templates(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, c_order_id INT, parent INT, body MEDIUMTEXT, head TEXT, title VARCHAR(1000), data TEXT)');
	
	$sql->query('DROP TABLE IF EXISTS cata_content_elements');
	$sql->query('CREATE TABLE cata_content_elements (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, c_order_id INT, parent INT, title VARCHAR(1000), code MEDIUMTEXT, `default` TEXT, isAtomic TINYINT, data TEXT)');
	
	if(!mysqli_error()) unlink("../.uninstalled");
	if(mysqli_error()) echo mysqli_error();
	if(!mysqli_error()) header("Location: ../");
?>