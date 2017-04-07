<?php
	
	require "config";
	$id = $_GET[id];
	
	$templates = $templates->getChildrenOf($id, 0);
	
	foreach($templates as $tpl){
		$s.="<option value='{$tpl[id]}'> {$tpl[title]}</option>";
	}
	echo $s;