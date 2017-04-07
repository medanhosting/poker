<?php
	
	require_once "../../lib/sql_class.php";
	require_once "../../lib/catalog_class.php";

	$catalog = new RCatalog($_POST["catalog"]);
	$id = $_POST["id"];
	$level = $_POST["level"];

	if ($catalog->removeItemAt($id, $level)) echo "Успешно удалено.";
?>
<br/>
<img src="img/loading.gif" />
