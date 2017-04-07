<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/CoreUsers.php";
	CoreUsers::logout();
	
	header("Location: ./");
?>