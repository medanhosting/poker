<?php

	require_once "config";
	
	$level = $_GET['level'] ? $_GET['level']  : 0;
	if(!$level) $catalog->addItem($DEFAULT[$level]);
	else $catalog->addItem($DEFAULT[$level], $_GET['id'], $level-1);
	
	echo mysqli_error();
	if(mysqli_error()) echo $catalog->getLastQuery();
	require_once "list.php";

?>