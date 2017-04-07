<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RCatalog.php";
	$APP_TITLE = "Редактор содержимого";
	
	$id =$_SERVER[QUERY_STRING];
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>Управление содержимым | Retar Core v 1.18</title>
		
		<script src='/core/lib/js/retarcore.js'></script>
		<script src='js/controller.js'> </script>
		<script src='/core/js/clock.js'> </script>
		
		<script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
		
		<link rel='stylesheet' href='/core/css/main.css'/>
		
		<link rel='stylesheet' href='css/main.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once "modules/header.php"; ?>
		</header>

		
		<section class='content w_form'>
			
			<iframe src='/core/content/get?<?=$id?>' id='field'></iframe>
			<div id='layout'> <div class='miniLoader'> <p> </p> </div> </div>
		</section>
		
		<aside class='instruments'>
		
		</aside>
		
		<div id='listedContext'>
			
				<input type='button' value='C' id='copyListed'/>
				<input type='button' value='X' id='removeListed' />
		
		</div>
		
		<div id='atomicContext'>
			<div id='imgContext'>
				<label> <span> Описание картинки для поиска</span> <input type='text' value='' id='imgAlt'/></label>
				<label> <span> Загрузить другую картинку </span> <form enctype='multipart/form-data'><input type='file' id='imgSrc' name='imgSrc'/> </form></label>
				<input type='button' value='Сохранить' id='imgSave'/>
			</div>
			
			<div id='aContext'>
				<label> <span> Адрес ссылки </span> <input type='text' value='' id='aHref'/></label>
				<label> <span> Описание ссылки для поиска </span> <input type='text' value='' id='aTitle'/></label>
				<label> <input type='checkbox' value='' id='aNofollow'/> <span> Неиндексируемая ссылка </span> </label>
				<label> <input type='checkbox' value='' id='aTargetblank'/> <span> В новой вкладке </span> </label>
				
				<input type='button' value='Сохранить' id='aSave'/>
			</div>
			
			<div id='iContext'>
				<textarea id='iframe'></textarea>
				<input type='button' value='Сохранить' id='aSave'/>
			</div>
		</div>
		
		<div id='popupContext'>
			<div id='editorContext'>
				<div id='ckeditor'> </div>
				<input type='button' id='ckaccept' value='Принять'/>
			</div>
		</div>
	</body>

</html>