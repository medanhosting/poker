<?php
	$name = $_POST["name"];
	$id= $_POST['id'];
	
	require_once "../lib/RTemplates.php";
	$catalog = new RCatalog("cata_templates");
	
	$data = "";
	$data[0]=$name;
	$data[1]=$name;
	$data[2]=0;
	$data[3]=" ";
	
	$catalog->addItem($data,$id,0);
	echo mysqli_error();
	
	require_once "getList.php";

?>