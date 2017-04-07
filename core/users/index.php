<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/utils/Utils.php";
	$APP_TITLE = "Пользователи";
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>Пользователи | Retar Core v 1.19</title>
		
		<script src='/core/lib/js/retarcore.js'></script>
		<script src='js/controller.js'> </script>
		<script src='/core/js/clock.js'> </script>
		
		<link rel='stylesheet' href='../css/main.css'/>
		<link rel='stylesheet' href='../css/index.css'/>
		<link rel='stylesheet' href='../css/icons.css'/>
		<link rel='stylesheet' href='../css/widgets.css'/>
		<link rel='stylesheet' href='css/main.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once "../menu.php"; ?>
			
			
			
		</header>
	
		<div class='wrapper'>
			<section class='users'>
				<ul>
				
					<?php include "userList.php"; ?>
				</ul>
				<input type='button' id='add' value='Добавить'/>
			</section>
			
			<section class='actions'>
								
				<form class='editor'>
					<label>
						Логин пользователя
						<input type='text' id='user-login'/>
					</label>
					
					<label>
						Старый пароль
						<input type='password' value='' id='user-old-password'/>
					</label>
					
					<label>
						Новый пароль
						<input type='text' value='' id='user-new-password'/>
					</label> 
					
					<input type='hidden' id='user-id' value='0'/>
					<label>
						Роль пользователя
						<select id='user-role'>
							<option value='1'>Администратор</option>
							<option value='2'>Модератор</option>
							<option value='3'>Гость</option>
						</select>
					</label>
					
					<label>
						Информация о пользователе
						<textarea id='user-info'></textarea>
					</label>
					
					<input type='button' value='Сохранить' id='user-save'/>
				</form>
			</section>
		</div>
	
	</body>

</html>