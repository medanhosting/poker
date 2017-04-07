<?php
	#Checks if catalog exists.

	require $_SERVER['DOCUMENT_ROOT']."/core/cata/config.inc";
	
	$sql = new SQLConnection;
	$name= $_GET['name'];
	$data=$sql->getArray("select * from cata_catalogs where name='$name'");
	if(!count($data)) echo "";
	else{
		echo "<p class='warn'> Каталог уже существует! </p>";
	}
?>