<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/catalog_class.php";
	$APP_TITLE = "Руководство для пользователей и разработчиков";
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>RCatalog | Retar Core v 1.17</title>
		
		<script src='../lib/js/retarcore.js'></script>
		<script src='js/controller.js'> </script>
		<script src='../js/clock.js'> </script>
		
		<link rel='stylesheet' href='/core/css/main.css'/>
		<link rel='stylesheet' href='/core/css/index.css'/>
		<link rel='stylesheet' href='/core/css/icons.css'/>
		<link rel='stylesheet' href='/core/css/widgets.css'/>
		<link rel='stylesheet' href='../../css/main.css'/>
		<link rel='stylesheet' href='class.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once "../../../menu.php"; ?>
			
			
			
		</header>
	
		<div class='wrapper'>
			<section class='main'>
				<ul class='main'>
					
					
				
							
							<li><a href='./'>RCatalog</a>
								<ul>
									<li><a href='#construct'>__construct()</a></li>
									<li><a href='#out'>out()</a></li>
									<li><a href='#gettables'>getTables()</a></li>
									<li><a href='#additem'>addItem()</a></li>
									<li><a href='#getschemajson'>getSchemaJSON()</a></li>
									<li><a href='#toarray'>toArray()</a></li>
									<li><a href='#getitemsat'>getItemsAt()</a></li>
									<li><a href='#getitemat'>getItemAt()</a></li>
									<li><a href='#getchildrenof'>getChildrenOf()</a></li>
									<li><a href='#getnest'>getNest()</a></li>
									<li><a href='#getname'>getName()</a></li>
									<li><a href='#getparentof'>getParentOf()</a></li>
									<li><a href='#getsiblingsof'>getSiblingsOf()</a></li>
									<li><a href='#editvaluesof'>editValuesOf()</a></li>
									<li><a href='#additemto'>addItemTo()</a></li>
									<li><a href='#swap'>swap()</a></li>
									<li><a href='#setparentid'>setParentId()</a></li>
									<li><a href='#moveitemto'>moveItemTo()</a></li>
									<li><a href='#moveitemsto'>moveItemsTo()</a></li>
									<li><a href='#removeitemat'>removeItemAt()</a></li>
									<li><a href='#remove'>remove()</a></li>
									<li><a href='#getbyquery'>getByQuery()</a></li>
									<li><a href='#getallbyquery'>getAllByQuery()</a></li>
									<li><a href='#moveitembefore'>moveItemBefore()</a></li>
									
								</ul>
							</li>
							
					
					
				</ul>
			
			</section>
			
			<section class='content'>
				<p>
					Класс RCatalog предназначен решения разнообразных задач с построением и работой с уровневыми иерархиями. Является ключевым в работе почти всех инструментов Core, а также является простым и удобным средством создания собственных структур.
				</p>
				<span class='version'>Версия системы: 1.15</span>
				<span class='app'>Приложение: Система</span>
				<span class='path'>lib/catalog_class.php</span> 
				
				
				<article id='construct'>
					<h2> Конструктор RCatalog</h2>
					<code> <s>SQLConnection</s> <b>__construct</b>([string <i>$hostname</i> [, string <i>$username</i> [, string <i>$password</i> [, string <i>$mainDB</i> ]]]]) </code>
					<p> Конструктор класса. Создает экземпляр соединения. Четыре необязательных параметра - установки для подключения. Если какие-то параметры (или все) не заданы, то данные будут взяты по умолчанию.</p>
					<footer>
						<h4>Примеры </h4>
						<div>
							<code> $sql = new SQLConnection();</code>
							<p>Создание подключения</p>
						</div>
						<div>
							<code> $sql = new SQLConnection("localhost","tester","hUd39Ke","mainDB");</code>
							<p>Создание подключения с хостом localhost, именем пользователя tester, паролем hUd39Ke, mainDB</p>
						</div>
					</footer>
				</article>
				
				
			</section>
		</div>
		
	</body>

</html>