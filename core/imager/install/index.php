<?php
	require_once "../../auth.php";
	

?>

<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title> Хранилище изображений | Retar Core v 1.17 - установка</title>
		 
		<script src='../../lib/js/retarcore.js'></script>
		<script src='js/controller.js'></script>
		<link rel='stylesheet' href='../../css/install.css'/>
				
	</head>
	
	<body>
	
		<header>
			
			<h1> Хранилище изображений - установка </h1>
			<progress value=1 max=100></progress>
		</header>
	
		<section class='main window'>
			
			<form class='request'> 
				
				<p> Введите путь к хранилищу изображений (папка на вашем сервере), отсчитывая от корня сайта. Если папка не существует, будет создан стандартный каталог. </p>
				<label>
					Путь к хранилищу
					<input type='text' value='img/container' id='path'/>	
				</label>	
				
				<label>		
					<input type='button' value='Далее' id='proceed' class='next'/>
				</label> 
			</form>
		</section>
		
		<section class='log'>
			<h2>Ход установки</h2>
			<textarea></textarea>
		</section>
	</body>

</html>