<?php
	require "config";
	
	$id = $_POST["id"];
	
	
	$login = $_POST["login"];
	$old_password = md5($_POST["oldPassword"]);
	$password = md5($_POST["newPassword"]);
	$role_ = $_POST["role"];
	$info = $_POST["info"];
	
	if($role>$role_) die("Вы не можете создать пользователя с уровнем доступа большим, чем ваш!");
	
	if (CoreUsers::isUserId($id, $old_password)){
		if($password!=""){
			if (CoreUsers::edit($id, array("login"=>$login, "password"=>$password,"role"=>$role_, "info"=>$info))){
				echo "<p class='status'>Изменения приняты! </p>";
			} else echo "<p class='status'> Ошибка сохранения изменений: ".mysqli_error()."</p>";
		}else echo "<p class='status'> Новый пароль не может быть пустым! </p>";	
	}else{
		
		die("Неправильно введен пароль пользователя!");
	}
	
	

		

?>