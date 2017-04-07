<?php
	require_once $_SERVER[DOCUMENT_ROOT]."/core/lib/RCatalog.php";
	$sql = new SQLConnection();
	$id = $_SERVER['QUERY_STRING'];
	
	$data = $sql->getArray("SELECT * FROM cata_content_pages WHERE id=$id");
	#print_r($data);
	$data = $data[0];
	
?>

<header class='w_form'>
	<div class='general'>
		<a href='<?=$data['url']?>' class='button' id='link' target='_blank' title='Открыть на сайте'> </a>
		<input type='button' value='settings' id='settings' title='Настройки страницы'/>
		
		<input type='text' id='title' value='<?=$data[title]?>'>
		<input type='button' value='save' id='save' title='Сохранить изменения'/>
	</div>
	
	<div class='side'>
		<input type='button' value='close' id='close' title='Закрыть окно редактирования'/>
	</div>
	
	<div id='mainContext'>
		<label> <span>Ключевые слова </span>	<textarea id='keywords'><?=$data['keywords']?></textarea> </label>
		<label> <span>Метаописание </span>	<textarea id='description'><?=$data['description']?></textarea> </label>
		<input type='button' id='submit' value='Принять'/>
	</div>
</header>