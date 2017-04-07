A = {

	Data: {
		Modules: {
			list: "modules/list.php"
			,addFile: "modules/addFile.php"
			,addFolder: "modules/addFolder.php"
			,removeItem: "modules/removeItem.php"
			,form: "modules/form.php"
			,saveArticle: "modules/saveArticle.php"
		}
	}
	
	,init: function(){
		A.Actions.init();
	}
	
	,Actions: {
	
		init: function(){
			A.Actions.List.load(0);
			A.Actions.List.Buttons.init(0);
		}
		
		,List:{
			load: function(parent){
				A.Actions.List.at(parent).get(A.Data.Modules.list,{parent: parent}, function(){
					A.Actions.List.reinit(parent);
				})
			}
			
			,at: function(id){
				return _.$("ul[data-parent='"+id+"']");
			}
			
			,reinit: function(parent){
				this.unevent(parent);
				this.init(parent);
				this.Buttons.init(parent);
			}
			
			,unevent: function(parent){
				this.at(parent).find("h4").unevent('click',this.onClick);
				this.at(parent).find("h4").unevent('contextmenu',this.onRightClick);
			}
			
			,init: function(parent){
				this.at(parent).find("h4").click(this.onClick);
				this.at(parent).find("h4").event('contextmenu',this.onRightClick);
			}
			
			,onClick: function(){
				var id = _.$(this).parent(2).data('id');
				var role='folder';
				if (_.$(this).parent(2).hasClass("file")) role = "file";
				
				if(role=="folder"){
					A.Actions.List.load(id);
				}
				
				if(role=='file'){
					_.E.parent = _.$(this).parent(3).data('parent');
					A.Actions.Form.load(id);
				}
			}
			
			,onRightClick: function(e){
				e.preventDefault();
				var id = _.$(this).parent(2).data('id');
				var parent = _.$(this).parent(3).data('parent');
				var t = _.$(this).parent(2);
				
				if(confirm("Подтвердите удаление элемента: ")){
					_.new("div").get(A.Data.Modules.removeItem,{id:id},function(){
						t.remove();
						//A.Actions.List.load(parent);
					})
				}
			}
			
			,Buttons:{
			
				init: function(parent){
				
					this.unevent(parent);
					this.at(parent, "addFile").click(this.onFileClick);
					this.at(parent, "addFolder").click(this.onFolderClick)
				}
				
				,at: function(parent, role){
					return _.$("input."+role+"[data-parent='"+parent+"']");
				}
				
				,unevent: function(){
					this.at(parent, "addFile").unevent("click", this.onFileClick);
					this.at(parent, "addFolder").unevent("click", this.onFolderClick)
				}
				
				,onFileClick: function(){
					var name = prompt("Введите название новой статьи в этой папке:");
					var parent = _.$(this).data("parent")
					if(name){
						_.new("div").get(A.Data.Modules.addFile,{name: name, parent: parent},function(){
							A.Actions.List.load(parent);
						})
					}
					
				}
				
				,onFolderClick: function(){
					var name = prompt("Введите название новой папки в этой папке:");
					var parent = _.$(this).data("parent")
					if(name){
						_.new("div").get(A.Data.Modules.addFolder,{name: name, parent: parent},function(){
							A.Actions.List.load(parent);
						})
					}
				}
			}
		}
		
		,Form:{
			load: function(article){
				_.E.article = article;
				_.$("section").get(A.Data.Modules.form,{id:article},A.Actions.Form.init)
				
				
			}
			
			,init: function(){
				
				A.Actions.Form.Buttons.setup();
				
				_.$("#save").click(function(){
					
					var s = {
						id: _.E.article
						,title: _.$("#title").val
						,content: _.$("#content").HTML()
					}
					
					_.new("div").post(A.Data.Modules.saveArticle,s,function(r){
						if(r){
							alert(r);
						}else{
							A.Actions.Form.load(_.E.article);
						}
						A.Actions.List.load(_.E.parent)
					})
				})
			}
			
			,Buttons:{
			
				setup: function(){
					_.$("section .buttons .edit").removeClass('active');
					_.$("section .buttons .read").addClass('active');
					
					_.$("section form").display("none");
					
					_.$("section .buttons .edit").click(function(){
						_.$("section .buttons>*").removeClass('active');
						_.$("section .buttons .edit").addClass('active');
						
						_.$("section article").display("none");
						_.$("section form").display("block");
					})
					
					_.$("section .buttons .read").click(function(){
						_.$("section .buttons>*").removeClass('active');
						_.$("section .buttons .read").addClass('active');
						
						_.$("section form").display("none");
						_.$("section article").display("block");
					})
				}
			}
		}
	}
}

_.core(A.init)