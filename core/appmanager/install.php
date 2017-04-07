<?php 

	require_once $_SERVER[DOCUMENT_ROOT]."/core/lib/system/System.php";
	require_once $_SERVER[DOCUMENT_ROOT]."/core/lib/RCatalog.php";

	$app = AppManager::getRemoteAppInfo($_GET['name']);	
	if(!count($app)) die("Error: Application not found in applist");
	
	try{
		if(AppManager::installRemoteApp($app)) echo("OK");
	}catch(Exception $e){
		die($e->getMessage());
	}
	
	
?>