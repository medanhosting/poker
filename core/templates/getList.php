<?php
	require_once "../lib/RTemplates.php";
	if(!isset($id)) $id=$_POST['id'];
	
	$catalog = new RCatalog("cata_templates");
	$items = $catalog->getChildrenOf($id);
	
	$tpl="
		<li data-id='\$id'>
			<h4>[\$id:0][\$name] \$title</h4>
			<span> <button class='deleteItem' data-id='\$id'>X</button> </span>		
		</li>	
	";
	
	echo RTemplates::applyTemplate($items,$tpl);
	
	
?>