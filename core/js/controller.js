A={


	Data:{
		Templates:{
		
		}
	}
	
	,init: function(){
	
		A.Actions.init();
	}
	
	,Requests:{
		CreatePoint:{
			target: function(){return _.new("div");}
			,url: "modules/create.php"
			,go: function(d,f){
				this.target().post(this.url, d, f);
			}
		}
		
		,GetList: {
		
			url: "modules/list.php"
			,go: function(f){
				_.new("div").get(this.url,{},f);
			}
		}
		
		,RemovePoint: {			
			url: "modules/remove.php"
			,go: function(d,f){
				_.new("div").get(this.url,{point: d},f);
			}		
		}
		,ExtractPoint: {
			
			url: "modules/extract.php"
			,go: function(d,f){
				_.new("div").get(this.url,{point: d},f);
			}
		}
	}
	
	,Actions:{
		
		init: function(){
			this.Create.init();
			A.Data.Templates.list = _.$("template#list")[0].innerHTML;
			_.$("template#list").remove()
			
			
			_.applyTemplate = function(e, tpl, data){
				e.HTML("");
				for (i in data){
					var tp = tpl;
				
					
					do{
						var matches = /\{\{([a-zA-Z0-9]*)\}\}/ig.exec(tp);
						if(matches){
							tp = tp.replace(matches[0],(data[i][matches[1]]||""));
							
						}
						
						
					}while(matches);
					e.appendHTML(tp);
				}
			}
			
			this.List.init();
		}
		
		,List:{
		
			self: function(){ return _.$("aside.points ul");}
			
			,init: function(){
				this.refresh();
			}
			
			,refresh: function(){
				
				A.Requests.GetList.go(this.Items.init)
			
			}
			
			,Items:{
				
				init: function(r){
					var d = JSON.parse(r);
					_.applyTemplate(A.Actions.List.self(), A.Data.Templates.list, d);
					A.Actions.List.Items.RemoveButtons.init();
					A.Actions.List.Items.ExtractButtons.init();
				}
				
				,RemoveButtons:{
				
					self: function(){return _.$("aside .items .removePoint");}
					,init: function(){
						
						this.unevent();
						this.self().click(this.onClick);
						
					}
					
					,unevent: function(){
						this.self().unevent('click',this.onClick);
					}
					
					,onClick: function(){
					
						var d = _.$(this).attr("data-point");
						if(confirm("Вы действительно хотите удалить точку восстановления? Это действие невозможно отменить."))
						A.Requests.RemovePoint.go(d, function(r){
							if(r=='OK'){
								_.$("li[data-id='"+d+"']").remove();
							}else alert(r);
						});
					}
				}
				
				,ExtractButtons:{
				
					self: function(){return _.$("aside .items .extractPoint");}
					,init: function(){
						
						this.unevent();
						this.self().click(this.onClick);
						
					}
					
					,unevent: function(){
						this.self().unevent('click',this.onClick);
					}
					
					,onClick: function(){
					
						var d = _.$(this).attr("data-point");
						if(confirm("Вы действительно хотите восстановить систему до этой точки? Все изменения, произведенные после даты создания точки, будут утеряны."))
						A.Requests.ExtractPoint.go(d, function(r){
							alert(r);
						});
					} 
				}
			}
		}
		,Create:{
			init: function(){
			
				this.Button.init();
			}
			
			,Button: {
				
				self: function(){
					return _.$("#makepoint");
				}
				,init: function(){
					this.unevent();
					this.self().click(this.onClick);
				}
				
				,unevent: function(){
					this.self().unevent("click", this.onClick);
				}
				,onClick: function(){
					var data = A.Actions.Create.collectData();
					A.Actions.Create.Button.self().val = "Создаем точку восстановления...";
					A.Requests.CreatePoint.go(data, function(){
						A.Actions.List.refresh();
						A.Actions.Create.Button.self().val="Создать точку восстановления";
					});
				}
				
			}			
			
			,collectData: function(){				
				return {
					mysql: _.$("#mysql")[0].checked
					,files: _.$("#files")[0].checked
				}
			}
		}
	
	}

}





_.core(A.init)