<?php
	require_once $_SERVER[DOCUMENT_ROOT]."/core/lib/sql_class.php";
	$sql = new SQLConnection;
	
	if (!$id) $id = $_GET['id'];
	
	
	if(!$id){
		$data = $sql->getArray("SELECT * FROM cata_content_pages WHERE parent=0");
	}else{
		$data = $sql->getArray("SELECT * FROM cata_content_pages WHERE parent=$id");
	}
	
	foreach($data as $page){
		echo "<li data-id='{$page[id]}'> <h3> <span>{$page[title]}</span> <input type='button' value='X' class='removePage' data-id='{$page[id]}'/> </h3>  <ol data-parent='{$page[id]}'> </ol> </li>";
	}
	if($id){
		echo "<input type='button' class='addPage' data-parent='$id' value='+'/>";
	}
?>