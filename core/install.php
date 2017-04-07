<?php

	if (!file_exists(".uninstalled")){
		header("Location: index.php");
	}
	
	$_COOKIE["core-login"]="";
	$_COOKIE["core-password"]="";
	
	setcookie("core-login","",time()-1);
	setcookie("core-password","",time()-1);
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title> Retar Core v 1.19 - установка</title>
		 
		<script src='lib/js/retarcore.js'></script>
		<script src='installers/controller.js'></script>
		<link rel='stylesheet' href='css/install.css'/>
				
	</head>
	
	<body>
	
		<header>
			
			<h1> Установка Retar Core v1.19 </h1>
			<progress value='1' max='100'>1%</progress>
		</header>
	
		<section class='main window'>
			
			
		</section>
		
		<section class='log'>
			<h2>Ход установки</h2>
			<textarea></textarea>
		</section>
	</body>

</html>