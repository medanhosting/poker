<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";

	$APP_TITLE = "Каталоги RetarCata";
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title><?=$APP_TITLE?> | Retar Core v 1.17</title>
		
		<script src='http://app.retarcorp.com/js/retarcore.js'></script>
		<script src='js/controller.js'> </script>
		<script src='js/generator.js'> </script>
		
		<script src='/core/js/clock.js'> </script>
		
		<link rel='stylesheet' href='/core/css/main.css'/>
		<link rel='stylesheet' href='/core/css/index.css'/>
		<link rel='stylesheet' href='/core/css/icons.css'/>
		<link rel='stylesheet' href='/core/css/widgets.css'/>
		<link rel='stylesheet' href='css/main.css'/>
		<link rel='stylesheet' href='css/generator.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once("../menu.php");  ?>
			
			
			
		</header>
	
		<div class='wrapper'>
			<aside class='folder_list'>
				<input type='button' value='+' id='addCatalog'/>
				<ul class='list'>
					<?php require_once "modules/catalogList.php";?>
				</ul>
				
			</aside>
			
			<section class='content'>
				<form class='edit'>
				
				</form>
			</section>
		</div>
		
	</body>

</html>