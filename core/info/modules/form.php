<?php
	require "config";
	
	$id= $_GET['id'];
	
	$Q = "SELECT * FROM cata_manual WHERE id=$id";
	$item = $sql->getArray($Q);
	$item=$item[0];
	
?>
<div class='buttons'>
	<input type='button' class='read active'/>
	<input type='button' class='edit'/>	
</div>

<article>
	<h2> <?=$item['title']?></h2>
	
	<?=$item['content']?>
</article>

<form>
	<label>
		<span> Название статьи</span>
		<input type='text' id='title' value='<?=$item['title']?>'/>
	</label>
	
	<label>
		<span> Содержание статьи </span>
		<div class='' contenteditable='true' id='content'>
			<?=$item['content']?>
		</div>
	</label>
	
	<input type='button' id='save' value='Сохранить'/>
</form>