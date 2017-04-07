<?php
	
	$id = $_POST["id"];
	
	require_once "../lib/RTemplates.php";
	
	$data = file_get_contents("http://app.retarcorp.com?key=1");
	$data = explode("[|]",$data);
	
	$items= str_replace("\n","", $data[1]);		
	$items= json_decode($items,true);
	
	$app=array();
	
	foreach ($items as $item){
		if ($item["id"]==$id){
			$app = $item;
			break;
		}
	}
	
	if (file_put_contents($app["name"]."-temp.zip",file_get_contents($app["archive"]))){
	
		echo	"Приложение загружено. <br/>Распаковка. ";
		
		$zip = new ZipArchive;
    	$zip->open($app["name"]."-temp.zip");
    	$zip->extractTo('../');
    	$zip->close();
		unlink($app["name"]."-temp.zip");
    	echo "<br/>Приложение распаковано. <a style='color: #6DC; text-decoration: underline;' href='../{$app["name"]}'>Установка</a>";
		
		$appcatalog = new RCatalog("cata_apps");
		file_put_contents("../img/".$app["name"].".png",file_get_contents($app["icon"]));		
		$data = array($app["name"],$app["title"],$app["name"].".png",$app["name"]."/",$app["version"],$app["info"],$app["type"]);
		$appcatalog->addItem($data,2,0);
		
	}else echo "Ошибка установки! Обновите страницу и попробуйте снова.";
	
	
?>