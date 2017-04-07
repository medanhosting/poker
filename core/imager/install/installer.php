<?php
	
	if (!isset($_POST["path"])) die();
	
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";
	
	$sql = new SQLConnection();
	//Creating catalog
	
	$sql->query("DELETE FROM cata_catalogs WHERE name='cata_images'");
	$sql->query("DROP TABLE IF EXISTS cata_images_folders");
	$sql->query("DROP TABLE IF EXISTS cata_images_items");
	
	$sql->query('INSERT INTO cata_catalogs VALUES (default, \'cata_images\', 2, \'{"cata_images_folders":{"name":"VARCHAR(1000)"},"cata_images_items":{"url":"VARCHAR(255)","title":"VARCHAR(255)","description":"TEXT","size":"INT","type":"VARCHAR(10)"}}\',\'\') ');
	
	echo mysqli_error();
	
	$sql->query("CREATE TABLE cata_images_folders (id INT PRIMARY KEY AUTO_INCREMENT, c_order_id INT, name VARCHAR(250))");
	$sql->query("CREATE TABLE cata_images_items (id INT PRIMARY KEY AUTO_INCREMENT, c_order_id INT, parent INT, url VARCHAR(255), title VARCHAR(255), description TEXT, size INT, type VARCHAR(10))");
	$sql->query("INSERT INTO cata_images_items VALUES(0, 0, 0, '/core/img/empty.jpg', 'No Image', '', 9280, 'jpg')");
	echo mysqli_error();
	
	
	if (is_dir($_SERVER["DOCUMENT_ROOT"]."/".$_POST["path"]))
		REnvars::set("cata_imager_path",'/'.$_POST["path"]);
	else{
		REnvars::set("cata_imager_path","/img/container");
		mkdir($_SERVER["DOCUMENT_ROOT"]."/img/container",0777,true);
	}
	
	# Installing library - deprecated in 1.19. Installed by default.
	#file_put_contents($_SERVER["DOCUMENT_ROOT"]."/core/lib/RImages.php", file_get_contents("lib.txt"));
	
	if (!mysqli_error()){
		echo "OK";
		unlink("../.uninstalled");
		//header("Location: ../");
	}
	
?>