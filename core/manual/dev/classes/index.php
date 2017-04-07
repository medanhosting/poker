<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/catalog_class.php";
	$APP_TITLE = "Руководство для пользователей и разработчиков";
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>Руководство пользователей и разработчиков | Retar Core v 1.17</title>
		
		<script src='../lib/js/retarcore.js'></script>
		<script src='js/controller.js'> </script>
		<script src='../js/clock.js'> </script>
		
		<link rel='stylesheet' href='/core/css/main.css'/>
		<link rel='stylesheet' href='/core/css/index.css'/>
		<link rel='stylesheet' href='/core/css/icons.css'/>
		<link rel='stylesheet' href='/core/css/widgets.css'/>
		<link rel='stylesheet' href='../../css/main.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once "../../../menu.php"; ?>
			
			
			
		</header>
	
		<div class='wrapper'>
			<section class='main'>
				<ul class='main'>
					
					
				
							
							<li><a href='../'>Классы Core</a>
								<ul>
									<li><a href='sqlconnection.php'>SQLConnection</a></li>
									<li><a href='rcatalog.php'>RCatalog</a></li>
									<li><a href='rtemplates.php'>RTemplates</a></li>
									<li><a href='renvars.php'>REnvars</a></li>
									<li><a href='rcontent/'>RContent</a>
										<ul>
											<li><a href='rcontent/menus.php'>RContent::Menus()</a></li>
										</ul>
									</li>
									
								</ul>
							</li>
							
					
					
				</ul>
			
			</section>
		</div>
		
	</body>

</html>