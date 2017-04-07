<?php

	include "includes.php";

	$catalog = new RCatalog($name);
	//if ($catalog->getNest()==$nest) {$nest--;}

	$parentId = $id;

	if ($nest) $basicData = $catalog->getChildrenOf($id, $nest-1); else
		$basicData = $catalog->getItemsAt(0);
	
	echo "<h5>Level: ".($nest)."; Parent: $parentId</h5>";
	
		
	if ($nest>0){	
		$item = $catalog->getItemAt($parentId, $nest-1);
		$item=$item[0];

		$parentId = $item["id"];

		echo "<li class='parent' nest='".($nest-1)."' item='$id' cata='".$_POST["catalog"]."' id='goBack'>";
		foreach ($item as $key=>$value){
				echo $key." : ".$value."<br/>";
			}

		echo "</li>";
	}
	
	include "output.php";

	
?>