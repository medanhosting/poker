<?php

	require "config";
	if ($role>1) die("<p> Недостаточно прав для создания пользователя!</p>");
	
	$login = $_POST["login"];
	$password = md5($_POST["newPassword"]);
	$role = $_POST["role"];
	$info = $_POST["info"];
	
	require_once "../lib/sql_class.php";
	$sql = new SQLConnection();
	if ($sql->query("INSERT INTO cata_users VALUES (default, '$login', '$password', $role, '$info')")){
		echo "<p class='status'> Пользователь создан успешно! </p>";
	}else echo "<p class='status'> Ошибка создания: <br/>".mysqli_error()." </p>";
?>