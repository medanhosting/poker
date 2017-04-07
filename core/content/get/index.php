<?php
	require "../config";
	$id = $_SERVER[QUERY_STRING];

	{
		#Rebuilding page
		$content = $sql->getAssocArray("SELECT * from $table WHERE id=$id");
		$content = $content[0];
		
		
		
		$content[body]= preg_replace("/\[\@\|(.*)\|\@]/","<dynamic>$1</dynamic>",$content[body]);
		
		
		function getcontent($a){
			return file_get_contents($_SERVER['DOCUMENT_ROOT'].$a);
		}
		$content[head]= preg_replace_callback("/\[\@\|(.*)\|\@]/","getcontent",$content[head]);
		
		#echo $_SERVER['DOCUMENT_ROOT'].trim($content[head]);
		#$content[head] = file_get_contents($_SERVER['DOCUMENT_ROOT'].$content[head])."!";
		
		
		$page="<html>";
			$page.="<head>";
				$page.="<meta charset='utf-8'/>";
				if ($content[title][0]!='#') $page.="<title> {$content[title]}</title>";
				if ($content[keywords][0]!='#') $page.="<meta name='keywords' content='{$content[keywords]}'/>";				
				if ($content[description][0]!='#') $page.="<meta name='desription' content='{$content[description]}'/>";
				$page.=$content[head];
			$page.="</head>";
			
			$page.="<body> {$content[body]} </body>";
		$page.="</html>";
		
		echo $page;
	}
?>