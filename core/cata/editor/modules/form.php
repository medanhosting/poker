<?php

	require_once "../../config.inc";
	#print_r($_GET);
	$name = $_GET['name'];
	
	$id = $_GET[id];
	$nest = $_GET[nest];
	
	$sql = new SQLConnection;
	
	$check = $sql->getArray("SELECT * from cata_catalogs WHERE name='$name'");
	if(!count($check)) die("<h2> Каталога $name не существует!</h2>");
	
	$catalog = new RCatalog($name);
	
	$item =$catalog->getItemAt($id, $nest);
	
	#print_r($item);
	$j = $catalog->getSchemaJSON();
	$j = json_decode($j,true);
	$j=$j[$nest];
	
	foreach($item as $k => $v){
		if($k=="id") continue;
		if($k=="parent") continue;
		if($k=="c_order_id") continue;

		
		if(($j[$k]=='TEXT')||($j[$k]=='MEDIUMTEXT')||($j[$k]=='LONGTEXT')){
			$kk = $catalog->getSkinTitleFor($k,$nest);
			echo "<tr class='editable big'><td data-name='$k'>$kk</td> <td><textarea data-name='$k'>$v</textarea></td> </tr>";}
		else if(strpos($j[$k],'VARCHAR')!==false){
			$kk = $catalog->getSkinTitleFor($k,$nest);
			echo "<tr class='editable medium'><td data-name='$k'>$kk</td> <td><textarea data-name='$k'>$v</textarea></td> </tr>";
		}			
		else{
			$kk = $catalog->getSkinTitleFor($k,$nest);
			echo "<tr class='editable small'><td data-name='$k'>$kk</td> <td><textarea data-name='$k'>$v</textarea></td> </tr>";
		} 
			
	}
	
	
?>