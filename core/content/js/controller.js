var A = {

	Data:{
		loader: "<div class='miniLoader'> <p> </p> </div>"
		,saveButton: "Сохранить параметры страницы"
	}
	
	,init: function(){
		A.Actions.init();
	}
	,Actions:{
		init: function(){
			A.Actions.Pages.init();
			
		}
		
	
	
		,Pages:{
		
			init: function(){
			
				A.Actions.Pages.AddButton.init();
				A.Actions.Pages.List.init();
			}
			
			,AddButton:{
				init: function(){
					_.$("#addPage").click(A.Actions.Pages.AddButton.onClick);
				}
				
				,onClick: function(){
					_.$("ul#pages").get("modules/pages/add.php",{id:0},function(){
						A.Actions.Pages.List.init();
					});
				}
			
			}
			
			,List: {
			
				init: function(){
					
					A.Actions.Pages.List.unevent();
					_.$("#pages li").click(A.Actions.Pages.List.onClick);
					A.Actions.Pages.List.AddButtons.init();
					A.Actions.Pages.List.RemoveButtons.init();
				}
				
				,unevent: function(){
					_.$("#pages li").unevent("click",A.Actions.Pages.List.onclick);
					A.Actions.Pages.List.AddButtons.unevent();
				}
				
				,onClick: function(e){
					e.stopPropagation();
					var t = _.$(this);
					var ol = t.find("ol");
					
					var id = t.data("id");
					
					A.Data.page = id;
					A.Actions.Pages.Form.init();
						
					ol.HTML(A.Data.loader).get('modules/pages/list.php',{id:id}, function(){
						A.Actions.Pages.List.init();
						
						_.$("#pages li").removeClass("active");
						t.addClass("active");
					})
				}
				
				,AddButtons:{
				
					init: function(){					
						_.$(".pages .addPage").click(A.Actions.Pages.List.AddButtons.onClick);
					}
					
					,unevent: function(){
						_.$(".pages .addPage").unevent("click", A.Actions.Pages.List.AddButtons.onClick);
					}
					
					,onClick: function(){
					
						var t = _.$(this);
						var ol = t.parent();
						var id = t.data("parent");
						ol.get("modules/pages/add.php",{id: id}, A.Actions.Pages.List.init);
						
						
					}
				}
				
				,RemoveButtons: {
				
					init: function(){
						
						_.$("#pages li>h3 input.removePage").click(A.Actions.Pages.List.RemoveButtons.onClick);
					}
					
					,unevent: function(){
						_.$("#pages li>h3 input.removePage").unevent("click", A.Actions.Pages.List.RemoveButtons.onClick);
					}
					,onClick: function(e){
						e.stopPropagation();
						if (confirm("Вы действительно хотите удалить эту страницу?")){
							var id = _.$(this).data("id");
							var l = _.$(this).parent(2);
							var parent = l.data("parent");
							l.HTML(A.Data.loader).get("modules/pages/removePage.php",{id:id, parent: parent}, A.Actions.Pages.List.init)
						}
					}
				}
			}
			
			,Form:{
				init: function(){
					_.$("form#editor").HTML(A.Data.loader).get("modules/pages/form.php",{id:A.Data.page},A.Actions.Pages.Form.handle);
				
				}
				
				
				,handle: function(){
					_.$("#save").click(A.Actions.Pages.Form.Save.onClick);
					_.$("#editor input, #editor textarea").change(A.Actions.Pages.Form.onChange).click(A.Actions.Pages.Form.onChange);
					A.Actions.Pages.Form.Templates.init();
				}
				
				,onChange: function(){
					_.$('#save').val=A.Data.saveButton;
				}
				
				,Save:{
					onClick: function(){
						var s = {
							id: A.Data.page
							,title: _.$("#title").val
							,description: _.$("#description").val
							,keywords: _.$("#keywords").val
							,url: _.$("#url").val
							,template: _.$("#template").val
						}
						
						_.new("div").get("modules/pages/save.php",s,function(r){
							_.$("#save").val = r;
							_.$("li[data-id='"+s.id+"'] h3").HTML(s.title);
						})
					}
				}
				
				,Templates:{
				
					init: function(){
						_.$("#templateFolder").change(this.onChangeFolder)
						console.log(this.onChangeFolder)
					}
					
					,onChangeFolder: function(){
					
						_.$("#template").get("modules/pages/templates.php",{id: _.$('#templateFolder').val});
					
					}
				}
				
			}
		
		}
		
		
	
	}


}




_.core(A.init)