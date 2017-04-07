<h5> Изменить информацию об элементе:</h5>
<?php

	require_once "../../lib/sql_class.php";
	require_once "../catalog_class.php";

	$id = $_POST["parent"];
	$nest = $_POST["level"];
	$cname = $_POST["catalog"];
	echo "<p> Системный идентификатор: $id. Уровень вложенности: $nest</p>";
	$catalog = new RCatalog($cname);
	$schema= $catalog->getSchemaJSON($nest);
	$data = $catalog->getItemAt($id, $nest);
	$data=$data[0];
	

	foreach($data as $key => $value){
	if ($key=="id") continue;
	if ($key=="parent") continue;

	if(strpos($schema[$key],"FLOAT")!==false)
		echo '<label>'.$key.'<input type="text" value="'.$value.'" id="'.$key.'"/></label>';
	
	if(strpos($schema[$key],"DATETIME")!==false)
		echo '<label>'.$key.'<input type="text" value="'.$value.'" id="'.$key.'"/></label>';
	
	if(strpos($schema[$key],"VARCHAR")!==false)
		echo '<label>'.$key.'<textarea id="'.$key.'">'.$value.'</textarea></label>';
	
	
	if(strpos($schema[$key],"TEXT")!==false)
		echo '<label>'.$key.'<pre contenteditable="true" id="'.$key.'">'.$value.'</pre></label>';
	

	if(strpos($schema[$key],"INT")!==false)			
 		echo '<label>'.$key.'<input type="number" value="'.$value.'" id="'.$key.'"/></label>';
		
	}
	

echo "<input type='button' id='applyChanges' nest='$nest' cata='$cname' json='".json_encode($schema)."' cid='$id' value='Сохранить изменения'/>";
?>