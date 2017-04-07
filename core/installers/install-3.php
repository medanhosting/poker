<?php

?>
<form class='login'>
	<h2>Придумайте данные для входа в систему</h2>
	<p>Создайте учетную запись администратора для входа в систему. Создать новых пользователей Вы сможете позже в панели управления системы.</p>
	
	<label>
		Имя пользователя
		<input type='text' value='' name='username' id='login_username'/>
	</label>
	
	
	<label>
		Пароль
		<input type='text' value='' name='password' id='login_password'/>
	</label>
	<p> Запомните или запишите эти данные - без них войти в панель управления сайтом будет невозможно! </p>
	<input type='button' value='Сохранить' id='login_save' class='next'/>
</form>