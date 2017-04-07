<?php
	if (file_exists($_SERVER["DOCUMENT_ROOT"]."/core/.uninstalled")){
		header("Location: /core/install.php");
		die();
	}
	
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/CoreUsers.php";
	
	if (isset($_POST["enter"])){
		
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		if (CoreUsers::login($login, $password)){
			header("Location: /core");
		}else{
			$err="<p class='incorrect'>Неверные имя пользователя и/или пароль!</p>";
		}
	
	}
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>Вход | Система управления сайтом Retar Core v 1.19</title>
		
		<script src='lib/js/retarcore.js'></script>
		
		<link rel='stylesheet' href='css/login.css'/>
		<link rel='stylesheet' href='css/index.css'/>

	</head>
	
	<body>
	
		<header>
			
			<nav class='main_nav'>
				
			</nav>
			
		</header>
	
		
			<form action='' method='POST'>
				<h1> Вход в систему </h1>
				<?php echo $err; ?>
				<label>
					Имя пользователя
					<input type='text' name='login' required=required />				
				</label>
				
				<label>
					Пароль
					<input type='password' name='password' required=required/>
				</label>
				
				<input type='submit' value='Вход' name='enter'/>
			</form>
		
	
	</body>

</html>