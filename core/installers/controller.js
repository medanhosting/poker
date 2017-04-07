_.core(function(){

	var Window = _.$("section.main.window");
	
	
	
	Window.HTML("Инициализация процессов установки...");
	progressTo(0.5);
	
	// Стадия 1 - загрузка параметров MySQL
	Window.load("installers/install-1.php","POST",{},function(){
		progressTo(3);
		mysql_proceed();
	});

})

var getTime = function(){
	date = new Date();
	return date.getHours()+":"+date.getMinutes()+":"+date.getSeconds()+"."+date.getMilliseconds()+"   ";
}
var progressTo = function(value){
		_.$("progress").value(value);
}
	
mysql_proceed = function(){
	
	_.$("form.mysql_data input#mysql_ok").click(function(){
	
		_.$("form.mysql_data input[type='text']").clearStyle();
		var mysql = new Object();
		
		mysql.hostname = _.$("form.mysql_data input#mysql_hostname").value();
		mysql.username = _.$("form.mysql_data input#mysql_username").value();
		mysql.password = _.$("form.mysql_data input#mysql_password").value();
		mysql.maindb = _.$("form.mysql_data input#mysql_maindb").value();
		
		var proceed = true;
		
		if ((mysql.hostname=="")||(mysql.hostname.replace(/\s/g,"")=="")){
			_.$("form.mysql_data input#mysql_hostname").style("border-color","#d11");
			proceed = false;
		}
		
		if ((mysql.username=="")||(mysql.username.replace(/\s/g,"")=="")){
			_.$("form.mysql_data input#mysql_username").style("border-color","#d11");
			proceed = false;
		}
		
		if ((mysql.password=="")||(mysql.password.replace(/\s/g,"")=="")){
			_.$("form.mysql_data input#mysql_password").style("border-color","#d11");
			proceed = false;
		}
		
		if ((mysql.maindb=="")||(mysql.maindb.replace(/\s/g,"")=="")){
			_.$("form.mysql_data input#mysql_maindb").style("border-color","#d11");
			proceed = false;
		}
		
		if(proceed){
			_.$("p.status").HTML("Проверка корректности введенных данных...");
			_.$("p.status").load("installers/install-1-check.php","POST",mysql,function(){
			
				response = _.$("p.status").HTML();
				console.log(response)
				if ((response[0]=="O")&&(response[1]=="K")){
					proceed_creating();
				}
			})
		}
		
	})
	
}

// Функция, ответственная за создание всех технических каталогов после того, как прозвон до базы данных был завершен успешно.
proceed_creating = function(){

	progressTo(10);
	var Window = _.$("section.main.window");
	var Log = _.$("textarea");
	Log.appendHTML(getTime()+"Прозвон базы данных завершен успешно. Данные сохранены.\n");
	
	Window.HTML("<p class='status'></p>");
	
	Window.load("installers/install-2.php","POST",{},function(response){
		if (response=="OK"){
			progressTo(20);
			Window.HTML("Хранилище виртуальных директориев создано успешно.\n");
			Log.appendHTML(getTime()+"Хранилище виртуальных директориев создано успешно.\n");
			cata_env();
		}
	})
	
	Window.load("/core/logger/install","GET",{ignoremarker:"true"},function(response){
		progressTo(20);
		Window.HTML("Система отчетов установлена.\n");
		Log.appendHTML(getTime()+"Система отчетов установлена.\n");
		
	})
}

//Функция создания каталога cata_env
cata_env = function(){
	var Window = _.$("section.main.window");
	var Log = _.$("textarea");
	Log.appendHTML(getTime()+'Создаем каталог переменных окружения...\n');
	
	Window.load("installers/install-2-cata-env.php","POST",{},function(response){
		if (response=="OK"){
			progressTo(30);
			Window.HTML("Каталог переменных окружения создан успешно.\n");
			Log.appendHTML(getTime()+"Каталог переменных окружения создан успешно.\n");
			cata_env_put();
		}
	})
}


//Функция записи переменных окружения каталога cata_env
cata_env_put = function(){
	var Window = _.$("section.main.window");
	var Log = _.$("textarea");
	Log.appendHTML(getTime()+'Записываем переменные окружения...\n');
	
	Window.load("installers/install-2-put-env.php","POST",{},function(response){
		if (response=="OK"){
			progressTo(40);
			Window.HTML("Переменные записаны успешно.\n");
			Log.appendHTML(getTime()+"Переменные окружения записаны.\n");
			cata_apps();
		}
	})
}

//Функция создания каталога приложений
cata_apps = function(){
	var Window = _.$("section.main.window");
	var Log = _.$("textarea");
	Log.appendHTML(getTime()+'Создаем каталог приложений...\n');
	
	Window.load("installers/install-2-apps.php","POST",{},function(response){
		if (response=="OK"){
			progressTo(50);
			Window.HTML("Каталог приложений создан.\n");
			Log.appendHTML(getTime()+"Каталог приложений создан.\n");
			cata_pack();
		}
	})
}

//Функция добавления пакета приложений
cata_pack = function(){
	var Window = _.$("section.main.window");
	var Log = _.$("textarea");
	Log.appendHTML(getTime()+'Установка стандартного пакета приложений...\n');
	
	Window.load("installers/install-2-pack.php","POST",{},function(response){
		if (response=="OK"){
			progressTo(65);
			Window.HTML("Пакет приложений установлен.\n");
			Log.appendHTML(getTime()+"Пакет приложений установлен. \n");
			created();
		}
	})
}



//Функция , вызывающаяся после того, как пакет приложений установлен. Теперь необходимо установить логин и пароль на админпанель.
created= function(){
	var Window = _.$("section.main.window");
	var Log = _.$("textarea");
	
		
	Window.load("installers/install-3.php","POST",{},function(response){
		progressTo(70);
		
		_.$("#login_save").click(function(){
			login = _.$("#login_username").value();
			password = _.$("#login_password").value();
			
			err = "";
			if (login.length<3) err+="Слишком короткое имя пользователя!";
			if (login!=login.match(/^[a-zA-Z0-9]+$/)) err+="Недопустимые символы в имени пользователя! Логин может состоять только из латинских букв и цифр.";
			
			if (password!=password.match(/^[a-zA-Z0-9\@\*\^\-_]+$/)) err+="Недопустимые символы в пароле! Логин может состоять только из латинских букв и цифр + символы @*_-^";
			
			if(err.length>1) alert(err); else{
			
				Window.load("installers/install-3-save.php","POST",{login: login, password: password}, function(response){
				
					if (response=="OK"){
						progressTo(90);
						Window.HTML("Данные администратора сохранены.\n");
						Log.appendHTML(getTime()+"Данные администратора сохранены.\n");
						
						cata_users();
					}
					
				})
			
			}
		
		})
	})
}

cata_users = function(){
	var Window = _.$("section.main.window");
	var Log = _.$("textarea");
	
	Window.HTML("Удаление временных файлов...");	
	Log.appendHTML(getTime()+"Удаление временных файлов...\n");
	
	Window.load("installers/install-4.php","POST",{}, function(response){
		if (response=="OK"){
			progressTo(99);
			Window.load("installers/install-5.php","POST",{}, function(){progressTo(100);});
		}
	})
}