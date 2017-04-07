<?php

	$cname = $_POST["__catalog"];
	$nest = $_POST["__nest"];
	$id = $_POST["id"];

	unset($_POST["__catalog"]);
	unset($_POST["__nest"]);
	unset($_POST["id"]);

	print_r($_POST);
	foreach($_POST as $key=>$value){$_POST[$key] = addslashes($value);}

	require_once "../../lib/sql_class.php";
	require_once "../catalog_class.php";
	
	$catalog = new RCatalog($cname);
	if ($catalog->editValuesOf($id, $nest, $_POST)){
		echo "<p> Объект каталога успешно изменен! </p>";
	}echo mysqli_error();
	
?>