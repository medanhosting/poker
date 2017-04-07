<?php

	require_once "../../config.inc";


	
	$id = $_POST[id];
	$nest = $_POST[nest];
	$name = $_POST['cnm'];
	if(isset($_POST[head])) $_POST['head'] = addslashes($_POST[head]);
	if(isset($_POST[body])) $_POST['body'] = addslashes($_POST[body]);

	unset($_POST['cnm']);
	unset($_POST['nest']);
	
	$catalog = new RCatalog($name);
	
	$catalog->editValuesOf($id, $nest, $_POST);
	echo mysqli_error();
	
	$i = $catalog->getItemAt($id, $nest);
	#print_r($i);
	
	foreach($i as $k=>$v){
		if($k=="id") {
						echo "<tr class='system'><td data-name='$k'>ID</td> <td><xmp style='white-space: pre-wrap; max-height: 400px; overflow: auto'>$v</xmp></td> </tr>";
						continue;
					}
					if($k=="parent"){
						 echo "<tr class='system'><td data-name='$k'>PARENT</td> <td><xmp style='white-space: pre-wrap; max-height: 400px; overflow: auto'>$v</xmp></td> </tr>";
						continue;
					}
					if($k=="c_order_id"){
						echo "<tr class='system'><td data-name='$k'>ORDER_ID</td> <td><xmp style='white-space: pre-wrap; max-height: 400px; overflow: auto'>$v</xmp></td> </tr>";
						continue;
					}
					
		$kk = $catalog->getSkinTitleFor($k,$nest);
		echo "<tr><td data-name='$k'>$kk</td> <td>$v</td> </tr>";
	}
?>