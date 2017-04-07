<?php
	require "config";
	$item = $catalog->getItemAt($_GET['id'],0);
	
?>

<label>
	<span> Название слайдера </span>
	<input type='text' id='title' value='<?=$item['title']?>'/>
</label>

<input type='button' id='save' value='Принять'/>