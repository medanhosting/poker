<?php

	# General system class;
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/Core.php";
	
	# Class, responsible for system users
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/CoreUsers.php";
	
	# AppManager class
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/AppManager.php";
	
	# Logger class
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/Logger.php";
	
	# File Management class
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/FileManager.php";
	
	# Environment variables class
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/REnvars.php";
	
	# Imager class
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/Imager.php";
?>