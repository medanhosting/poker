<?php
	require "config";
	$item = $catalog->getItemAt($_GET['id'],1);
?>

<input type='hidden' id='image' name='image' value='<?=$item['image']?>'/>
<label>
	<span>Название элемента</span>
	<input type='text' id='title' value='<?=$item['title']?>'/>
</label>

<label>
	<span>Замещающий текст для картинки</span>
	<input type='text' id='alt' value='<?=$item['alt']?>'/>
</label>

<label>
	<span>Адрес ссылки элемента</span>
	<input type='text' id='href' value='<?=$item['href']?>'/>
</label>

<input type='button' id='save' value='Принять'/>