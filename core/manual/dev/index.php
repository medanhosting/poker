<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/catalog_class.php";
	$APP_TITLE = "Руководство для пользователей и разработчиков";
	require_once "../../../auth.php";
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
		<link rel='stylesheet' href='../css/main.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once "../../menu.php"; ?>
			
			
			
		</header>
	
		<div class='wrapper'>
			<section class='main'>
				<ul class='main'>
					<li><a href=''>Для администраторов</a></li>
					
					
					
					<li>
						<a href='.'>Для разработчиков</a>
						<ul>
							<li><a href=''>Установка программ</a></li>
							<li><a href=''>Работа с каталогами RetarCata</a>
								<ul>
									<li><a href=''>Класс RCatalog</a></li>
								</ul>
							</li>
							
							<li><a href='classes/'>Классы Core</a>
								<ul>
									<li><a href=''>SQLConnection</a></li>
									<li><a href=''>RCatalog</a></li>
									<li><a href=''>RTemplates</a></li>
									<li><a href=''>REnvars</a></li>
									<li><a href=''>RContent</a>
										<ul>
											<li><a href=''>RContent::Menus()</a></li>
										</ul>
									</li>
									
								</ul>
							</li>
							<li><a href=''>Использование шаблонов</a></li>							
						</ul>
					
					</li>
				</ul>
			
			</section>
		</div>
		
	</body>

</html>