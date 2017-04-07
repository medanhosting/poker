var Generator={};
Application.Actions.Elements.Form.Generator = {
	
	Data: {
		Result:{
			
		}
	}
	
	,init: function(){
		Generator = Application.Actions.Elements.Form.Generator;
		Application.Data.Generator = Object();
		Application.Data.Generator.Levels = _.$("form.edit fieldset");
		_.$("form.edit fieldset").display("none");
		
		Generator.Data.Levels =_.$("form.edit fieldset");
		
		Generator.Levels.init(0);
		
	}
	
	,Levels:{
		
		init: function(l){			
			_.$(".generateNext").click(Generator.Levels.next)
			Generator.Levels.open(0);
		}
		
		,next: function(){
			Generator.Levels.open(Generator.Data.level+1);
		}
		
		,open: function(l){
			Generator.Data.Levels.display("none");
			_.at("form.edit fieldset", l).display("block");
			Generator.Data.level = l;
			
			Generator.Levels.Form.init(l)
		}
		
		,Form :{
			init: function(l){
			
				var form = _.at("form.edit fieldset", l);
				
				if (Generator.Data.level>0){
					var l = Generator.Data.level-1;
					if(_.at("form.edit fieldset",l).find(".childrenLoad select").val==1){
						_.$(form.find(".templateSelects select")[1]).display("none");
						_.$(form.find(".templateSelects select")[0]).display("block");
					}else{
						_.$(form.find(".templateSelects select")[0]).display("none");
						_.$(form.find(".templateSelects select")[1]).display("block");
						_.at("form.edit fieldset",l+1).find(".childrenLoad select").val=2;
						_.$(_.at("form.edit fieldset",l+1).find(".childrenLoad select option")[0]).attr("disabled",'disabled');
					}
				}else
				_.$(form.find(".templateSelects select")[1]).display("none");
			
				Generator.Levels.Form.unevent(l);
				Generator.Levels.Form.Fields.init(l);
				Generator.Levels.Form.ListButtons.init(l)
			}
			
			,unevent: function(l){
				var form = _.at("form.edit fieldset", l);
				Generator.Levels.Form.Fields.unevent(l);
				Generator.Levels.Form.ListButtons.unevent(l);
				
			}
			
			,Fields:{
			
				init: function(l){
					var form = _.at("form.edit fieldset", l);
					form.find(".addVisibleField").click(Generator.Levels.Form.Fields.onAddClick);
					Generator.Levels.Form.Fields.removeButtons.init();
				
				}
				
				,unevent: function(l){
					var form = _.at("form.edit fieldset", l);
					form.find(".addVisibleField").unevent("click", Generator.Levels.Form.Fields.onAddClick);
					Generator.Levels.Form.Fields.Selects.unevent();
				}
				
				,onAddClick: function(){
					
					var form = _.at("form.edit fieldset", Generator.Data.level);
					var amo = form.find(".displayed p").length;
					if (amo>=_.$(form.find(".displayed p select")[0]).find("option").length-1){
						Generator.Levels.Form.Fields.AddButton.hide();	
					}else{
						Generator.Levels.Form.Fields.AddButton.show();	
					}
					
					var tpl = form.find(".displayed p")[0];
					tpl = _.$(tpl).HTML();
					var nw = _.new("p").HTML(tpl).appendTo(form.find(".displayed"));
					Generator.Levels.Form.Fields.removeButtons.init();
					Generator.Levels.Form.Fields.Selects.reinit();
					
				}
				
				,Selects:{
					self: function(){
						return _.$(_.at("form.edit fieldset", Generator.Data.level).find(".displayed select"));
					}
					
					,reinit: function(){
						
						Generator.Levels.Form.Fields.Selects.unevent();
						Generator.Levels.Form.Fields.Selects.onChange();
						Generator.Levels.Form.Fields.Selects.self().change(Generator.Levels.Form.Fields.Selects.onChange)
					}
					
					,unevent: function(){
						Generator.Levels.Form.Fields.Selects.self().unevent("change", Generator.Levels.Form.Fields.Selects.onChange)
					}
					
					,onChange: function(){
						var selects = Generator.Levels.Form.Fields.Selects.self();
						selects.find("option").removeAttribute("disabled");
						
						selects.forEach(function(t){
							var val = t.val;
							Generator.Levels.Form.Fields.Selects.self().find("option[value='"+val+"']").attr("disabled","disabled");
							t.find("option[value='"+val+"']").removeAttribute("disabled");
						});
						
					}
				}
				,AddButton:{
					
					self: function(){
						var form = _.at("form.edit fieldset", Generator.Data.level);
						var button = form.find(".addVisibleField");
						return button;
					}
					,hide: function(){						
						Generator.Levels.Form.Fields.AddButton.self().display("none");
					}
					
					,show: function(){
						Generator.Levels.Form.Fields.AddButton.self().display("inline-block");
					}
				}
				
				,removeButtons: {
					self: function(){
						var form = _.at("form.edit fieldset", Generator.Data.level);
						var buttons = form.find(".remVisibleField");
						return buttons;
					}
					
					,init: function(){
						var buttons = Generator.Levels.Form.Fields.removeButtons.self();
						Generator.Levels.Form.Fields.removeButtons.unevent();
						Generator.Levels.Form.Fields.removeButtons.redraw();						
						buttons.click(Generator.Levels.Form.Fields.removeButtons.onClick);
					}
					
					,redraw: function(){
						var buttons = Generator.Levels.Form.Fields.removeButtons.self();
						if(buttons.length==1) buttons.display("none");
						else buttons.display("inline-block");
					}
					
					,unevent: function(){
						var buttons = Generator.Levels.Form.Fields.removeButtons.self();
						buttons.unevent("click", Generator.Levels.Form.Fields.removeButtons.onClick);
					}
					
					,onClick: function(e){
						var t = _.$(this).parent();
						t.remove();
						Generator.Levels.Form.Fields.removeButtons.redraw();
						Generator.Levels.Form.Fields.AddButton.show();
						Generator.Levels.Form.Fields.Selects.reinit();
					}
				}
			}
			
			,ListButtons:{
				init: function(l){
					_.$(".listButtons_template").display("none");
					Generator.Data.Icons = _.$("#iconList").HTML().split("|");
					
					Generator.Levels.Form.ListButtons.AddButton.init();
				}
				
				,unevent: function(){
				
					Generator.Levels.Form.ListButtons.AddButton.unevent();
				}
				
				,AddButton: {
					self: function(){
						return (_.at("form.edit fieldset", Generator.Data.level).find(".addListButton"));
					}
					
					,init: function(){
						Generator.Levels.Form.ListButtons.AddButton.self().click(Generator.Levels.Form.ListButtons.AddButton.onClick);
					}
					
					,unevent: function(){
						Generator.Levels.Form.ListButtons.AddButton.self().unevent("click",Generator.Levels.Form.ListButtons.AddButton.onClick);
					}
					
					,onClick: function(){
						var tpl = _.first(".listButtons_template div").HTML();
						_.new("div").HTML(tpl).appendTo(_.at("form.edit fieldset", Generator.Data.level).find('.listButtons_list'));
						Generator.Levels.Form.ListButtons.Buttons.reinit();
					}
				}
				
				,Buttons:{
					reinit: function(){
						var g = Generator.Levels.Form.ListButtons.Buttons;
						g.unevent;
						g.RemoveButtons.init();
						g.Icons.init();
					}
					
					,unevent: function(){
						var g = Generator.Levels.Form.ListButtons.Buttons;
						g.RemoveButtons.unevent();
						g.Icons.unevent();
					}
					
					,RemoveButtons:{
						self: function(){
							return _.at("form.edit fieldset", Generator.Data.level).find(".removeListButton");
						}
						,init: function(){
							var s = Generator.Levels.Form.ListButtons.Buttons.RemoveButtons;
							s.self().click(s.onClick);
						}
						,unevent: function(){
							var s = Generator.Levels.Form.ListButtons.Buttons.RemoveButtons;
							s.self().unevent("click", s.onClick);
						}
						,onClick:function(){
							_.$(this).parent().remove();
						}
					}
					
					,Icons:{
						self: function(){
							return _.at("form.edit fieldset", Generator.Data.level).find(".example");
						}
						,init: function(){
							var s = Generator.Levels.Form.ListButtons.Buttons.Icons;
							s.self().click(s.onClick);
							s.self().event("contextmenu", s.onRightClick)
						}
						,unevent: function(){
							var s = Generator.Levels.Form.ListButtons.Buttons.Icons;
							s.self().unevent("click", s.onClick);
							s.self().unevent("contextmenu", s.onRightClick)
						}
						,onClick: function(){
							var n = _.$(this).attr("data-n");
							if(n==undefined) n=1;
							else
							if(n==(Generator.Data.Icons.length-1)) n=1;
							else n++;
							
							_.$(this).backgroundImage("url(/core/cata/icons/"+Generator.Data.Icons[n]+")");
							_.$(this).data("n",n);
							
						}
						,onRightClick: function(e){
							e.preventDefault();
							var n = _.$(this).attr("data-n");
							if(n==undefined) n=Generator.Data.Icons.length-1;
							else
							if(n==0) n=Generator.Data.Icons.length-1;
							else n--;
							
							_.$(this).backgroundImage("url(/core/cata/icons/"+Generator.Data.Icons[n]+")");
							_.$(this).data("n",n);
						}
					}
				}
			}
		} 
	
	}
}