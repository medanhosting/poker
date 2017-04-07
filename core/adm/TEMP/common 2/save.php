
<?php

	require_once "config";


	$level = $_POST['cata_level'] ? $_POST['cata_level'] : 0;
	unset($_POST['cata_level']);
	
	$E = $EDITABLE[$level];
	
	foreach($E as $k){
		$skin = $catalog->getSkinFor($k, $level);		
		$type = $skin[type];
		$val = $_POST[$k];
		
		
		#Wrapping data to writeable condition for database
		switch ($type){
		
			case "TEXTLINE":
			case "LINK":
			case "VARCHAR(100)":
			case "PTEXT":
			case "TEXT":
			case "FTEXT":
			case "CTEXT":
			case "MEDIUMTEXT":{
				$_POST[$k] = addslashes($val);
				break;
			}
		}
	}
	
	
	$catalog->editValuesOf($_POST['id'],$level,$_POST);
	echo mysqli_error();
	
	if (!mysqli_error()) echo "Сохранено успешно!";

?>