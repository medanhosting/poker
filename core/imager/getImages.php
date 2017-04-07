<ul>
<?php
	require_once "../lib/sql_class.php";
	require_once "../lib/RCatalog.php";
	require_once "config";

	$id= $_POST["id"];
	$catalog = new RCatalog("cata_images");

	$data = $catalog->getChildrenOf($id,0);
	echo mysqli_error();
	
	
	foreach($data as $item){
		echo "<li><span class='close'>X</span><img src='$PATH/".$item['url']."'><small> ".$item['id']." </small>   <h3> ".$item['title']."</h3> <p>".$item['description']."</p></li> ";
	}

?>
</ul>