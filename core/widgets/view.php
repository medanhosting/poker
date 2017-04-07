<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";
	
	#System News Widget
	echo "<div id='news_widget'>";
		echo "<h2> Новости системы</h2>";
		echo "<ul>";
		$data = file_get_contents("http://app.retarcorp.com/news/?key=1");
		$data = json_decode($data,true);
	
		foreach($data as $item){
			$item['date'] = date("d.m.Y",strtotime($item['date']));
			echo "<li> <time> {$item['date']}</time> <div> {$item['content']}</div></li>";
		}	
		echo "</ul>";
	echo "</div>";
	
?>