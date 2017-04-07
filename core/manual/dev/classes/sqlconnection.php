<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/catalog_class.php";
	$APP_TITLE = "Руководство для пользователей и разработчиков";
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>SQLConnection | Retar Core v 1.17</title>
		
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
					
					
				
							
							<li><a href='./'>SQLConnection</a>
								<ul>
									<li><a href='#construct'>__construct()</a></li>
									<li><a href='#db'>DB()</a></li>
									<li><a href='#query'>query()</a></li>
									<li><a href='#fetch_array'>fetch_array()</a></li>
									<li><a href='#fetch_assoc'>fetch_assoc()</a></li>
									<li><a href='#getassocarray'>getAssocArray()</a></li>
									<li><a href='#getarray'>getArray()</a></li>
									<li><a href='#getcatalog'>getCatalog()</a></li>
									
								</ul>
							</li>
							
					
					
				</ul>
			
			</section>
			
			<section class='content'>
				<p>
					Класс SQLConnection предназначен для создания подключения к базе данных MySQL и расширенной работы с данными базы.
				</p>
				<span class='version'>Версия системы: 1.17</span>
				<span class='app'>Приложение: Система</span>
				<span class='path'>lib/sql_class.php</span> 
				
				
				<article id='construct'>
					<h2> Конструктор SQLConnection</h2>
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
				
				<article id='db'>
					<h2> DB() </h2>
					<code> <s>Resource</s> <b>DB</b>() </code>
					<p> Возвращает указатель на ресурс открытой базы данных</p>
					
				</article>
				
				<article id='query'>
					<h2> query()</h2>
					<code> <s>Resource</s> <b>query</b>(string <i>$query</i>) </code>
					<p> Возвращает ресурс результата выполнения запроса <i>$q</i> к базе данных соединения</p>
					<footer>
						<h4>Примеры </h4>
						<div>
							<code> $result = $sql-><b>query</b>(<u>"SELECT * FROM table WHERE id>10"</u>);</code>
							<p>Возвращает результат из таблицы table</p>
						</div>
						
					</footer>
				</article>
				
				<article id='fetch_array'>
					<h2>fetch_array()</h2>
					<code> <s>string</s> <b>fetch_array</b>(string <i>$query</i> , string <i>$template</i>) </code>
					<p> Выполняет запрос и разбор данных к базе данных по запросу <i>$query</i>, и подставляет данные в шаблон <i>$template</i>. Результатом является строка - объединение шаблонов для каждой строки из запроса. В шаблоне нужные данные подставляются на место численных идентификаторов: $0, $1, $2 и т.д., которые соответствуют индексу элемента данных в результате запроса.</p>
					<footer>
						<h4>Примеры </h4>
						<div>
							<code> 
								$sql = new SQLConnection();<br/>
								$template = <u>"Пользователь с идентификатором \$0 вошел в систему под логином \$1&lt;br/&gt;"</u><br/>
								$query = <u>"SELECT id, login FROM users"</u>;<br/>
								$source=$sql-><b>fetch_array</b>($query, $template);<br/>
								echo $source;<br/>
								─────────────────────────────────────────────────────────<br/>
								Будет выведено:<br/>
								Пользователь с идентификатором 14 вошел в систему под логином tester<br/>
								Пользователь с идентификатором 21 вошел в систему под логином andreyUkol<br/>
								.<br/>.<br/>
							</code>
							<p>Метод выполняет запрос к базе данных и подставляет в шаблон, собирая текст.</p>
						</div>
						<div>
							<code> $template = <u>"Пользователь с идентификатором $0 вошел в систему под логином $1&lt;br/&gt;"</u>//Не сработает - вместо $0 и $1 будут подставлены пустые значения.<br/>
							$template = <u>'Пользователь с идентификатором $0 вошел в систему под логином $1&lt;br/&gt;'</u>//Сработает - в строки с одинарными кавычками значения не подставляются<br/></code>
							<p>Важно! Не забывайте, что PHP автоматически подставляет в строки, обозначенные двойными кавычками, значения переменных на месте $1, $5... Не забывайте экранировать знак доллара в шаблоне этом случае.</p>
						</div>
					</footer>
				</article>
				
				
				<article id='fetch_assoc'>
					<h2>fetch_assoc()</h2>
					<code> <s>string</s> <b>fetch_assoc</b>(string <i>$query</i> , string <i>$template</i>) </code>
					<p> Выполняет запрос и разбор данных к базе данных по запросу <i>$query</i>, и подставляет данные в шаблон <i>$template</i>. Результатом является строка - объединение шаблонов для каждой строки из запроса. В шаблоне нужные данные подставляются на место строковых идентификаторов: $id, $name, $title и др., которые соответствуют ключу(названию столбца) элемента данных в результате запроса.</p>
					<footer>
						<h4>Примеры </h4>
						<div>
							<code> 
								$sql = new SQLConnection();<br/>
								$template = <u>"Пользователь с идентификатором \$id вошел в систему под логином \$login&lt;br/&gt;"</u><br/>
								$query = <u>"SELECT id, login FROM users"</u>;<br/>
								$source=$sql-><b>fetch_assoc</b>($query, $template);<br/>
								echo $source;<br/>
								─────────────────────────────────────────────────────────<br/>
								Будет выведено:<br/>
								Пользователь с идентификатором 14 вошел в систему под логином tester<br/>
								Пользователь с идентификатором 21 вошел в систему под логином andreyUkol<br/>
								.<br/>.<br/>
							</code>
							<p>Метод выполняет запрос к базе данных и подставляет в шаблон, собирая текст.</p>
						</div>
						<div>
							<code> $template = <u>"Пользователь с идентификатором $id вошел в систему под логином $login &lt;br/&gt;"</u>//Не сработает - вместо $id и $login будут подставлены пустые значения.<br/>
							$template = <u>'Пользователь с идентификатором $id вошел в систему под логином $login&lt;br/&gt;'</u>//Сработает - в строки с одинарными кавычками значения не подставляются<br/></code>
							<p>Важно! Не забывайте, что PHP автоматически подставляет в строки, обозначенные двойными кавычками, значения переменных на месте $id, $login... Не забывайте экранировать знак доллара в шаблоне этом случае.</p>
						</div>
					</footer>
				</article>
				
				<article id='getassocarray'>
					<h2>getAssocArray()</h2>
					<code> <s>Array</s> <b>getAssocArray</b>(string <i>$query</i>) </code>
					<p> Выполняет запрос и разбор данных к базе данных по запросу <i>$query</i>, и возвращает массив, каждый элемент которого - ассоциативный массив, соответствующей одной строке результата запроса.</p>
					<footer>
						<h4>Примеры </h4>
						<div>
							<code> 
								$sql = new SQLConnection();<br/>
								$query = <u>"SELECT id, login FROM users"</u>;<br/>
								$source=$sql-><b>getAssocArray</b>($query);<br/>
								print_r($source);<br/>
								─────────────────────────────────────────────────────────<br/>
								Будет выведено:<br/>
								<pre>
Array (
	[1]	=> Array(
			[id]=> 12
			[login]=> tester										
			)	
							
	[2]	=> Array(
			[id]=> 24
			[login]=> andreyU
			)	
														
	)
								</pre>
							</code>
							<p>Вывод на экран результатов запроса в ассоциативном виде.</p>
						</div>
						
					</footer>
				</article>
				
				<article id='getarray'>
					<h2>getArray()</h2>
					<code> <s>Array</s> <b>getArray</b>(string <i>$query</i>) </code>
					<p> Выполняет запрос и разбор данных к базе данных по запросу <i>$query</i>, и возвращает массив, каждый элемент которого - массив, соответствующей одной строке результата запроса.</p>
					<footer>
						<h4>Примеры </h4>
						<div>
							<code> 
								$sql = new SQLConnection();<br/>
								$query = <u>"SELECT id, login FROM users"</u>;<br/>
								$source=$sql-><b>getArray</b>($query);<br/>
								print_r($source);<br/>
								─────────────────────────────────────────────────────────<br/>
								Будет выведено:<br/>
								<pre>
Array (
	[1]	=> Array(
			[1]=> 12
			[2]=> tester										
			)	
							
	[2]	=> Array(
			[1]=> 24
			[2]=> andreyU
			)	
														
	)
								</pre>
							</code>
							<p>Вывод на экран результатов запроса в виде массива.</p>
						</div>
						
					</footer>
				</article>
				
				<article id='getcatalog'>
					<h2>getCatalog()</h2>
					<code> <s>Array</s> <b>getCatalog</b>(Array <i>$tables</i>) </code>
					<p> Строит рекурсивный многомерный массив на базе таблиц $tables.</p>
					
				</article>
				
			</section>
		</div>
		
	</body>

</html>