<pre>
<?php
	require_once "../lib/sql_class.php";
	require_once "catalog_class.php";

	#print_r($_POST);
	$name= $_POST["name"];

	$connect = new SQLConnection();
	$catalog = new RCatalog($name);

	print_r($connect->getCatalog($catalog->getTables()));
	
?>
</pre>