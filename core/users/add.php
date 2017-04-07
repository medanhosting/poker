<?php

	require "config";
	
	if($role==CoreUsers::GUEST) die("У вас недостаточно прав для создания пользователя!");
	
	try{
		if (CoreUsers::add('login','',CoreUsers::GUEST))
			require "userList.php";
	}catch(Exception $e){
		echo $e->getMessage();
	}
?>