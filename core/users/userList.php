<?php
	require_once "../lib/sql_class.php";
	
	$sql = new SQLConnection();
	$users = $sql->getAssocArray("select * from cata_users");
	foreach ($users as $user){
		switch($user["role"]){
			case 1: $role = "Администратор"; $class="admin"; break;
			case 2: $role = "Модератор"; $class = "moderator"; break;
			case 3: $role = "Гость"; $class="guest"; break;
			
		}
		echo "<li user-id='".$user['id']."' class='$class'> 
			<h4>".$user["login"]." </h4>
			<h6>".$role." </h6>
			<p>".$user["info"]." </p>
		</li>";
	}
?>	