<?php	require "config"; ?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title><?=$APP_TITLE?> | Retar Core v 1.19</title>
		
		<script src='/core/lib/js/retarcore.js'></script>
		<script src='/core/modules/cImager/controller.js'> </script>
		<script src='/core/modules/cEdit/cEditController.js'> </script>
		<script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
		
		
		<script> _.E.imager = <?=$CIMAGER_FOLDER?></script>
		<script src='controller.js'> </script>
		<script src='/core/js/clock.js'> </script>
		
		<link rel='stylesheet' href='/core/css/main.css'/>
		<link rel='stylesheet' href='css/main.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once $_SERVER["DOCUMENT_ROOT"]."/core/menu.php"; ?>
			
			
			
		</header>
	
		<div class='wrapper'>
			<aside class='w_form'>
			<input type='button' id='add' value='+'/>
			<ul class='items'>
<?php

	require_once "list.php";
?>	
			</ul>
		
			
		</aside>
			<form class='edit w_form'>
				
			</form>
		</div>
		
	</body>

</html>