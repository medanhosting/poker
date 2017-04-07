<?php
	
	require_once "../../lib/sql_class.php";
	require_once "../catalog_class.php";

	$catalog = new RCatalog($_POST["catalog"]);


	if ($catalog->addItemTo($_POST["parent"], $_POST["level"])) echo "Успешно добавлено.";
?>
<br/>
<img src="img/loading.gif" />