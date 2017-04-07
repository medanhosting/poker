<?php

	if (!isset($id)) $id =$_POST["id"];
	
	require_once "../lib/catalog_class.php";
	$catalog = new RCatalog("cata_templates");
	$item = $catalog->getItemAt($id,1);
	

?>				
				
				
				<form>
				<h3>[<?php echo $item['name']; ?>]</h3>
				<label>
					Заголовок шаблона(его полное название)
					<input type='text' id='title' value='<?php echo $item['title']; ?>'>
				</label>
				<textarea id='template'><?php echo $item['template']; ?></textarea>
				<input type='button' id='saveTpl' value='Сохранить' data-id='<?php echo $item['id']; ?>'/>
				<input type='hidden' value='<?php echo $item['parent']; ?>' id='tplParent'/>
				<?php if($edited) echo "<p class='status'> Изменения сохранены! </p>" ?>
				</form>