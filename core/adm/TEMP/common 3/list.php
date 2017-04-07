<?php

	require_once "config";
	
	
	$items = $catalog->getItemsAt(0);
	$level = $_GET['level'] ? $_GET['level'] : 0;
	
	if ($level){
		$items = $catalog->getChildrenOf($_GET['id'], $level-1);
	}
	if($level==2){
	
		$parent = $catalog->getItemAt($_GET['id'],1);
		echo "<input type='button' class='addItem' value='+'/> 
		<h3> Позиция:  {$parent['title']}</h3>
		<ol data-parent='{$_GET['id']}'>";
	}
	
	if($level==1) echo "<input type='button' class='addSub' value='+'/>";
	foreach($items as $item){
		$data="";
		
		foreach ($DISPLAYED[$level] as $k=>$v){	
			
			switch ($v){
				case "img":{
					$data.=RImages::getImage($item[$k]);
					break;
				}
				default: {
					$data.="<$v>{$item[$k]}</$v>";
					break;
				}
			}
		}
		
		$sublist = $level<1? "<div class='sublist' data-parent='\$id'><ol data-parent='\$id'></ol></div>" : "";
		$list = $level==1 ? "<input type='button' class='openList' data-parent='\$id' title='Редактировать фотогалерею товара'/>" : "";
		$tpl="
			<li data-id='\$id' class='item'> 			
			<div class='clickable'>$data
				<div class='btns'>
					
					<input type='button' value='X' class='remove' data-id='\$id' />
					$list
				</div>
			
			</div> 
			
			$sublist
			</li>";
	
		echo RTemplates::applyTemplate(array($item), $tpl);
	}
	if($level==2) echo "</ol>";

	
		
?>