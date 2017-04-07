<?php
	require_once "../config";
	$html = addslashes($_POST[html]);
	$id = $_POST[id];
	$gen = $_POST[gen];
	
	$title = addslashes($_POST[title]);
	$keywords = addslashes($_POST[keywords]);
	$description = addslashes($_POST['description']);
	
	#print_r($_POST[id]);
	
	$sql->query("UPDATE $table SET body='$html', title='$title', keywords='$keywords', description='$description' WHERE id=$id");
	echo mysqli_error();
	
	function getInclusion($path){
	
		return "<"."?"."php require_once \$_SERVER[DOCUMENT_ROOT].'/".$path."' ?".">";
	}
	
	
	#Rebuilding page
		$content = $sql->getAssocArray("SELECT body, head, url, keywords, description, title from $table WHERE id=$id");
		$content = $content[0];
		
		$gen = preg_replace("/\[\@\|(.*)\|\@]/","<"."?"."php require_once \$_SERVER[DOCUMENT_ROOT].'/$1' ?".">",$gen);
		$content[head] = preg_replace("/\[\@\|(.*)\|\@]/","<"."?"."php require_once \$_SERVER[DOCUMENT_ROOT].'/$1' ?".">",$content[head]);
		
		#$content[body]=implode($body,'');
		
		
		$page="<html>";
			$page.="\n\t<head>";
				$page.="\n\t\t<meta charset='utf-8'/>";
				if($content[title][0]!='#') $page.="\n\t\t<title> {$content[title]}</title>";
				if($content[keywords][0]!='#')$page.="\n\t\t<meta name='keywords' content='{$content[keywords]}'/>";
				
				if($content[description][0]!='#') $page.="\n\t\t<meta name='desription' content='{$content[description]}'/>";
				
				$page.=$content[head];
			$page.="\n\t</head>\n";
			
			$page.="\t<body> ".stripslashes($gen)." </body>";
		$page.="</html>";
		
		$link = $content["url"];
		$link = explode("/",$link);
		$pageName = $link[count($link)-1];
		if (strpos($pageName,'.')===false){
			$pageName='';
		}
		$dir = str_replace($pageName,'',$content["url"]);
		if ($pageName=='') $pageName='index.php';
		
		
		if (!is_dir($_SERVER["DOCUMENT_ROOT"].$dir)) mkdir($_SERVER["DOCUMENT_ROOT"].$dir,0777,true);
		file_put_contents($_SERVER["DOCUMENT_ROOT"].$dir."/".$pageName,$page);
		
?>