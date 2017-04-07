<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/catalog_class.php";
	$APP_TITLE = "Редактор шаблонов";
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>Редактор шаблонов | Retar Core v 1.17</title>
		
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
	
		<div class='wrapper'>
			<section class='folder_list'>
			<ul>
<?php
	require_once "getFolders.php";

?>			</ul>
			<form>
				<input type='button' id='addFolder' value='+'/>
			</form>
			</section>
			
		
			<section class='edit_tpl'>
				<!--form>
				<h3>[template_name]</h3>
				<label>
					Заголовок шаблона(его полное название)
					<input type='text' id='title' value=''>
				</label>
				<textarea id='template'></textarea>
				<input type='button' id='saveTpl' value='Сохранить'/>
				</form-->
			<section>
		</div>
		
	</body>

</html>