<?php

	require_once "config";
	
	$level = $_POST['level'];
	if(!$level) $level = 0;
	$item = $catalog->getItemAt($_POST['id'], $level);
	
	echo "<input type='button' value='Сохранить' id='save'/> ";
	
	if($level==1){
		echo "<p class='htbtns'><input type='button' value='HEAD' id='openHead' class='inline'/> <input type='button' value='BODY' id='openBody' class='inline'/></p>";
	}
	
	
	$E = $EDITABLE[$level];
	
	foreach($E as $i=>$k){
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
				
				echo "<input type='text' id='$k' value='$val'/> ";
				break;
				
				
			}
			
			case "PTEXT":
			case "TEXT":{
				echo "<textarea id='$k'>$val</textarea>";
				break;
			}
			
			case "IMAGE":{
				echo "<input type='number' value='$val' id='$k'/>	<div class='cImager'></div>";
				break;
			}
			
			case "NUMBER":
			case "INT":
			case "TINYINT":
			case "BOOL":{
				echo "<input type='number' value='$val' id='$k'/>";
				break;
			}
			
			case "FTEXT":
			case "CTEXT":
			case "MEDIUMTEXT":{
				echo "<textarea id='$k' class='editor'>$val</textarea>";
				break;
			}
			
			case "DATETIME":
			case "CDATETIME":{
				$val = strtotime($val);
				$val = date("Y-m-d",$val)."T".date("H:i",$val);
				echo "<input type='datetime-local' value='$val' id='$k'/>";
				break;
			}
			
			default:{
				
				echo "<textarea id='$k'>$val</textarea>";
				break;
			}
			
		
		}
		
		echo "</label>";
	}
	
	
	
	
?>