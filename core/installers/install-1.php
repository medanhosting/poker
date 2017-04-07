<?php
	# Форма получения данных входа в БД
	if (!file_exists("../.uninstalled")) die("<p> Нарушение процесса установки. Маркер установки удален.</p>");
	
?>
<form class='mysql_data'>
	<h2> Введите данные доступа к MySQL</h2>
	<p> Данные доступа к базе необходимы для корректной работы системы и сайта в целом.</p>
	<label>
		Имя хоста
		<input type='text' value='localhost' id='mysql_hostname'/>
	</label>
	
	<label>
		Имя пользователя
		<input type='text' value='' id='mysql_username'/>
	</label>
	
	
	<label>
		Пароль для пользователя
		<input type='text' value='' id='mysql_password'/>
	</label>
	
	<label>
		Имя главной базы данных
		<input type='text' value='' id='mysql_maindb'/>
	</label>
	
	<p>Не знаете, где взять эти данные ? Обратитесь к своему хостинг-оператору, в панель cpanel или phpmyadmin, или задайте вопрос <a href='mailto:retarcorp@gmail.com'>нам.</a></p>
	
	<input type='button' value='Далее' id='mysql_ok' class='next'/>
	<p class='status'> </p>
</form>