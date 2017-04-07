<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/System.php";	
	$APP_TITLE = "Менеджер приложений";
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>Менеджер приложений | Retar Core v 1.19</title>
		
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
	
		
		<div class='appheader'>

<?php
	
	$data = AppManager::getRemoteAppTree();
	
	$lis = "";
	$tabs = "";
	foreach($data as $i => $cat){
		$lis.="<li data-tab='$i'> <a href='#'>{$cat['title']}</a> </li>";
		
		$tab="<div data-tab='$i'> <ol>";
		foreach($cat['apps'] as $j=>$app){
					
			if (AppManager::isInstalled($app['name'])) $input = "<a href='/core/{$capp[0]['link']}' target='_blank'> Открыть </a>";
			else  $input = "<input type='button' class='install' value='Установить' data-archive='{$app['archive']}'/>" ;
			
			$tab.="<li data-app='{$app['name']}'> 
				<figure>
					<img src='{$app[icon]}'/>
					<figcaption>
						<h2> {$app[title]}</h2>
					</figcaption>
				</figure>
				
				<article>
					<div class='chars'>
						<p> Версия приложения: {$app['version']}</p>
						<p> Дата последнего обновления: {$app['date']} </p>
						<p> Размер приложения: {$app['size']} Кб</p>
					</div>
					
					<div>
						$input
					</div>
				</article>
				
				<div class='description'>
					<article>
						{$app['description']}
					</article>
				</div>
			</li>";
		}
		$tab.="</ol></div>";
		$tabs.=$tab;
	};
	
	
?>		
			<ul class='categories'>
				<?=$lis?>
			</ul>
			
			<div class='search'>
				<input type='text' id='search_query'/><input type='button' id='search' value=' '/>
			</div>
		</div>
		
	<div class='wrapper'>
		<div class='tabs'>
			<?=$tabs?>
			<div class='searchtab'>
				<ol> </ol>
			</div>
		</div>	
	</div>
		
	</body>

</html>