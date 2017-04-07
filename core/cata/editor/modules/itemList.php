<?php

	require_once "../../config.inc";

	$name = $_GET['name'];
	
	$id = $_GET[id];
	$nest = $_GET[nest];
	
	$sql = new SQLConnection;
	
	$check = $sql->getArray("SELECT * from cata_catalogs WHERE name='$name'");
	if(!count($check)) die("<h2> Каталога $name не существует!</h2>");
	
	$catalog = new RCatalog($name);
	#print_r($catalog->getTables());
	
	if($nest==-1){
		#Необходимо вернуть все элементы каталога, которые лежат на нулевом уровне.
		$items = $catalog->getItemsAt(0);
		
		echo decorate($items);
	}else{
		# Необходимо вернуть все элементы каталога, которые лежат внутри эл-та с переданными координатами
		$items = $catalog->getChildrenOf($id, $nest);
		
		echo decorate($items);
	}
	
	function decorate($items){
		global $id, $nest, $catalog;
		if($catalog->getNest()==$nest+2){$cl="item";} else $cl="folder";
		$s="";
		
		foreach($items as $i){
			$s.="<li data-id='{$i[id]}' data-nest='".($nest+1)."' data-parent='$id' class='$cl'>";
			$s.="<table> ";
				foreach($i as $k=>$v){
				
					if($k=="id") {
						$s.="<tr class='system'><td data-name='$k'>ID</td> <td><xmp style='white-space: pre-wrap; max-height: 400px; overflow: auto'>$v</xmp></td> </tr>";
						continue;
					}
					if($k=="parent"){
						 $s.="<tr class='system'><td data-name='$k'>PARENT</td> <td><xmp style='white-space: pre-wrap; max-height: 400px; overflow: auto'>$v</xmp></td> </tr>";
						continue;
					}
					if($k=="c_order_id"){
						$s.="<tr class='system'><td data-name='$k'>ORDER_ID</td> <td><xmp style='white-space: pre-wrap; max-height: 400px; overflow: auto'>$v</xmp></td> </tr>";
						continue;
					}
					
					$kk=$catalog->getSkinTitleFor($k, $nest+1);
					 
					$s.="<tr><td data-name='$k'>$kk</td> <td><xmp style='white-space: pre-wrap; max-height: 400px; overflow: auto'>$v</xmp ></td> </tr>";
					
				}
			$s.="</table>";
			$s.="<input type='button' class='remItem'/> <input type='button' class='editItem'/>";
			if($catalog->getNest()==$nest+2) $s.="<p class='stats' title='Элементов внутри'>-</p>";
			else{
				$n = $catalog->getChildrenOf($i[id], $nest+1);
				$n=count($n);
				$s.="<p class='stats' title='Элементов внутри'>$n</p>";
			}
			$s.="</li>";
		}
		
		return $s; 
	}
?>