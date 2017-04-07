_.Environment.catalogName =  (window.location.search.match(/[=].*$/))[0].substr(1);

function setHandler(e){

	var t = _.RT([e.target]);
	nest = t.attr("nest");
	id = t.attr("item");
	cata = t.attr("cata");	

	maxNest = _.$("#maxNest").value();
	curNest = _.$("#currentNest").value();
	
	if ((curNest - maxNest)<-1){
	_.$("#catalogEditorFileList").load("getChildren.php", "POST", {level: nest, parent: id, catalog: cata}, Handlers);}
	else alert("Нет предметов внутри!");
	
}

setBack = function(e){
	e.stopPropagation();
	var t = _.RT([e.target]);
	nest = t.attr("nest");
	id = t.attr("item");
	cata = t.attr("cata");	
	_.$("#catalogEditorFileList").load("getParent.php", "POST", {level: nest, parent: id, catalog: cata}, Handlers);
}

changeItem = function(e){
	e.preventDefault();
	var t = _.RT([e.target]);
	nest = t.attr("nest");
	id = t.attr("item");
	cata = t.attr("cata");	
	//alert("Changing in "+cata+" "+nest+" ->"+id);

	_.$(".changesForm").load("changeForm.php", "POST", {level: nest, parent: id, catalog: cata, data: _.$("#schema").value()}, function(){
			_.$(".changesForm").style("display","block");
			_.$(".back").style("display","block");	
			_.$("#applyChanges").click(applyChanges);
		})
	
	return false;
}	
_.$(".back").click(function(){ _.$(".changesForm").style("display","none"); _.$(".back").style("display","none"); });

applyChanges = function(e){
	var t = _.RT([e.target]);
	nest = t.attr("nest");
	id = t.attr("cid");
	cata = t.attr("cata");
	json = t.attr("json");
	json = JSON.parse(json);

	data = new Object();

	for(item in json){
		if (item=='tableName') continue;
		data[item]=(_.$(".changesForm #"+item).value()||_.$(".changesForm #"+item).HTML());
	}
	
	
	data["id"]=id;
	data["__nest"]=nest;
	data["__catalog"]=cata;
	
	console.log(data);
	
	_.$(".changesForm").HTML("<img src='img/loading.gif'/>");

	_.$(".changesForm").load("saveData.php","POST",data,function(){
		nest = _.$("#currentNest").value();
		parent = _.$("#currentParent").value();
		_.$("#catalogEditorFileList").load("getSiblings.php", "POST", {level: nest, parent: parent, catalog: cata}, Handlers);	
		window.setTimeout(function(){_.$(".changesForm").style("display","none"); _.$(".back").style("display","none"); },500);
	
	});
}

addItem = function(e){

	nest = _.$("#currentNest").value();
	parent = _.$("#currentParent").value();
	cata = (window.location.search.match(/[=].*$/))[0].substr(1);
	
		_.$("#catalogEditorFileList").load("addChild.php", "POST", {level: nest, parent: parent, catalog: cata}, 
			function(){
			_.$("#catalogEditorFileList").load("getSiblings.php", "POST", {level: nest, parent: parent, catalog: cata}, Handlers);
		});
}

deleteItem = function(obj){
	
	
	while(obj.tagName!="LI"){
		obj = obj.parentNode;
		console.log(obj);
	}
	id= _.RT([obj]).attr("item")
	nest =_.RT([obj]).attr("nest");
	
	if (nest==0){

		_.$("#catalogEditorFileList").load("deleteItem.php","POST",{level: 0, id:id, catalog:_.Environment.catalogName}, 
			function(){
				_.$("#catalogEditorFileList").load("getSiblings.php", "POST", {level: 0, parent: 0, catalog: _.Environment.catalogName}, Handlers);}
		);
		
	}else{
		parentNest = nest-1;
		parentId = _.first("#catalogEditorFileList li").attr("item");
		
		
		_.$("#catalogEditorFileList").load("deleteItem.php","POST",{level: nest, id:id, catalog:_.Environment.catalogName}, 
			function(){
				_.$("#catalogEditorFileList").load("getChildren.php", "POST", {level: parentNest, parent: parentId, catalog:  _.Environment.catalogName}, Handlers);
		});
	}

}
Handlers = function(){
	
	_.$("#catalogEditorFileList *").click(function(event){event.stopPropagation(); event.cancelBubble(); return false;});
	_.$("#catalogEditorFileList *").event("contextmenu",function(event){event.stopPropagation(); event.cancelBubble(); return false;});
	_.$("#catalogEditorFileList input.delete").click(function(event){deleteItem(event.target)});

	_.$("#catalogEditorFileList li").click(setHandler);	
	_.$("#goBack").click(setBack);
	_.$("#catalogEditorFileList li").event("contextmenu",changeItem);
	_.$("ul>p.add").click(addItem);

	maxNest = _.$("#maxNest").value();
	curNest = _.$("#currentNest").value();
	
	if ((curNest - maxNest)<-1){
		_.$("li").addClass("folder");
	}else{
		_.$("li").addClass("element");
	}
}

Handlers();