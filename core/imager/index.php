<?php 
	
	$APP_NAME = "Хранилище изображений";
	
	require_once $_SERVER['DOCUMENT_ROOT']."/core/auth.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/utils/Utils.php";
	
	if (file_exists(".uninstalled")){
		header("Location: install/");
		die();
	}


		
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<title> Изображения для сайта </title>

		<link rel='stylesheet' href='/core/css/main.css'/>
		<link rel='stylesheet' href='/core/css/index.css'/>
		<link rel='stylesheet' href='/core/css/icons.css'/>
		<link rel='stylesheet' href='/core/css/widgets.css'/>
		<link rel='stylesheet' href='css/main.css'/>
		
	<link rel="shortcut icon" href="../favicon.ICO" type="image/x-icon">

	<script type="text/javascript" src="/core/lib/js/retarcore.js"></script>
	<script src="js/controller.js"> </script>

</head>
<body>

	<?php
		require_once "../menu.php";
	?>
	
	<aside class='folderList'>
		<ul class='folders'>
			<li data-folder='1'> <h3> Первая папка</h3> <input type='button' value='X' class='remove'/> </li>
		</ul>
		<input type='button' value='Добавить папку' id='addFolder'/>
	</aside>
	
	<section class='imageList'>
		<div class='controls'> 
			<form enctype='multipart/form-data'>
			<label>
				<span> Добавить изображение </span>
				<input type='file' name='image' id='image'/>
			</label>
			</form>
		</div>
		<ul class='images'>
		
		</ul>
	</section>
	
</body>
</html>