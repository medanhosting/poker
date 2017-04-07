<?php
	require_once "../lib/RTemplates.php";
	$catalog = new RCatalog("cata_env");
	
	$TPL="
	<li data-id='\$id'>
		<h2>\$title <span class='name'>(\$name)</span> </h2>
		<p>\$value</p>
	</li>
	";
	echo RTemplates::applyTemplate($catalog->getItemsAt(),$TPL);


?>