<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/core/auth.php"; 
	if (!is_file("../.uninstalled")){
		header("Location: ../");
		die();
	}

	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/utils/Utils.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";

	
	AppManager::removeApp("sliders");
	$app = array("sliders",addslashes("Слайдеры"),"sliders.png","sliders/","1.19","","2");
	AppManager::installLocalApp($app,AppManager::CATEGORY_ADMIN,"/core/sliders/install/icon.png");
	
	$sql = new SQLConnection();
	$Q = "DELETE FROM cata_catalogs WHERE name='cata_sliders';";
	$sql->query($Q);
	
	$schema = '{
		"cata_sliders_sliders":{
			"title":"VARCHAR(1000)"
			,"type":"INT"
			,"data":"TEXT"
		}
		
		,"cata_sliders_images":{
			"title":"VARCHAR(1000)"
			,"alt":"VARCHAR(1000)"
			,"href":"VARCHAR(1024)"
			,"image":"INT"
			,"data":"TEXT"
		}
	}';
	
	$skin = '{
		"cata_sliders_sliders":{
			"title":{
				"type":"TEXTLINE"
				,"title":"Название слайдера"
			}
			,"type":{
				"type":"INT"
				,"title":"Тип слайдера"
			}
			,"data":{
				"type":"PTEXT"
				,"title":"Данные"
			}
		}
		
		,"cata_sliders_images":{
			"title":{
				"type":"TEXTLINE"
				,"title":"Заголовок элемента"
			}
			,"alt":{
				"type":"TEXTLINE"
				,"title":"Замещающий текст картинки"
			}
			,"href":{
				"type":"TEXTLINE"
				,"title":"URL ссылки элемента"
			}
			,"image":{
				"type":"IMAGE"
				,"title":"Картинка из хранилища"
			}
			,"data":{
				"type":"PTEXT"
				,"title":"data"
			}
		}
	}';
	
	$Q = "INSERT INTO cata_catalogs VALUES(default, 'cata_sliders',2,'$schema','$skin')";
	$sql->query($Q);
	
	$Q = "DROP TABLE IF EXISTS cata_sliders_sliders";
	$sql->query($Q);
	
	$Q = "CREATE TABLE cata_sliders_sliders(
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
		,c_order_id INT
		,title VARCHAR(1000)
		,`type` INT
		,data TEXT
	)";
	$sql->query($Q);
	
	$Q = "DROP TABLE IF EXISTS cata_sliders_images";
	$sql->query($Q);
	
	$Q = "CREATE TABLE cata_sliders_images (
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT		
		,c_order_id INT 
		,parent INT
		,title VARCHAR(1000)
		,alt VARCHAR(1000)
		,href VARCHAR(1024)
		,image INT
		,data TEXT
	)";
	$sql->query($Q);
	
	unlink("../.uninstalled");
	header("Location: ../");