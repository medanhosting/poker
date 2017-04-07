<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/core/auth.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";
	
	if(is_file(".uninstalled")) {
		require_once "install/index.php";
	}
	
	$APP_NAME='info';
	
?>
<!doctype html>
<html>
	<head>
		<meta charset='utf-8'/>
		<title> Справка системы | RetarCore 1.19</title>
	
		<link rel='stylesheet' href='/core/css/main.css'/>
		<link rel='stylesheet' href='css/main.css'/>
		
		<script src='/core/lib/js/retarcore.js'></script>
		<script src='js/controller.js'> </script>
	</head>
	
	<body>
		<?php require $_SERVER['DOCUMENT_ROOT']."/core/menu.php";?>
		
		<aside class=''>
			<ul class='articles' data-parent='0'>
				<li data-id='1' class='folder'> 
					<div class='clickable'>
						<h4> Общая информация</h4>
					</div>
					
					<ul data-parent='1'>
						<li class='file' data-id='1'> 
							<div class='clickable'>
								<h4> Классы системы</h4>
							</div>
						</li>
						<li class='file' data-id='1'> 
							<div class='clickable'>
								<h4> Приложения системы</h4>
							</div>
						</li>
						<input type='button' class='addFolder' data-parent='0'/>
						<input type='button' class='addFile' data-parent='0'/>
					</ul>
				</li>
				<input type='button' class='addFolder' data-parent='0'/>
				<input type='button' class='addFile' data-parent='0'/>
			</ul>
			
			
			
			
		</aside> 
		
		<section class='content'>
		
		</section>
	</body>
</html>