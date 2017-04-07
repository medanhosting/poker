<?php
	require_once "../lib/RTemplates.php";
	
	$catalog = new RCatalog("cata_templates");
	$items = $catalog->getItemsAt(0);
	
	$tpl="
		<li data-id='\$id'>
			<h3> \$name</h3>
			<span> <button class='deleteFolder' data-id='\$id'>X</button> </span>
			<ul></ul>	
		</li>	
	";
	
	echo RTemplates::applyTemplate($items,$tpl);


?>