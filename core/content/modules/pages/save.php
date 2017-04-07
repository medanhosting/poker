<?php
	require "config";
	$id = $_GET[id];
	
	$template = $_GET[template];
	unset($_GET[template]);	

	$url = $_GET["url"];
	
	$c=  $sql->getArray("SELECT * FROM $table WHERE url='$url' AND id!=$id");
	if(count($c)) die("Страница с таким URL-адресом уже существует!");

	
	$c=  $sql->getArray("SELECT * FROM $table WHERE url='/$url' AND id!=$id");
	if(count($c)) die("Страница с таким URL-адресом уже существует!");

	
	$c=  $sql->getArray("SELECT * FROM $table WHERE url='$url/' AND id!=$id");
	if(count($c)) die("Страница с таким URL-адресом уже существует!");

	
	foreach($_GET as $k=>$v){
		if($k=='id') continue;
		$sql->query("UPDATE $table SET `$k`='$v' WHERE id=$id");
	}
	
	$oldTpl = $sql->fetch_array("SELECT template FROM $table WHERE id=$id","$0");
	
	
	if($oldTpl!=$template){
		#Action when page template has changed
		
		#Getting template
		$template = $templates->getItemAt($template, 1);
	
		
		$head = $template[head];
		$body = $template[body];
	
		#Rewriting HTML in DataBase
		$sql->query("UPDATE $table SET `head`= '".addslashes($head)."' WHERE id=$id");
		$sql->query("UPDATE $table SET `body`= '".addslashes($body)."' WHERE id=$id");

		
		#Reset template in DataBase
		$sql->query("UPDATE $table SET `template`='{$template[id]}' WHERE id=$id");		
		
	}
	
	{
		#Rebuilding page
		$content = $sql->getAssocArray("SELECT body, head, url from $table WHERE id=$id");
		$content = $content[0];
		
		$page="<html>";
			$page.="<head>";
				$page.="<meta charset='utf-8'/>";
				$page.="<title> {$_GET[title]}</title>";
				$page.="<meta name='keywords' content='{$_GET[keywords]}'/>";
				
				$page.="<meta name='desription' content='{$_GET[description]}'/>";
				$page.=$content[head];
			$page.="</head>";
			
			$page.="<body> {$content[body]} </body>";
		$page.="</html>";
		
		$link = $content["url"];
		$link = explode("/",$link);
		$pageName = $link[count($link)-1];
		if (strpos($pageName,'.')===false){
			$pageName='';
		}
		$dir = str_replace($pageName,'',$content["url"]);
		if ($pageName=='') $pageName='index.php';
		#echo $dir.'-'.$pageName;
		
		if (!is_dir($_SERVER["DOCUMENT_ROOT"].$dir)) mkdir($_SERVER["DOCUMENT_ROOT"].$dir,0777,true);
		file_put_contents($_SERVER["DOCUMENT_ROOT"].$dir."/".$pageName,$page);
		
		
	}
	
	if(!mysqli_error()) echo "Сохранено успешно!"; else echo "Ошибка сохранения!";

?>