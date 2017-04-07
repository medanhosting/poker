<?php
	
	require "config";
	$id = $_GET[id];
	
	$data = $sql->getArray("SELECT * FROM $table WHERE id=$id");
	
	#print_r($data);
	$data=$data[0];
	
	$templ = $data[template];
	
	
	
	
	if($templ ==0){
		$tpls='<option value=0> Выберите шаблон! </option>';
	}else {
		$parent = $templates->getParentOf($templ, 1);
		$items = $templates->getChildrenOf($parent, 0);
		$s="";
		foreach($items as $tpl){
			$s.="<option value='{$tpl[id]}'> {$tpl[title]}</option>";
			if ($tpl[id]==$templ){
				$s.="<option value='{$tpl[id]}' selected> {$tpl[title]}</option>";
			}else
			$s.="<option value='{$tpl[id]}'> {$tpl[title]}</option>";
		}
		$tpls=$s;
	}
	
	$templateFolders = $templates->getItemsAt(0);
	$s="<option value=0 disabled selected> Выберите папку </option>";
	foreach($templateFolders as $tpl){
		$s.="<option value='{$tpl[id]}'> {$tpl[title]}</option>";
	}
	$templateFolders = $s;
?>

<fieldset>
	<a href='<?=$data[url]?>' target='_blank' class='openLink'> Открыть страницу </a>
	<label>
		Заголовок страницы
		<input type='text' value='<?=$data[title]?>' id='title' />
	</label>
	
	<label>
		Метаописание страницы
		<textarea id='description'><?=$data[description]?></textarea>
	</label>
	
	<label>
		Метаключи страницы
		<textarea id='keywords'><?=$data[keywords]?></textarea>
	</label>
</fieldset>

<fieldset>
	<label>
		URL страницы относительно корня
		<input type='text' value='<?=$data[url]?>' id='url'/>
	</label>
	<div>

			Шаблон страницы
			<select id='templateFolder'>
				<?=$templateFolders?>
			</select>
			<select id='template'>
				<?=$tpls?>
			</select>		
		
	</div>
	
</fieldset>

<fieldset>
	<input type='button' value='Сохранить параметры страницы' id='save'/>
	<a href='editor?<?=$data[id]?>' target='_blank'> Открыть редактор страницы </a>
</fieldset>