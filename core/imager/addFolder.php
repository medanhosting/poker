<?php
	require_once "../lib/RCatalog.php";	
	$catalog = new RCatalog("cata_images");
	if (isset($_POST["name"]))$catalog->addItem(array($_POST["name"]));	
	$data = $catalog->getItemsAt();	
	foreach($data as $item){
		echo "<li> <a href='#' id='".$item["id"]."'> ".$item["name"]." </a> </li>";
	}
?>