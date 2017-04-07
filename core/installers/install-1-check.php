<?php
	
	# Прозвон базы данных и сохранение данных входа в БД
	#
	
	
	$hostname = $_POST['hostname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$maindb = $_POST['maindb'];
	
	$source = @mysqli_connect($hostname,$username,$password);
	$log = mysqli_error($source);
	$res = 'OK';
	if($log==""){
	
		@mysqli_select_db($source, $maindb);
		$log = mysqli_error($source);
		if ($log!=""){
			$res= "Неверно указано имя базы данных. Убедитесь в правильности его написания и в том, что база данных создана.";
		}
	}else{
		$res = "Неверные имя пользователя, пароль или адрес хоста! Пожалуйста, проверьте данные.";
	}
	echo $res;
	if ($res=="OK"){
		$temp_mysql = $hostname."[|]".$username."[|]".$password."[|]".$maindb;
		file_put_contents("temp_mysql",$temp_mysql);
	}
	@mysqli_close($source);
?>