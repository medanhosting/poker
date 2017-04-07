<?php

	require_once "config";
	
	$level = $_POST['level'];
	if(!$level) $level = 0;
	$item = $catalog->getItemAt($_POST['id'], $level);
	
	echo "<fieldset>";
	echo "<input type='button' value='Сохранить' id='save'/>";

	if($level==2){
		echo "<input type='button' value='Назад к галерее товара' id='reloadItems' data-element='{$item['id']}'/>";
	}
	echo "</fieldset>";
	
	$E = $EDITABLE[$level];
	
	
	echo "<fieldset>";
	foreach($E as $k){
		$skin = $catalog->getSkinFor($k, $level);
		echo "<label class='global'> <span> {$skin[title]} </span> ";
		$type = $skin[type];
		$val = $item[$k];
		
		
		#Unwrapping data from DB look
		switch ($type){
		
			case "TEXTLINE":
			case "LINK":
			case "VARCHAR(100)":
			case "PTEXT":
			case "TEXT":
			case "FTEXT":
			case "CTEXT":
			case "MEDIUMTEXT":{
				$_POST[$k] = stripslashes($val);
				break;
			}
		}
		
		
		switch ($type){
		
			case "TEXTLINE":
			case "LINK":
			case "VARCHAR(100)":{
				echo "<input type='text' id='$k' value='$val' data-edit='$k'/> ";
				break;
			}
			
			case "PTEXT":
			case "TEXT":{
				echo "<textarea id='$k' data-edit='$k'>$val</textarea>";
				break;
			}
			
			case "IMAGE":{
				echo "<input type='hidden' value='$val' id='$k' data-edit='$k'/>";
				break;
			}
			
			case "NUMBER":
			case "INT":
			case "TINYINT":
			case "BOOL":{
				echo "<input type='number' value='$val' id='$k' data-edit='$k'/>";
				break;
			}
			case "CFLOAT":
			case "FLOAT":{
				echo "<input type='number' value='$val' id='$k' step='0,01' data-edit='$k'/>";
				break;
			}
				
			
			case "FTEXT":
			case "CTEXT":
			case "MEDIUMTEXT":{
				echo "<div class='ckeditor' data-id='$k'> <div id='$k' data-edit='$k'></div> <div class='hidden'>$val</div> </div>";
				break;
			}
			
			case "DATETIME":
			case "CDATETIME":{
				$val = strtotime($val);
				$val = date("Y-m-d",$val)."T".date("H:i",$val);
				echo "<input type='datetime-local' value='$val' id='$k' data-edit='$k'/>";
				break;
			}
			
			default:{
				
				echo "<textarea id='$k' data-edit='$k'>$val</textarea>";
				break;
			}
			
		
		}
		
		echo "</label>";
	}
	
	
	echo "</fieldset>";