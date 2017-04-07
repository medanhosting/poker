_.core(function(){

	
	handlerF = function(e){
		
		_.$("section.folder_list li ul").HTML("");
		_.$("#addTpl").remove();
		
		target = e.target;
		while(target.tagName!='LI') target = target.parentNode;
		id = _.RT([target]).attr("data-id");
		_.Environment.folder = id;
		
		_.$("section.folder_list li[data-id='"+id+"'] ul").load("getList.php","POST",{id:id}, function(){
			_.$("#addTpl").remove();
			_.$("section.folder_list li[data-id='"+id+"']").appendHTML("<input type='button' id='addTpl' data-id='"+id+"' value='+'/>");
			
			_.$("button.deleteItem").click(deleteT);
			_.$("#addTpl").click(addT);
			_.$("section.folder_list li h3").click(handlerF)
			_.$("section.folder_list li>ul li").click(handlerT);
			_.$("section.folder_list li h3").click(handlerF)
			_.$("input#addFolder").click(addF);
			_.$("button.deleteFolder").click(deleteF)
		})
	}
	
	
	addF = function(){
	
		name = prompt("Введите имя для новой папки");		
		if (!name) return; else
		_.$(".folder_list ul").load("addFolder.php","POST",{name:name},function(){
		
			_.$("section.folder_list li h3").click(handlerF)
			_.$("input#addFolder").click(addF);
			_.$("button.deleteFolder").click(deleteF)
		})
	}
	
	deleteF = function(e){
		id = e.target.getAttribute("data-id");
		if(!confirm("Действительно удалить папку? Все шаблоны внутри нее перестанут быть доступными!")) return;
		_.$(".folder_list ul").load("deleteFolder.php","POST",{id:id},function(){
		
			_.$("section.folder_list li h3").click(handlerF)
			_.$("input#addFolder").click(addF);
			_.$("button.deleteFolder").click(deleteF)
		})
	}
	
	
	
	
	addT = function(e){
	
		id = _.RT([e.target]).attr("data-id");
		name = prompt("Введите новое имя для шаблона(техническое)");
		
		if (!name) return; else
		_.$("section.folder_list li[data-id='"+id+"'] ul").load("addTpl.php","POST",{id:id, name: name}, function(){
		
			_.$("#addTpl").click(addT);
			_.$("section.folder_list li h3").click(handlerF)
			_.$("section.folder_list li>ul li").click(handlerT);
			_.$("button.deleteItem").click(deleteT);
		})
	}
	
	handlerT = function(e){
		
		target = e.target;
		while(target.tagName!='LI') target = target.parentNode;
		id = _.RT([target]).attr("data-id");
		
		_.$("section.edit_tpl").load("editor.php","POST",{id:id},function(){			
			_.$("input#saveTpl").click(saveT);			
		})
	
	}
	
	deleteT = function(e){
		event.stopPropagation();
		
		id = e.target.getAttribute("data-id")
		list = _.RT([e.target.parentNode.parentNode.parentNode.parentNode]);
		parent = list.attr("data-id");

		_.$("section.folder_list li[data-id='"+parent+"'] ul").load("deleteTemplate.php","POST",{id:id, parent:parent},function(){
			
			_.$("#addTpl").click(addT);
			_.$("button.deleteItem").click(deleteT);
			_.$("section.folder_list li>ul li").click(handlerT);			
			
		})
		return false;
	}
	
	saveT = function(){
		//alert();
		title = _.$(".edit_tpl #title").value();
		template = _.$(".edit_tpl #template").value();
		id = _.$("input#saveTpl").attr("data-id");
		
		_.$(".edit_tpl").load("editTpl.php","POST",{title:title, template:template, id:id}, function(){
			
			_.$("input#saveTpl").click(saveT);
			_.$("section.folder_list li ul").HTML("");
			_.$("#addTpl").remove();
			parent = _.$("#tplParent").value();
			_.$("section.folder_list li[data-id='"+parent +"'] ul").load("getList.php","POST",{id:parent }, function(){
				_.$("#addTpl").remove();
				_.$("section.folder_list li[data-id='"+parent +"']").appendHTML("<input type='button' id='addTpl' data-id='"+parent +"' value='+'/>");
				
				_.$("button.deleteItem").click(deleteT);
				_.$("#addTpl").click(addT);
				_.$("section.folder_list li h3").click(handlerF)
				_.$("section.folder_list li>ul li").click(handlerT);
			})
		})
		
	}
	
	
	_.$("section.folder_list li h3").click(handlerF)
	_.$("input#addFolder").click(addF);
	_.$("button.deleteFolder").click(deleteF)
})