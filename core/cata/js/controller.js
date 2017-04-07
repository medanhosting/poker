
Application = {
	Data:{
		Form: _.$("form.edit")
		,miniLoader: "<div class='miniLoader'> <p> </p> </div>"
		,successfullCheck: "<div class='success'> <p> </p> </div>"
		,successfullCheck: "<div class='unsuccess'> <p> </p> </div>"
		,Cata:{
			name: ""
			,nest: 0
		}
		,Creator:{
			field: ""
			,template: ""
		}
	}
	
	,Actions:{
	
		init: function(){
			Application.Data.Form = _.$('form.edit');
			Application.Actions.Elements.List.init();
			Application.Actions.Elements.AddButton.init();
		}
		
		
		,Elements:{
			
			List:{
			
				init: function(){
				
					_.$(".list li").click(Application.Actions.Elements.List.onClick);
					_.$(".list li .editCatalog").click(Application.Actions.Elements.List.editClick)
					_.$(".list li .generateCS").click(Application.Actions.Elements.List.generateClick)
				}
				
				,onClick: function(e){
					var name = _.$(this).data("name");
					window.open("/core/cata/editor?"+name);
				}
				
				,editClick: function(e){
					e.stopPropagation();
				
				}
				
				,generateClick: function(e){
					e.stopPropagation();
					var name = _.$(this).data('name');
					Application.Data.Form.HTML(Application.Data.miniLoader).get('modules/generateForm.php',{name: _.$(this).data('name')}, function(){
						Application.Data.generatorFor = name;
						Application.Actions.Elements.Form.Generator.init();
					 })
				}
				
				,refresh: function(){
				
					_.$(".list").get("modules/catalogList.php",{},Application.Actions.Elements.List.init);
				}
			}
			
			,AddButton: {
				init: function(){
					_.$("#addCatalog").click(Application.Actions.Elements.AddButton.onClick);
				}
				
				,onClick: function(){				
					Application.Data.Form.get("modules/new.php",{},Application.Actions.Elements.Form.Creator.init);
				}
			
			}
			
			
			,Form:{
				init: function(){
					Application.Data.Form.display("block");
				}
				
				,hide: function(){
					Application.Data.Form.display("none");
				}
				
				
				,Creator: {
					init: function(){
						Application.Actions.Elements.Form.Creator.Step1.init();
						
					}
					
					,Step1:{
						init: function(){
							
							_.$("input#catalogName").event("blur", Application.Actions.Elements.Form.Creator.Step1.nameField.onBlur);
							_.$("#catalogName").keyup(Application.Actions.Elements.Form.Creator.Step1.nameField.onBlur)
							_.$("#moreNest").click(Application.Actions.Elements.Form.Creator.Step1.moreNest.onClick)
							_.$("input[type='radio']").change(Application.Actions.Elements.Form.Creator.Step1.moreNest.changeRadio)
							_.$("#next").click(Application.Actions.Elements.Form.Creator.Step1.tryNext)
						}
						
						,nameField:{
							
							onBlur: function(e){
								var name = _.$(this).val;
								if(name==""){
									var r = "<p class='warn'> Имя каталога не может быть пустым!</p>";
									_.$(".stat").HTML(Application.Data.unsuccessfullCheck+r );
									_.$("#catalogName").borderColor("#a66");
									return;
								}
								_.$("#catalogName").borderColor("transparent");
								_.$(".stat").HTML(Application.Data.miniLoader).get("modules/check.php",{name:name},function(r){
									if(r) {
										_.$(".stat").HTML(Application.Data.unsuccessfullCheck+r );
										_.$("#catalogName").borderColor("#a66");
									}
									else _.$(".stat").HTML(Application.Data.successfullCheck);
								})
							}						
						}
						
						,moreNest:{
						
							onClick: function(){
							
								var val=prompt("Введите кол-во уровней каталога")
								if(val){
									if(!isNaN(parseInt(val))){
										if(parseInt(val)>0){
											_.$("#moreNest").val=parseInt(val);
											_.$("#moreNest").addClass("active");
											_.$("input[type='radio']").forEach(function(e){e.checked=false;},true);
										}else
											alert("Неверный числовой формат!")
									}else{
										alert("Неверный числовой формат!")
									}
										
								}
							}
							
							,changeRadio: function(){
								_.$("#moreNest").removeClass("active").val="Больше";
							}
						}
						
						,tryNext: function(){
							var name = _.$("#catalogName").val;
							if (_.$(".first .warn").length) return;
							if (_.$("#moreNest").hasClass('active')) var nest = _.$("#moreNest").val;
							else var nest = _.$("[name='nest']:checked").val;
							
							Application.Data.Cata.name=name;
							Application.Data.Cata.nest = nest;
							
							var f = Application.Actions.Elements.Form.Creator.Step2.init;
							_.$("form.edit").HTML(Application.Data.miniLoader).get("modules/new_levels.php",{name:name, nest: nest}, f);
							
						}
					
					}
					
					,Step2:{
					
						init: function(){
							
							_.$(".setType").click(Application.Actions.Elements.Form.Creator.Step2.typePicker.init)
							Application.Data.Creator.template = _.first(".field").HTML();							
							_.$(".addField").click(Application.Actions.Elements.Form.Creator.Step2.addButton.onClick)
							
							Application.Actions.Elements.Form.Creator.Step2.removeButtons.init();							
							Application.Actions.Elements.Form.Creator.Step2.Menu.init();
							
							Application.Actions.Elements.Form.Creator.Step2.unbind();
							Application.Actions.Elements.Form.Creator.Step2.bind();
							
						}
						,unbind: function(){
							_.$(".setType").unevent("click",Application.Actions.Elements.Form.Creator.Step2.typePicker.init)
							Application.Actions.Elements.Form.Creator.Step2.removeButtons.unbind();
							_.$("input[type='text']").unevent("click",Application.Actions.Elements.Form.Creator.Step2.dropBorder)
						}
						,bind: function(){
							_.$(".setType").click(Application.Actions.Elements.Form.Creator.Step2.typePicker.init)
							Application.Actions.Elements.Form.Creator.Step2.removeButtons.init();
							_.$("input[type='text']").click(Application.Actions.Elements.Form.Creator.Step2.dropBorder)
						}
						
						,dropBorder: function(e){
							
							_.$(this).borderColor("transparent");							
						}
						
						,typePicker:{
						
							init: function(e){
								
								if(Application.Data.Creator.button)
								if (this==Application.Data.Creator.button[0]){
									_.$(".type_label").display("none");
									Application.Data.Creator.button.removeClass("active");
									Application.Data.Creator.button="";
									return;
								}
								
								Application.Data.Creator.field = _.$(this).parent(2);
								Application.Data.Creator.button = _.$(this);
								var type = _.$(this).val;
								
								_.$(".type_label li").removeClass("active");
								_.$(".type_label li[data-type='"+type+"']").addClass("active");
								
								Application.Data.Creator.button.addClass("active");
								
								_.$(".type_label").display("block");
								var top=0;
								var left=0;
								elem = this;
								while(elem) {
									top+=parseFloat(elem.offsetTop);
									left+=parseFloat(elem.offsetLeft);
									elem= elem.offsetParent;
								}
								top-=69;
								left-=286;
								_.$(".type_label").top(top+"px").left(left+"px");
								
								_.$(".abstract_tab").click(function(e){
									_.$(".tabs a").removeClass("active");
									_.$(this).addClass("active");
									
									_.$("ul.primitive").display("none");
									_.$("ul.abstract").display("block");
									e.preventDefault();
								})
								
								_.$(".primitive_tab").click(function(e){
									_.$(".tabs a").removeClass("active");
									_.$(this).addClass("active");
									
									_.$("ul.primitive").display("block");
									_.$("ul.abstract").display("none");
									e.preventDefault();
								})
								
								_.$(".type_label li").click(Application.Actions.Elements.Form.Creator.Step2.typePicker.pick)
							}
							
							,pick: function(e){
								
								var el = _.$(this);
								var type = el.data('type');
								var set = el.parent().attr("class");
								
								var btn = Application.Data.Creator.button;
								btn.data("val", type);
								btn.val = type;
								btn.data("set", set);
								
								_.$(".type_label").display("none");
								btn.removeClass("active");
								Application.Data.Creator.button="";
								
							}
						}
						
						,addButton: {
						
							onClick: function(e){
								
								var level = _.$(this).data("level");
								var container = _.$(".level[data-level='"+level+"'] .fields");
								var nw = _.new("div").addClass('field').HTML(Application.Data.Creator.template);
								nw.appendTo(container);
								
								Application.Actions.Elements.Form.Creator.Step2.unbind();
								Application.Actions.Elements.Form.Creator.Step2.bind();
								
							}
						}
						
						,removeButtons: {
						
							init: function(){
								
								Application.Actions.Elements.Form.Creator.Step2.removeButtons.review();
								
								_.$(".remField").click(Application.Actions.Elements.Form.Creator.Step2.removeButtons.onClick);
							}
							
							,review: function(){
								var fields = _.$(".fields");
								fields.forEach(function(e){
									if(e.find(".field").length==1){
										e.find(".field .remField").display("none");
									}else
										e.find(".field .remField").display("inline-block");
								});
							}
							
							,unbind: function(){
								_.$(".remField").unevent("click",Application.Actions.Elements.Form.Creator.Step2.removeButtons.onClick);
							}
							
							,onClick: function(e){
								_.$(this).parent(1).remove();
								Application.Actions.Elements.Form.Creator.Step2.removeButtons.review();
							
							}
						}
						
						,Menu:{
						
							init: function(){
								var m = Application.Actions.Elements.Form.Creator.Step2.Menu;
								_.$("#back").click(m.Back.onClick);
								_.$("#save").click(m.Save.onClick);
							}
							
							,Save:{
								onClick: function(){
									Application.Actions.Elements.Form.Creator.Step2.Menu.Save.trySave();
								}
								
								,trySave: function(){
								
									var d = Application.Actions.Elements.Form.Creator.Step2.Serializer.go();
									if( d.err){
										alert(d.err);
										return;
									}
									Application.Actions.Elements.Form.Creator.Step2.Menu.Save.go(d);
								}
								
								,go: function(d){
									var s  = Application.Actions.Elements.Form.Creator.Step2.Menu.Save;
									_.$("#saveStatus").post('modules/createCatalog.php',{d:JSON.stringify(d), name: Application.Data.Cata.name}, s.after())
								}
								
								,after: function(r){
									Application.Actions.Elements.List.refresh();
								}
							}
							
							,Back:{
								onClick: function(){
									Application.Actions.Elements.AddButton.onClick();
								}
							}
						}
						
						,Serializer: {
						
							go: function(){
								var t = Application.Actions.Elements.Form.Creator.Step2.Serializer;
								var step1 = t.checkTableNames();
								if (step1.length>0){
									return {err: step1};
								}
								var step2 = t.checkFieldNames();
								if (step2.length>0){
									return {err: step2};
								}
								var k = t.setFieldTitles();
								if(k) alert("Автоматически дополнено "+k+" пустых заголовков полей.");
								
								var s = t.serialize();
								//console.log(s);
								return s;
								
							}
							
							,checkTableNames: function(){
								var els = _.$(".levelName");
								var s = els.map(function(e){return e.val;});
								var i = 0;
								var err= "";
								els.forEach(function(e){
									if (e.val.trim()==""){
										err+="Не заполнено название таблицы уровня "+i+"\n";
										e.borderColor("#a77");
									}									
									i++;
								});
								
								if(err.length>0){
									return err;
								}
								
								var i = 0;
								var j = 0;
								els.forEach(function(e){
									
									j=0;
									els.forEach(function(l){
										
										if(i>=j) {j++; return;}
										
										if(e.val.trim()==l.val.trim()){
											err+="Название уровня "+i+" совпадает с названием уровня "+j+"\n";
											e.borderColor("#a77");
											l.borderColor("#a77");
										}
										j++;										
									})
									i++;
								})
								return err;
							}
							
							
							,checkFieldNames: function(){
							
								var list = _.$(".fields");
								var l = 0;
								var err= "";
								
								list.forEach(function(el){
									
									var els = el.find(".fieldName");
									var i = 0;
									
									els.forEach(function(e){
										if (e.val.trim()==""){
											err+="Не заполнено название поля "+i+" таблицы уровня "+l+"\n";
											e.borderColor("#a77");
										}									
										i++;
									});
									
									l++;
								})	
																
								if(err.length)	return err;									
								var l = 0;
								list.forEach(function(el){									
									var els = el.find(".fieldName");				
									var i = 0;
									var j = 0;
									els.forEach(function(e){									
										j=0;
										els.forEach(function(m){										
											if(i>=j) {j++; return;}										
											if(e.val.trim()==m.val.trim()){
												err+="Название поля №"+i+" совпадает с названием поля №"+j+" на уровне "+l+"\n";
												e.borderColor("#a77");
												m.borderColor("#a77");
											}
											j++;										
										})
										i++;
									})									
									l++;
								})							
								return err;
							}
							
							,setFieldTitles: function(){
							
								var list = _.$(".fields");
								var k = 0;
								list.forEach(function(el){									
									var l = el.find(".field");
									l.forEach(function(e){
										if (e.find(".fieldTitle").val.trim()==""){
											e.find(".fieldTitle").val = e.find(".fieldName").val;
											k++;
										}
										
									})
								})
								return k;
							}
							
							,serialize: function(){
								var o = {};
								var title = Application.Data.Cata.name;
								
								var levels = _.$(".level");
								levels.forEach(function(l){
									
									var levelName = l.find(".levelName").val;
									levelName=title+"_"+levelName;
									
									var fields = l.find(".field");
									var skin={};
									
									fields.forEach(function(f){
										var name= f.find(".fieldName").val;
										var title = f.find(".fieldTitle").val;
										var type = f.find(".setType").val;
										
										skin[name]={type: type, title: title};
									})
									o[levelName]=skin;
								})
								return o;
							
							}
						}
					
					}			
				}
			 
			}
		
		}
	}
}












_.A = Application;
_.core(function(){Application.Actions.init();})