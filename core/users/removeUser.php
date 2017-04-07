<?php
	require "config";
	
	$id = $_POST["id"];
	 
	try{
		if(CoreUsers::remove($id)){
			echo "<p class='status'> Пользователь удален успешно! </p>";
		}else{
			"<p class='status'> Ошибка удаления: <br/>".mysqli_error()." </p>";
		}
	}catch(Exception $e){
		die($e->getMessage());
	}
	
?>