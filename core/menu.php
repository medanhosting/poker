<header>

<?php
	
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RCatalog.php";
	#require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	
	$items = new RCatalog("cata_apps");
	
	$general = $items->getChildrenOf(2);
	$dev = $items->getChildrenOf(1);
	$system = $items->getChildrenOf(3);
	$all = $items->getItemsAt(1);
	
	$adm = $items->getChildrenOf(4);
	
	$r= $_SERVER[REQUEST_URI];
	$r = explode("/core/",$r);
	$r=$r[1];
	
	$app=$items->getAllByQuery(1,"link='$r'");
	if (count($app)){
		$icon=$app[0]["icon"];
		$title = $app[0]['title'];
		$icon = "<li class='current'>
					<a href='#' title='$title' style='background-image: url(/core/img/$icon)' class='active'> $title </a>
				</li>";
	}
	
	
?>


		<nav class='main_nav'>
			<ul>
				<li class='main'>
					<a href='/core/' title='Главное меню'> Главное меню </a>
					<div>
					<ol>
						<?php
							foreach ($all as $app)
							echo "<li > <a href='/core/{$app[link]}' style='background-image: url(/core/img/{$app[icon]})'> {$app[title]} </a></li>";
						?>						
					</ol>
					</div>
				</li>
				
				
				<li class='adm'>
					<a href='#' title='Управление сайтом'> Управление сайтом </a>
					<div>
					<ol>
						
							<?php
								foreach ($adm as $app)
								echo "<li> <a href='/core/{$app[link]}'  style='background-image: url(/core/img/{$app[icon]})'> {$app[title]} </a></li>";
							?>	
					
					</ol>
					</div>
				</li>
				
				<li class='dev'>
					<a href='#' title='Инструменты разработчика'> Инструменты разработчика </a>
					<div>
					<ol>
						
							<?php
								foreach ($dev as $app)
								echo "<li > <a href='/core/{$app[link]}' style='background-image: url(/core/img/{$app[icon]})'> {$app[title]} </a></li>";
							?>
						
					</ol>
					</div>
				</li>
				
				<li class='system'>
					<a href='#' title='Настройки системы'> Настройки системы </a>
					<div>
					<ol>
						<?php
								foreach ($system as $app)
								echo "<li> <a href='/core/{$app[link]}'  style='background-image: url(/core/img/{$app[icon]})'> {$app[title]} </a></li>";
							?>
					</ol>
					</div>
				</li>
				
				<?=$icon?>
			</ul>	
				
		</nav>
	<footer class='time'>
		<!--div class='app_title'> <?php echo $APP_TITLE ?> </div-->
		<!--p class='user'> <?php echo $USERNAME; ?></p-->
		<p class='time'><?=date("H:i d.m")?></p>
	</footer>			
</header>