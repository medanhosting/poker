<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RCatalog.php";
	$CATA_NAME = $_SERVER['QUERY_STRING'];
	$APP_TITLE = "Каталог $CATA_NAME";
	
	$catalog = new RCatalog($CATA_NAME);
	$nest = $catalog->getNest();
	#print_r($catalog->getData());
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title><?=$APP_TITLE?> | Retar Core v 1.17</title>
		
		<script src='http://app.retarcorp.com/js/retarcore.js'></script>
		<script> _.c = '<?=$CATA_NAME?>'; _.l = <?=$nest?>;</script>
		<script src='js/controller.js'> </script>
		<script src='/core/js/clock.js'> </script>
		
	
		<link rel='stylesheet' href='/core/css/main.css'/>
		<link rel='stylesheet' href='/core/css/index.css'/>
		<link rel='stylesheet' href='/core/css/icons.css'/>
		<link rel='stylesheet' href='/core/css/widgets.css'/>
		<link rel='stylesheet' href='css/main.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once "../../menu.php"; ?>
			
		</header>
	
		<div class='wrapper'>
			<aside class='folder_list'>
				
				<h3> Текущий уровень: <span id='t_level'> 0 </span>. ID родителя: <span id='t_id'> -1 </span>.
					<div class='buttons'>
						<input type='button' value='↑' id='back' title='На уровень выше'/>
						<input type='button' value='+' id='add' title='Добавить элемент'/>
						
					</div>
				</h3>
				
			</aside>
			
			<ul class='list'>
				
				</ul>
				
			
			<section class='content'>
				<form class='edit'>
				
				</form>
			</section>
		</div>
		
	</body>

</html>