<?php 

include "../lib/funclib.php";
include "../lib/sql_class.php";


?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<title> Работа с каталогами </title>


	<link rel="stylesheet" type="text/css" href="../css/instruments.css"/>
	<link rel="stylesheet" type="text/css" href="style/main.css"/>
	<link rel="shortcut icon" href="../favicon.ICO" type="image/x-icon">

	<script type="text/javascript" src="../lib/js/retarcore.js"></script>
	<script type="text/javascript" src="controller.js"></script>

</head>
<body>
	<header> 
		<nav>
			<ul>
				<li> <a href="../">В инструментарий </a> </li>
				<li> <a href=""> Обновить </a> </li>
			</ul>
		</nav>
	 </header>
	<h2> Управление каталогами сайта </h2>

	<section class="catas">

	
	
	<ul class="cata_list">
		<?php
			$sql = new sqlConnection();
			echo $sql->fetch_array("SELECT * FROM cata_catalogs","<li id='cata$0' data='$3'>$1</li>");			
		
		?>
	</ul>
	<input type="button" value="Создать каталог" id="newCatalog"/>
	<form>
		<h4> Создать новый каталог:</h4>
		<input type="button" id="hideForm" value="_"/>
		<label>
			Название каталога
			<input type="text" id="cataName" core-controller="maintable"/>
		</label>
	
		<label>
			Вложенность каталога:
			<input type="number" value=1 min=1 max=15 id="nest"/> 
		</label>

		<input type="button" id="check" value="Проверить"/>
		<input type="button" id="create" value="Создать!"/>
	
		<hr/>

		<fieldset class="nest1">
			<label class="maintable_name">
				Название главной таблицы:<br/>
				<span core-var="maintable"></span>_<input type="text" />
			</label>

			<div>	
				<label>
					
					<input type="text" placeholder='Название поля' title="Название поля"/>
				</label>
				<label title="Тип данных поля">
					<select>
						<option selected value="INT"> INT </option>
						<option > FLOAT </option>
						<option> TEXT </option>
						<option> VARCHAR </option>
						<option>  DATETIME </option>
					</select>
				</label>
				<label title="Размерность поля"> ( <input type="number" value="0" min=0 /> )</label>
				<input type="button" value="-" class="rem" level="1"/>
			</div>	
	
			<input type="button" class="addField" value="+" level="1"/>
	
		</fieldset>
	</form>
	</section>
	

	<section class="info">
		<article class="cata_info">
		
		</article>
	</section>
</body>

</html>