_.core(function(){

	_.Environment.path="/";
	_.Environment.sending=0;
	_.Environment.buffer = {type:"none", operation:"copy", addr:"", filename:""};
	_.E.loader = "<div class='miniLoader'> <p> </p> </div>";	
	

	function rewriteEnvironment(f){
		var request = window.indexedDB.open("environment");
		request.onsuccess = function(e){
			var db = e.target.result;
			
			var transaction = db.transaction(["environment"],"readwrite");
			//console.log(transaction);
			var store = transaction.objectStore("environment");
			//console.log(store);
			_.E.key = 1;
			var request = store.delete(1);
			
			request.onsuccess = function(){
				
				var request = transaction.objectStore("environment").put(_.E);
				request.onsuccess = function(){
					if(f) f();
				}
				
			}
			request.onerror = function(e){
				console.log(e)
			}
			
			
		}
		request.onupgradeneeded = function(e){
			var db = e.target.result;
			if(db.version<3)
			var objectStore = db.createObjectStore("environment",{keyPath: "key"});
			//console.log(objectStore)
		}
	
	}
	
	var request = window.indexedDB.open("environment");
	request.onsuccess = function(e){
			var db = e.target.result;
			
			var transaction = db.transaction(["environment"],"readwrite");
			var store = transaction.objectStore("environment");
			
			var request = store.get(1);
			request.onsuccess = function(e){
				if(request.result) _.E = request.result;
				resetInterface();
			}
		}
	request.onupgradeneeded = function(e){
			var db = e.target.result;
			if(db.version<3)
			var objectStore = db.createObjectStore("environment",{keyPath: "key"});
			//console.log(objectStore)
	}
			
			
			
				
	_.E.aside = 1;
	_.E.view = 1;
	
	_.$("section ol li button").click(function(e){
		e.preventDefault();
	})
	
	
	
	loadItems = function(addr){
			
			_.$("aside ul li[data-addr='"+addr+"'] ul").load("getItemList.php","POST",{address:addr}, function(){
				handleAside();
				_.Environment.path = addr;
				if(_.Environment.path[1]=="/"){
					_.Environment.path = _.Environment.path.slice(0);
				}
				_.$("section ul").HTML(_.E.loader).load("getItems.php","POST",{address:addr}, function(){
					if(!_.Environment.list){
						_.Environment.list = 1;
						handlerList();
					}					
					handlerItems();
				});
				
				pathHtml="<span data-addr='/'>Корень:</span>";
				pathW="";
				for (item in getFolders()){
					item = getFolders()[item];
					pathW+="/"+item;
					pathHtml+="<span data-addr='"+pathW+"'>"+item+"</span>";
					
				}
				_.$("p.pathes").HTML(pathHtml);
			});	
	}
	
	getParent = function(){
		paths = _.Environment.path.match(/[^\/]+/g);
			if (paths)
			if ((paths.length>0)&&(_.Environment.path!="/")){
				paths.pop();
				path = "/"+paths.join("/");
				return path;
			} else ;
			else return "/";
	}
	
	getFolders = function(){
		return _.Environment.path.match(/[^\/]+/g) || [];
	}
	
	
	//ASIDE HANDLER
	var openFolder = function(e){
	
			var addr = this.getAttribute("data-addr");
			loadItems(addr);
			e.stopPropagation();
			//console.log("handleAside openFolder");
		};
	
	
	var contextAside=function(e){
			_.$("form.contextmenu").attr("data-addr",this.getAttribute("data-addr"))
			_.$("form.contextmenu").style("display","none");
			var menu = _.$("form.foldercontextmenu");
			var x = e.clientX;
			var y = e.clientY;			
			menu.style({"position":"fixed","top":y+"px","left":(x-60)+"px","display":"block"})			
			event.preventDefault();			
	}
	
	
	handleAside = function(){	
		_.$("aside ul li").unevent("click", openFolder).click(openFolder);		
		_.$("aside ul li.dir").unevent("contextmenu",contextAside).event("contextmenu",contextAside);
	}
	
	handleAside();
	loadItems("/");
	
	
	
	var contextFile = function(e){
			
			_.$("form.filecontextmenu").attr("data-addr",this.getAttribute("data-addr"))
			_.$("form.filecontextmenu").attr("data-name",this.innerHTML);
			_.$("form.contextmenu").style("display","none");
			
			_.$("form.filecontextmenu li.zip").display("none");
			if(_.$(this).hasClass("zip")) {
				_.$("form.filecontextmenu li.zip").display("block");
				_.$("form.filecontextmenu li.zip.in").HTML("Извлечь в "+_.$(this).HTML().replace(".zip","/"));
			}
			
			var menu = _.$("form.filecontextmenu");
			var x = e.clientX;
			var y = e.clientY;			
			menu.style({"position":"fixed","top":y+"px","left":(x-60)+"px","display":"block"})			
			event.preventDefault();	
			
					
		};
	
	var contextFolder = function(e){
		
			_.$("form.foldercontextmenu").attr("data-addr",this.getAttribute("data-addr"))
			_.$("form.foldercontextmenu").attr("data-name",this.innerHTML);
			_.$("form.contextmenu").style("display","none");
			var menu = _.$("form.foldercontextmenu");
			var x = e.clientX;
			var y = e.clientY;			
			menu.style({"position":"fixed","top":y+"px","left":(x-60)+"px","display":"block"})			
			event.preventDefault();			
		};
	
	var props = function(e){
						
				_.$("form.contextmenu").style("display","none");
				_.$("body .popover").load("propertiesFolder.php","POST",{path:_.Environment.path, name:this.parentNode.parentNode.getAttribute("data-addr")}, function(){
					_.$("body .popover").style("display","block");
					
					//Кнопка закрытия окна основного алерт-поповера
					_.$(".popover .close").click(function(e){
							
						_.$("body>.popover").style("display","none");
						e.preventDefault();
						return false;
					})
					
				})
			e.stopPropagation();			
		};
		
	var propsFile = function(e){
		_.$("form.contextmenu").style("display","none");
				_.$("body .popover").load("propertiesFile.php","POST",{path:_.Environment.path, name:this.parentNode.parentNode.getAttribute("data-name")}, function(){
					_.$("body .popover").style("display","block");
					
					//Кнопка закрытия окна основного алерт-поповера
					_.$(".popover .close").click(function(e){
							//alert();
						_.$("body>.popover").style("display","none");
						e.preventDefault();
						return false;
					})
					
				})
			e.stopPropagation();
	}
		
	var copyFunc = function(){		
			_.Environment.buffer.type='file';
			_.Environment.buffer.addr = this.parentNode.parentNode.getAttribute("data-addr");
			_.Environment.buffer.filename = this.parentNode.parentNode.getAttribute("data-name");
			_.Environment.buffer.operation = "copy";
			_.$("#paste").attr("title","Вставить: "+this.parentNode.parentNode.getAttribute("data-name"))
		};
		
	var cutFunc = function(){		
			_.Environment.buffer.type='file';
			_.Environment.buffer.addr = this.parentNode.parentNode.getAttribute("data-addr");
			_.Environment.buffer.filename = this.parentNode.parentNode.getAttribute("data-name");
			_.$("#paste").attr("title","Вставить: "+this.parentNode.parentNode.getAttribute("data-name"));
			_.Environment.buffer.operation = "cut";
		};
		
	var inZip = function(){
		_.$("form.contextmenu").style("display","none");
		var path = _.E.path;
		var folder = _.$(this).parent(2).data('addr');
		
		_.new("div").get("inZip.php",{folder: folder, path: path},function(r){
			console.log(r);
			loadItems(folder.split("/").slice(0,folder.split("/").length-1).join("/"));
		});
	};
	
	var extractZip = function(e){
		
		var file = _.$(this).parent(2).data("addr");
		
		_.new("div").get("extractZip.php",{file: file},function(r){
			//console.log(r);
			loadItems(file.split("/").slice(0,file.split("/").length-1).join("/"));
		});
	};
	
	var extractZipHere = function(){
		var file = _.$(this).parent(2).data("addr");
		
		_.new("div").get("extractZip.php",{file: file, current: true},function(r){
			//console.log(r);
			loadItems(file.split("/").slice(0,file.split("/").length-1).join("/"));
		});		
	};

	var extractZipIn = function(){
		var file = _.$(this).parent(2).data("addr");
		var target = prompt("Введите адрес папки, куда будет извлечен архив:",file.split("/")[file.split("/").length-1].replace(".zip",""));
		if(target){
			_.new("div").get("extractZip.php",{file: file, target: target},function(r){
				//console.log(r);
				loadItems(file.split("/").slice(0,file.split("/").length-1).join("/"));
			});	
		}
		
			
	};
	
	handlerItems = function(){
	
		_.$("section li.folder").click(function(e){		
			var addr = this.getAttribute("data-addr");
			loadItems(addr);
		})
			
		_.$("p.pathes span").click(function(e){
			loadItems(this.getAttribute("data-addr"));
		})
		
		_.$("section ul li.file").unevent("contextmenu", contextFile).event("contextmenu",contextFile);
		_.$("section ul li.folder").unevent("contextmenu",contextFolder).event("contextmenu",contextFolder);		
		
		//Получение свойств папки		
		_.$(".foldercontextmenu .properties").unevent("click",props).click(props);
		
		//Получение свойств папки		
		_.$(".foldercontextmenu .zip").unevent("click",inZip).click(inZip);
		
		//Получение свойств файла 
		_.$(".filecontextmenu .properties").unevent("click",propsFile).click(propsFile);
		
		
		//Запись в буфер копирования файла
		_.$(".filecontextmenu .copy").unevent("click",copyFunc).click(copyFunc);
		
		
		//Запись в буфер вырезания файла
		_.$(".filecontextmenu .cut").unevent('click',cutFunc).click(cutFunc)
		
		//Распаковка архива в новую папку
		_.$(".filecontextmenu .zip.in").unevent('click',extractZip).click(extractZip);
		
		//Распаковка архива в текущее расположение
		_.$(".filecontextmenu .zip.userf").unevent('click',extractZipIn).click(extractZipIn);
		
		
		//Распаковка архива в текущее расположение
		_.$(".filecontextmenu .zip.here").unevent('click',extractZipHere).click(extractZipHere);
		
		//Старт редактирования файла
		_.$("section ul li.file").click(function(e){
			startEditor(this.getAttribute("data-addr"),this.innerHTML);
		})
		_.$("form.filecontextmenu li.edit").click(function(e){
			startEditor(this.parentNode.parentNode.getAttribute("data-addr"),this.parentNode.parentNode.getAttribute("data-name"));
		})
	}
		
	handlerList = function(){
	
		_.$("#back").click(function(e){
			
			e.preventDefault();			
			loadItems(getParent());	
			
		})

		_.$("#addFolder").click(function(){
			
			var name = prompt("Введите название новой папки:","Новая папка");
			if(name){
				_.$("section ul").HTML(_.E.loader).load("addFolder.php","POST",{target:_.Environment.path, name:name}, function(){
					loadItems(_.Environment.path);
				})
			}
			return false;
		})
		
		_.$("#addFile").click(function(){
			
			var name = prompt("Введите название нового файла:","Новый файл");
			if(name){
				_.$("section ul").HTML(_.E.loader).HTML(_.E.loader).load("addFile.php","POST",{target:_.Environment.path, name:name}, function(){
					loadItems(_.Environment.path);
				})
			}
			return false;
		})
		
		
	
		//Перетаскивание файлов		
		handlerDrag = function(e){
			e.preventDefault();
			e.stopPropagation();
			elem = _.$("section ul");
			
			if (e.type=='drop'){
				if (_.Environment.sending==1) return;
				_.Environment.sending=1;				
				var files = event.dataTransfer.files, info="",i=0, len;
				console.log(files);
				i=0;
				len = files.length;		
				var data = new FormData(), i=0;		
				while(i < len){
					info+=JSON.stringify(files[i])+"<br/>";
					data.append("file"+i,files[i]);
					i++;
				}
				
				data.append("path",_.Environment.path);
				var xhr = new XMLHttpRequest();
				xhr.open("post","filesupload.php",true);
				xhr.onreadystatechange = function(){
				
					if(xhr.readyState == 4){
						loadItems(_.Environment.path);
						elem.HTML("Успешно загружено"+"!");
					}
					_.Environment.sending=0;
				}
				elem.HTML("Подождите, сохраняем файлы ("+len+")");
				xhr.send(data);				
				//elem.HTML(info);
			
			}
			return false;
		}
		_.$("section ").event("dragenter", handlerDrag);
		_.$("section ").event("dragover", handlerDrag);
		_.$("section ").event("drop", handlerDrag);
		
		
		//
		
		//Переименование файла
		_.$(".filecontextmenu .rename").click(function(e){		
			
			name = prompt("Введите новое имя файла: ",this.parentNode.parentNode.getAttribute("data-name"));
			if(name){
				_.$("form.contextmenu").style("display","none");
				_.$("section ul").HTML(_.E.loader).load("renameFile.php","POST",{path:_.Environment.path, name:this.parentNode.parentNode.getAttribute("data-name"), newname: name}, function(){
					loadItems(_.Environment.path);
				})
			}
			e.stopPropagation();			
		})
		//Переименование папки
		_.$(".foldercontextmenu .rename").click(function(e){			
			name = prompt("Введите новое имя папки: ",this.parentNode.parentNode.getAttribute("data-name"));
			if(name){
				_.$("form.contextmenu").style("display","none");
				_.$("section ul").HTML(_.E.loader).load("renameFile.php","POST",{path:_.Environment.path, name:this.parentNode.parentNode.getAttribute("data-name"), newname: name}, function(){
					loadItems(_.Environment.path);
				})
			}
			e.stopPropagation();			
		})
		//Удаление файла
		_.$(".filecontextmenu .delete").click(function(e){				
				_.$("form.contextmenu").style("display","none");
				_.$("section ul").HTML(_.E.loader).load("deleteFile.php","POST",{path:_.Environment.path, name:this.parentNode.parentNode.getAttribute("data-name")}, function(){
					loadItems(_.Environment.path);
				})
			e.stopPropagation();			
		})
		//Получение свойств файла
		
		// Вставка - кнопка вставки
		_.$("#paste").click(function(e){
		
			if (_.Environment.buffer.type=='file'){
			
				_.Environment.buffer.target = _.Environment.path; 
				_.$("section ul ").load("copycutFile.php","POST",_.Environment.buffer,function(){
					loadItems(_.Environment.path);
				})
			}
			if (_.Environment.buffer.type=='folder'){
			
				_.Environment.buffer.target = _.Environment.path; 
				_.$("section ul ").load("copycutFolder.php","POST",_.Environment.buffer,function(){
					loadItems(_.Environment.path);
				})
			}
			e.preventDefault();
		})
		//Скачивание файла
		_.$(".filecontextmenu .save").click(function(e){
			window.open("download.php?target="+_.$(".filecontextmenu").attr("data-addr"));
			return false;
		})
		//Запись в буфер копирования папки
		_.$(".foldercontextmenu .copy").click(function(){		
			_.Environment.buffer.type='folder';
			_.Environment.buffer.addr = this.parentNode.parentNode.getAttribute("data-addr");
			_.Environment.buffer.filename = this.parentNode.parentNode.getAttribute("data-name");
			_.Environment.buffer.operation = "copy";
			_.$("#paste").attr("title","Вставить: "+this.parentNode.parentNode.getAttribute("data-name"))
		})
		//Запись в буфер вырезания папки
		_.$(".foldercontextmenu .cut").click(function(){		
			_.Environment.buffer.type='folder';
			_.Environment.buffer.addr = this.parentNode.parentNode.getAttribute("data-addr");
			_.Environment.buffer.filename = this.parentNode.parentNode.getAttribute("data-name");
			_.$("#paste").attr("title","Вставить: "+this.parentNode.parentNode.getAttribute("data-name"));
			_.Environment.buffer.operation = "cut";
		})
		//Удаление папки
		_.$(".foldercontextmenu .delete").click(function(e){
			_.$("section ul").HTML(_.E.loader).load("removeDir.php","POST",{addr:_.$(".foldercontextmenu ").attr("data-addr")}, function(){
				loadItems(_.Environment.path);
			})
			return false;
		})
		
		_.$("body").click(function(){		
			_.$("form.contextmenu").style("display","none");
			
		})
	}
	
	
	//Включение/выключение бокового списка
	var changeAside = function(t){
		
		if(_.E.aside){
			_.$("aside").style({"width":"22%"});
			_.$("section").width("77%");
			_.$("section .appheader").width("calc(78% - 50px)");
			_.$("form.editor").width("75%");
			_.$("#hideAside").style({"background-image":"url(img/hide.png)"});
			_.$("aside ul").display("block");
			
		}else{
			_.$("aside").style({"width":"40px"});
			_.$("section").width("calc(100% - 50px)");
			_.$("section .appheader").width("calc(100% - 90px)");
			_.$("form.editor").width("calc(100% - 52px)");
			_.$("#hideAside").style({"background-image":"url(img/show.png)"});
			_.$("aside ul").display("none");
		}
	}
	_.$("#hideAside").click(function(){
		_.E.aside = (_.E.aside) ? 0 : 1;
		changeAside(this);
		rewriteEnvironment();
	})
	
	
	//Смена вида списка файлов
	var changeView = function(t){
		if(!t) t = _.$("#changeView");
		if(_.E.view){
			_.$("section>ul").removeClass("short");
			_.$(t).backgroundImage("url(img/view1.png)");
		}else{
			_.$("section>ul").addClass("short");
			_.$(t).backgroundImage("url(img/view2.png)");
		}
	};
	
	_.$("#changeView").click(function(){
		_.E.view = !_.E.view;
		changeView(this);
		rewriteEnvironment();
	})
	
	resetInterface = function(){
		changeView();
		changeAside();
	}
})