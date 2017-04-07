<?php
	require $_SERVER['DOCUMENT_ROOT']."/core/cata/config.inc";
	
	$sql = new SQLConnection;
	
	$data = $sql->fetch_assoc("SELECT * FROM cata_catalogs order by id desc","<li data-id='\$id' data-name='\$name'> <h4>\$name</h4> <div class='buttons'> <input type='button' value='' class='generateCS' data-id='\$id' data-name='\$name'/> <input type='button' value='' class='editCatalog' data-id='\$id' data-name='\$name'/> </div> </li>");
	echo $data;
	
?>