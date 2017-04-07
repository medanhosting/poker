<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RCatalog.php";
	$APP_TITLE = "Переменные окружения";
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>Переменные окружения | Retar Core v 1.17</title>
		
		<script src='../lib/js/retarcore.js'></script>
		<script src='js/controller.js'> </script>
		<script src='../js/clock.js'> </script>
		
		<link rel='stylesheet' href='../css/main.css'/>
		<link rel='stylesheet' href='../css/index.css'/>
		<link rel='stylesheet' href='../css/icons.css'/>
		<link rel='stylesheet' href='../css/widgets.css'/>
		<link rel='stylesheet' href='css/main.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once "../menu.php"; ?>
			
			
			
		</header>
	
		<div class='wrapper'>
			
			
			<section class='vars'>
				<ul>
<?php

	require_once "envList.php";
?>				</ul>
			</section>
		</div>
	
	</body>

</html>