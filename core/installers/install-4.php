<?php
	# Перезапись данных входа в папку библиотек
	#
	
	file_put_contents("../lib/mysql_data", file_get_contents("temp_mysql"));
	require_once "../lib/sql_class.php";
	
	$sql = new SQLConnection();
	if (mysqli_error()=="") echo "OK"; else echo mysqli_error();
 ?>