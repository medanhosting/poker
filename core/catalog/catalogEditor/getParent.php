<?php

	include "includes.php";

	
	
	$basicData = $catalog->getSiblingsOf($id, $nest);
	$parentId = $id;
	
	

	 echo "<h5>Level: ".($nest)."; Parent: $id</h5>";

	if ($nest>=1) {
		
		$parent = $catalog->getParentOf($parentId, $nest);
		$item = $catalog->getItemAt($parent, $nest-1);
		$item=$item[0];

		echo "<li id='goBack' class='parent' nest='".($nest-1)."' item='".$basicData[0]["id"]."' cata='".$_POST["catalog"]."' id='goBack'>";

		$parentId = $item["id"];
		$parentParent = $item["parent"];

		foreach ($item as $key=>$value){
				#if (($key=='parent')||($key=='id')) continue;
				echo $key." : ".$value."<br/>";
			}

		echo "<hr/></li>";
	}

	include "output.php";

?>