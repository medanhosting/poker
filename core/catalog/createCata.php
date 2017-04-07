<?php

	require_once "../lib/sql_class.php";

	sleep(0.8);
	$dataStr=stripcslashes($_POST["data"]);
	$name = $_POST["name"];
	$data = json_decode($dataStr);

	$connection = new SQLConnection();
	$amo = $connection->fetch_array("SELECT COUNT(*) FROM cata_catalogs WHERE name='".$name."'","$0");
	if ($amo>0){ echo "<h3> Каталог уже существует! </h3>";}else{

	if ($connection->query("INSERT INTO cata_catalogs VALUES (default,'$name',".count($data).",'$dataStr','')")){
		echo "<p> Виртуальный директорий создан успешно.</p>";
	}
	
	for($i=0; $i<count($data); $i++){$data[$i] = (array)$data[$i];}

		for($i=0; $i<count($data); $i++){
			
			if ($connection->query("SELECT * FROM ".$data[$i]["tableName"])){
				echo "<p> <b>Внимание!</b> Таблица ".$data[$i]["tableName"]." уже существует и не была изменена. Проверьте соответствие ее структуры API системы RetarCata, иначе каталог не будет функционировать!</p>";
			}else{
				if ($i==0){
	
					$fields="";
					foreach ($data[$i] as $key=> $value) {if ($key!="tableName") $fields.=", $key $value"; }
					$connection->query("CREATE TABLE ".$data[$i]["tableName"]." ( id INT PRIMARY KEY AUTO_INCREMENT $fields )");
				
				}else{
					$fields="";
					foreach ($data[$i] as $key=> $value) {if ($key!="tableName") $fields.=", $key $value"; }
					$connection->query("CREATE TABLE ".$data[$i]["tableName"]." ( id INT PRIMARY KEY AUTO_INCREMENT, parent INT  $fields)");
					
				}

				if (!mysqli_error()){
						echo "<p> Таблица ".$data[$i]["tableName"]." создана успешно.</p>";
					} else 	echo "<p> Ошибка при создании таблицы ".$data[$i]["tableName"]." !</p>";
			}
			

		}
	echo "<h4> Каталог был создан успешно. Приятного использования системы управления каталогизацией RetarCata! </h4>";


	}
?>