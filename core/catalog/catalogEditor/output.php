<?php
	
	foreach($basicData as $item){
			echo "<li nest='".($nest)."' item='".$item["id"]."' parent='".$item["parent"]."' cata='".$_POST["catalog"]."'>";
			
			echo "<table>";
				foreach ($item as $key=>$value){
				if (($key=='parent')||($key=='id')) continue;
				echo "<tr><td class='key'>$key</td><td class='value'><article>$value</article></p></tr>";
			}
			echo"</table>";
			echo "<div class='tabs'><input type='button' class='info' data-id='".$item['id']."' value='i'/><input type='button' class='delete' data-id='".$item['id']."' value='X'/></div>";
			echo " </li>";
		}

	echo "<p class='add'> Добавить элемент </p>";

	echo "<input type='hidden' id='currentParent' value='$parentId' />";
	echo "<input type='hidden' id='currentNest' value='".($nest)."'>";
	echo "<input type='hidden' id='maxNest' value='".($catalog->getNest())."'>";
	$json = $catalog->getSchemaJSON($nest);
	echo "<input type='hidden' id='schema' value='$json'>";
?>