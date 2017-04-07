<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	$APP_TITLE = "Менеджер файлов ";
	if (file_exists(".uninstalled")){
		header("Location: ./install/");
	}
	require "config";
?>

<!DOCTYPE html>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title> Менеджер файлов </title>

		
		<link rel="stylesheet" href="../css/main.css">
		<link rel="stylesheet" href="../css/icons.css">
		<link rel="stylesheet" href="/core/css/widgets.css">
		<link rel="stylesheet" href="css/main.css">
		
	<link rel="shortcut icon" href="http://app.retarcorp.com/core/favicon.ICO" type="image/x-icon">

	<script type="text/javascript" src="//app.retarcorp.com/js/retarcore.js"></script>
	<script src="js/ace.js" type="text/javascript" charset="utf-8"></script>
	
	<script src="../js/clock.js"></script>
	<script src="js/controller.js"> </script>
	<script src="js/editor.js"> </script>

</head>
<body>
	<header>
	
<?php require_once "../menu.php";?>
	</header>
	

	
	<aside>
		<input type='button' id='hideAside' value=''/>
		<ul data-addr="/">
			<?php require_once "getItemList.php"; ?>
		</ul>
		
	</aside>	
	
	
	
	<section>
		
		<div class='appheader'>
		<form>
			<ol>
				<li><button id='back' title='Назад'> </button></li>
				<li class='path'>	<p class='pathes'> </p> </li>
				<li><button id='changeView' title='Вид'> </button></li>
				<li><button id='paste' title='Вставить'> </button></li>
				<li><button id='addFolder' title='Создать папку'> </button></li>
				<li><button id='addFile' title='Создать файл'> </button></li>
				
			</ol>
		
		</form>
		</div>
	
	
		<ul>
		
		</ul>		
	</section>
	
	<form class='filecontextmenu contextmenu' data-addr=''>
		<ul>
			<li class='edit'>Редактировать</li>
			<li class='rename'>Переименовать</li>
			<li class='copy'>Копировать</li>
			<li class='cut'>Вырезать</li>
			<li class='delete'>Удалить</li>
			<li class='zip here'>Извлечь сюда</li>
			<li class='zip in'>Извлечь в </li>
			<li class='zip userf'>Извлечь в ...</li>
			<li class='properties'>Свойства</li>
			<li class='save'>Скачать</li>
		</ul>
	</form>
	
	<form class='foldercontextmenu contextmenu' data-addr=''>
		<ul>
			
			<li class='rename'>Переименовать</li>
			<li class='copy'>Копировать</li>
			<li class='cut'>Вырезать</li>
			<li class='delete'>Удалить</li>
			<li class='properties'>Свойства</li>
			<li class='zip'>Архивировать</li>
		</ul>
	</form>
	
	<form class='popover'>
	
	</form>

	<form class='editor'>
		<fieldset>
			<span class='status'></span>
			<input type='button' id='editor-save' value='Сохранить'/>
			<input type='text' id='editor-name' value=''/>
			
			<input type='hidden' id='editor-path' value=''/>
			
		</fieldset>
		
		<fieldset>
			<div id='editor'></div>
			<textarea id='editor-content'></textarea>
		</fieldset>
	</form>	
</body>
</html>