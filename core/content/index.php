<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RCatalog.php";
	
	$APP_TITLE = "Управление страницами";
	if(is_file(".uninstalled")) header("Location: install/");
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>Управление содержимым | Retar Core v 1.19</title>
		
		<script src='/core/lib/js/retarcore.js'></script>
		<script src='js/controller.js'> </script>
		<script src='/core/js/clock.js'> </script>
		
		<link rel='stylesheet' href='/core/css/main.css'/>
		
		<link rel='stylesheet' href='css/main.css'/>
		
	</head>
	
	<body>
	

		<?php require_once "../menu.php"; ?>
		
		<aside class='pages w_form'>
		
		
			<ul id='pages'>
				<?php require_once "modules/pages/list.php"; ?>
			</ul>	
			<input type='button' id='addPage' value='+'/>
			<a href='/core/content/templates' class='button'>Редактор шаблонов</a>
		</aside>
		
		<section class='content w_form'>
			<form id='editor'>
				
			</form>
		</section>
	</body>

</html>