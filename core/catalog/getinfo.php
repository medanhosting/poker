<?php
	#print_r($_POST);
	require_once "../lib/sql_class.php";
	require_once "catalog_class.php";
	$connect = new SQLConnection();

	echo "<h3> Информация о каталоге ".$_POST['name']."</h3>";
	$catalog = new RCatalog($_POST['name']);
	$tables = $catalog->getTables();
		
	$i=1;
	foreach ($tables as $value){
		
		echo "<h4>Таблица $i-го уровня вложенности: $value</h4>";
		echo $connect->fetch_array("SELECT COUNT(*) FROM $value","<p> Количество элементов в таблице: $0</p>");
		$i++;
	}

?>

	<br/>
	<input type='button' value='Вывести весь каталог' id='schema' data='<?php echo json_encode($_POST);?>'>
	<input type='button' value='Редактировать каталог' id='proceed' data='<?php echo $_POST["name"];?>'/>