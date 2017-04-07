<?php

	require_once "config";
	
	
	$items = $catalog->getItemsAt(0);
	$level = 0;

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
		
		
		
		$tpl="
			<li data-id='\$id' class='item'> 			
			$data 
			<div class='btns'>
				
				<input type='button' value='X' class='remove' data-id='\$id' />
			</div>
			</li>";
	
		echo RTemplates::applyTemplate(array($item), $tpl);
	}
	

?>