<?php
	require "config";
	
	$parent = $_GET['parent'];
	
	$Q = "SELECT * FROM cata_manual WHERE parent=$parent ORDER BY `type` DESC, `title`";
	$items = $sql->getArray($Q);
	
	
	foreach($items as $i){
		if($i['type']*1===1){
			echo "<li class='folder' data-id='{$i['id']}' data-parent='{$i['parent']}'>
				<div class='clickable'>
					<h4 title='{$i['title']}'> {$i['title']}</h4>
				</div>
				
				<ul data-parent='{$i['id']}'>
				
				</ul>
			</li>";
			
			
		}else{
		
			echo "<li class='file' data-id='{$i['id']}' data-parent='{$i['parent']}'>
				<div class='clickable'>
					<h4 title='{$i['title']}'> {$i['title']}</h4>
				</div>
				
			</li>";
		}
	}
	
	echo "
		<input type='button' class='addFolder' data-parent='$parent'/>
		<input type='button' class='addFile' data-parent='$parent'/>
	";