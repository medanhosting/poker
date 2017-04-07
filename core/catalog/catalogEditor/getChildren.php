<?php

	include "includes.php";
	if ($catalog->getNest()==$nest) {$nest--;}

	$basicData = $catalog->getChildrenOf($id, $nest);
	echo "<h5>Level: ".($nest+1)."; Parent: $id</h5>";
	
		
		
		$item = $catalog->getItemAt($id, $nest);
		$item=$item[0];

		echo "<li class='parent' nest='$nest' item='$id' cata='".$_POST["catalog"]."' id='goBack'>";
		$parentId = $item["id"];
	
		foreach ($item as $key=>$value){
				#if (($key=='parent')||($key=='id')) continue;
				echo $key."=>".$value."<br/>";
			}

		echo "<hr/></li>";
	$nest++;
	include "output.php";
	

	
?>