<?php
	require_once "auth.php";
	require_once "lib/RCatalog.php";
	
	$items = new RCatalog("cata_apps");
	
	$general = $items->getChildrenOf(2);
	$dev = $items->getChildrenOf(1);
	$system = $items->getChildrenOf(3);
	$all = $items->getItemsAt(1);
	
?>


<!doctype html>
<html lang='ru'>
	<head>
	
		<meta charset='utf-8'/>
		<title>Система управления сайтом Retar Core v 1.19</title>
		
		<script src='/core/lib/js/retarcore.js'></script>
		<script src='js/index.js'> </script>
		<script src='js/clock.js'> </script>
		
		<link rel='stylesheet' href='css/main.css'/>
		<link rel='stylesheet' href='css/index.css'/>
		
	
		
	</head>
	
	<body>
	
		<?php require "menu.php"?>
			
	
		<div class='wrapper'>
		<ul class='apps'>
		<?php
			foreach($all as $item){
				if($item[type]>=$ROLE) echo "<li> <a href='".$item['link']."' class='i_".$item['name']."' style='background-image: url(\"img/".$item['icon']."\")'>
				".$item['title']."
				</a> </li>";
			}
		?>
		</ul>
		
		
			<div class='widgets'>
				<?php require_once $_SERVER['DOCUMENT_ROOT']."/core/widgets/view.php";?>
			</div>
		</div>
	
	</body>

</html>