
Application = {
	Data:{
		name: _.c
		,parent:{
			id: 0
			,nest: -1
			,name: _.c
		}
		,levels: _.l
		,loader: "<div class='loading'> </div>"
		,list: -1
		,Form:{
			id: -1
			,nest: -1
		}
	}
	
	,Actions:{
		init: function(){
			Application.Actions.getElements(Application.Actions.List.init);
		}
		
		,getElements: function(f){
			_.$(".list").HTML(Application.Data.loader).get("modules/itemList.php",Application.Data.parent,function(){
				f();
				Application.Actions.ParentButton.init();
				Application.Actions.ParentSpan.init();
				Application.Actions.AddButton.init();
				Application.Actions.removeButtons.init();
				Application.Actions.keyInterface.listNavigation.init();
				Application.Actions.Editor.init();
				
			})
		}
		
		,List:{
			
			init: function(){
				_.$(".list li").click(Application.Actions.List.onClick)
			}
			
			,onClick: function(e){
				if(Application.Data.Form.id!==-1) return;
				var id = _.$(this).data("id");
				var nest = _.$(this).data("nest");
				if(nest<Application.Data.levels-1){
					Application.Actions.List.openChildrenOf(id,nest);
				}else{
					Application.Actions.List.noElementsInside(id,nest);
				}
			}
			
			,openChildrenOf(id,nest){
				Application.Data.parent.id = id;
				Application.Data.parent.nest = nest;
				Application.Actions.getElements(Application.Actions.List.init);
			}
			
			,noElementsInside:function(id, nest){
				alert("No more levels exist!");
			}
		
		}
		
		,ParentButton:{
			
			core: _.$("#back")
			,inited: 0
			,init: function(){
				if(Application.Data.parent.nest==-1){
					_.$("#back").display("none");
				}else{
					_.$("#back").display("inline-block");
				}
				if(!Application.Actions.ParentButton.inited){
					_.$("#back").click(Application.Actions.ParentButton.onClick);
					Application.Actions.keyInterface.initBack();
					Application.Actions.ParentButton.inited=1;
				
					
				}
				
				
			}
			
			,onClick:function(){
				if(Application.Data.Form.id!==-1) return;
				_.$('.list').HTML(Application.Data.loader);
				if(Application.Data.parent.nest==0){
					Application.Data.parent.nest=-1;
					Application.Actions.init();
					return;
				}
				
				_.new('div').get("modules/parent.php",Application.Data.parent,function(r){
					Application.Data.parent.nest--;
					Application.Data.parent.id = r;
					Application.Actions.init();
				})
			}
			
		}
		
		,ParentSpan:{
		
			init: function(){
				_.$("#t_id").HTML(Application.Data.parent.id);
				_.$("#t_level").HTML(Application.Data.parent.nest*1+1);
			}
		}
		
		,AddButton: {
		
			inited: 0
			,init: function(){
				if(!Application.Actions.AddButton.inited){
					Application.Actions.AddButton.inited=1;
					_.$('#add').click(Application.Actions.AddButton.onClick)
				}
			}
			
			,onClick: function(){
				if(Application.Data.Form.id!==-1) return;
				_.$(".list").HTML(Application.Data.loader).get("modules/add.php",Application.Data.parent,function(){
					Application.Actions.getElements(Application.Actions.List.init);
				})
			}
		}
		
		,removeButtons:{
			init: function(){
				_.$(".remItem").click(Application.Actions.removeButtons.onClick);
			}
		
			,onClick: function(e){
				if(Application.Data.Form.id!==-1) return;
				if(e)
					if(e.stopPropagation) 
						e.stopPropagation();
					
				var id = _.$(this).parent().data('id');
				var nest = _.$(this).parent().data('nest');
				
				_.new('div').get("modules/remove.php",{id:id, nest: nest, name: Application.Data.name},function(r){
					
					if(!r){
						_.$("li[data-id='"+id+"']").remove();
					}else{
						alert("Ошибка удаления элемента! "+r);
					}
				})
			}
		}
		
		,Editor: {
		
			init: function(){
			
				_.$(".list li .editItem").click(Application.Actions.Editor.Button.onClick)
			}
			
			,Button:{
			
				onClick: function(e){
					
					if(e)
						if(e.stopPropagation)
							e.stopPropagation();
					
					if(!_.$(this).hasClass("editItem"))	 return;
						
					var id = _.$(this).parent().data('id');
					var nest = _.$(this).parent().data('nest');
					
					Application.Actions.Editor.Form.init(id, nest, _.$(this).parent());
				}
			}
			
			,Form: {
			
				init: function(id, nest, el){
					Application.Data.Form.id = id;
					Application.Data.Form.nest = nest;
					
					el.find('table').HTML(Application.Data.loader).get("modules/form.php",{id: id, nest: nest, name: Application.Data.name}, Application.Actions.Editor.Form.launch);
				}
				
				,launch: function(r){
					
					_.$("table *").click(function(e){
						e.stopPropagation();
					})
					_.$(".list li").opacity("0.3")
					_.$('[data-id="'+Application.Data.Form.id+'"]').addClass("editing").opacity("1");
					_.$('[data-id="'+Application.Data.Form.id+'"] .editItem').addClass('save').removeClass('editItem');
					_.first("[data-id='"+Application.Data.Form.id+"'] textarea")[0].focus();
					_.$('[data-id="'+Application.Data.Form.id+'"] .save').click(Application.Actions.Editor.Form.serialize);
				}
				
				,serialize: function(){
				
					if(!_.$(this).hasClass("save")) return;
					
					var id = Application.Data.Form.id;
					var t = _.$("li[data-id='"+id+"'] textarea");
					var s ={};
					t.forEach(function(e){
						s[e.data('name')]=e.val;
					})
					s.id = Application.Data.Form.id;
					s.nest = Application.Data.Form.nest;
					
					Application.Actions.Editor.Form.save(s);
				}
				
				,save: function(s){
					
					s.cnm = Application.Data.name;
					
					var el = _.$('[data-id="'+s.id+'"] table');
					el.HTML(Application.Data.loader).post("modules/save.php",s,Application.Actions.Editor.reset);
					
				}
				
				
			}
			
			,reset:function(r){
				
				
				_.$(".list li").opacity("1");
				_.$('[data-id="'+Application.Data.Form.id+'"] .save').addClass('editItem').removeClass('save');
				
				Application.Data.Form.id=-1;
			}
		}
		,keyInterface: {
		
			initBack: function(){
			
				_.$("body").keydown(function(e){
					if(Application.Data.Form.id!==-1) return;
 					// Возврат на уровень выше в каталоге по нажатии на Backspace
						if ((e.keyCode==8)&&(e.ctrlKey==false)){
							e.preventDefault();
							Application.Actions.ParentButton.onClick();
						}					
				})
			}
			
			
			
			,listNavigation:{
				inited: 0
				,init: function(){
					Application.Data.list=-1;
					Application.Data.listCount = _.$(".list li").length;
				
					if(!Application.Actions.keyInterface.listNavigation.inited){
						_.$("body").keydown(function(e){
							if(Application.Data.Form.id!=-1) return;
							if(e.keyCode == 40){
								if(Application.Data.list<Application.Data.listCount-1){
									if(e.ctrlKey == false){									
										Application.Data.list++;
										Application.Actions.keyInterface.listNavigation.refresh(e);
									}else{
										Application.Data.list = Application.Data.listCount-1;
										Application.Actions.keyInterface.listNavigation.refresh(e);
									}
								}
							}
							if(e.keyCode == 38){
								if(Application.Data.list>0){
									if(e.ctrlKey == false){									
										Application.Data.list--;
										Application.Actions.keyInterface.listNavigation.refresh(e);
									}else{
										Application.Data.list = 0;
										Application.Actions.keyInterface.listNavigation.refresh(e);
									}
								}

							}
							if(e.keyCode == 13){
								Application.Actions.List.onClick.call(_.at(".list li", Application.Data.list)[0]);
							}
							if(e.keyCode == 46){
								Application.Actions.removeButtons.onClick.call(_.at(".list li .remItem", Application.Data.list)[0]);
								Application.Data.listCount--;
								
								if(Application.Data.list==0) Application.Data.list=1;
									else Application.Data.list--;
								Application.Actions.keyInterface.listNavigation.refresh(e);
							}
							if(e.keyCode == 32){
								Application.Actions.Editor.Button.onClick.call(_.at(".list li .editItem",Application.Data.list)[0]);
								Application.Data.list=-1;
								Application.Actions.keyInterface.listNavigation.refresh(e);
							}	
						})
						Application.Actions.keyInterface.listNavigation.inited=1;
					}	
				}
				
				
				,refresh: function(e){
					e.preventDefault();
					
					
					_.$(".list li").removeClass('focus');
					if(Application.Data.list==-1) return;
					var curr = _.at(".list li", Application.Data.list);
					
					elem=curr[0];
					var top=0;
					while(elem) {
						top+=parseFloat(elem.offsetTop);
						elem= elem.offsetParent;
					}
					top-=curr[0].offsetHeight;
					document.body.scrollTop = top;

					
					curr.addClass('focus');
					
				}
				
			}
		}
	}
}




_.A = Application;
_.core(function(){_.A.Actions.init()})