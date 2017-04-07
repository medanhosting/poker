<?php
	require "config";
	
	$_POST['content']=addslashes($_POST['content']);
	
	$Q = "UPDATE cata_manual SET title='{$_POST['title']}', content='{$_POST['content']}' WHERE id={$_POST['id']}";
	$sql->query($Q);
	
	if(mysqli_error()) echo mysqli_error();