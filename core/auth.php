<?php
	if (file_exists($_SERVER["DOCUMENT_ROOT"]."/core/.uninstalled")){
		header("Location: /core/install.php");
		die();
	}
	
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/CoreUsers.php";
	if (!CoreUsers::authorized()) {
		header("Location: /core/login.php");
		die();
	}
	
	$data = CoreUsers::getCurrent();	
	
	$ROLE=$data['role'];
	$USERNAME = $data['login'];
	$INFO = $data['info'];
?>