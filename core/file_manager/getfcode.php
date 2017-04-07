<?php
	include "../lib/funclib.php";
	chdir("/".$_COOKIE["dir"]);
 $CONTENT = file_get_contents("/".$_COOKIE["dir"].$_POST['filename']);

	$NAME = $_POST["filename"];

	$EX = explode(".",$NAME);
	$EX = $EX[1];
	
	
	$CONTENT = str_replace("&","&amp;",$CONTENT);
	$CONTENT = str_replace("<","&lt;",$CONTENT);
	$CONTENT = str_replace(">","&gt;",$CONTENT);
	$CONTENT = str_replace("	","&emsp;&emsp;", $CONTENT);
	/*$CONTENT = str_replace("
","<br/>",$CONTENT); */

	

/*	if (($EX == "php")||($EXT=".html")){$CONTENT = produce_html($CONTENT);}
	if ($EX == "php") {$CONTENT = produce_php($CONTENT);}
	if ($EX == "js") {$CONTENT = produce_js($CONTENT);}
	if ($EX == "css") {$CONTENT = produce_css($CONTENT);}
	if ($EX == "json") {$CONTENT = produce_json($CONTENT);}*/
	
	echo $CONTENT;


	
function produce_js($STR){
	
	echo "JS_CODE";

	$STR = str_replace("=","<span class='js_sign'>=</span>",$STR);


	$KEYWORDS = array(" for", "&emsp;for", " while", "&emsp;while", " if", "&emsp;if", " this", "&emsp;this"," else", "&emsp;else" ," in", "var ", " Number", " number", " string", " String", " Array", "Object", " Function", " function", " XMLHttpRequest", " window", " document", "location", "history", "forms","links","_.","setTimeout", "setInterval", "getElementsByName", "getElementById", "return");

	for ($i=0; $i<count($KEYWORDS); $i++){
			$STR = str_replace($KEYWORDS[$i],"<span class='js_keyword'>".$KEYWORDS[$i]."</span>",$STR);
		}
	
	$SIGNS = array("&lt;", "&gt;",  "-", "+", "!", "*",  "%", "?", ":");

	for ($i=0; $i<count($SIGNS); $i++){
			$STR = str_replace($SIGNS[$i],"<span class='js_sign'>".$SIGNS[$i]."</span>",$STR);
		}

	return $STR;
	}
	

function produce_html($STR){
	
	$STR = str_replace("&lt;", "<span class='html_tag'>&lt;", $STR);
	$STR = str_replace("&gt;", "&gt;</span>", $STR);
	
	return $STR;
	}
	

function produce_php($STR){
	
	
	
	return $STR;
	}
	

function produce_css($STR){
	
	
	
	return $STR;
	}
	function produce_json($STR){
	
	
	
	return $STR;
	}
	

?>