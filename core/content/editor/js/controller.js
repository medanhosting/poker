var A = {

	Data:{
		listedContext: ""
		,page: 0
		,loader: "<div class='miniLoader'> <p> </p> </div>"
		,Atomic:{}
	}
	
	
	,start: function(){
		A.Actions.init()
		
		
	}
	
	,Actions:{
		
		init: function(){
			
			A.Data.field = _.$(_.$("#field")[0].contentWindow.document);
			A.Actions.enableEditing();
			A.Data.listedContext = _.$("#listedContext");
			A.Actions.Controls.init();
			A.Data.page = location.search.match(/^\?([0-9]+)/)[1]*1;
			A.Actions.Layout.hide();
		}
		
		,Layout:{
			
			show: function(){
				_.$("#layout").display('block');
			}
			
			,hide: function(){
				_.$("#layout").display("none");
			}
		
		}
		
		,enableEditing: function(){
			

			A.Data.field.find("[atomic]").attr("contenteditable", "true").click(A.Actions.null).change(A.Actions.null);
			
			_.new("style").attr("system","").HTML("[atomic]:hover{outline: 1px solid #df1298;} [listed]:hover{outline: 1px solid #13df98} .c_context_current{outline: 2px solid red!important} dynamic>*{opacity:0.2;} [current]{outline: 4px solid orange!important;} img[atomic]{cursor: pointer;} iframe[atomic]{-pointer-events:none;}").appendTo(A.Data.field.find("body"));
			
			
			
			A.Data.field.find("dynamic").forEach(function(e){
				var path = e.HTML();
				if(path[0]!='/') path="/"+path;
				e.get(path,{}, function(){e.attr("href",path)})
			})
			
			A.Data.field.find('[listed]').event("contextmenu", A.Actions.Listed.context);
			A.Actions.Listed.Context.init();
			
			A.Actions.Atomic.init();
		}
		
		,null: function(e){
			e.stopPropagation();
			e.preventDefault();
		}
				
		
		,Atomic:{
		
			
			
			init: function(){
				
				this.Context.init();
			}
			
			,setCurrent: function(c){
				A.Data.field.find("[current]").removeAttribute("current");
				c.attr("current", "current");
			}
			
			,unsetCurrent: function(){
				A.Data.field.find("[current]").removeAttribute("current");
			}
			
			,Context:{
				
				init: function(){
					var t = this;
					A.Actions.Atomic.Img.init();
					A.Actions.Atomic.A.init();
					A.Actions.Atomic.Iframe.init();
					A.Actions.Atomic.RichEdit.init();
					
					A.Actions.Atomic.Context.close();
					
					A.Data.field.find("body, [atomic]").click(function(e){
						if(e.target.tagName=="A") return;
						if(e.target.tagName=="IMG") return;
						
						
						if(e.target.tagName!="IMG")
							A.Actions.Atomic.Context.close()
					})
					
					
				
				}
				
				,unevent: function(){
					var t = this;
					A.Actions.Atomic.Img.unevent();
				}
				
				,close: function(){
					_.$("#atomicContext>*").display("none");
					A.Actions.Atomic.unsetCurrent();
				}
				
				,open: function(c){
					
					A.Actions.Atomic.Context.close();
					if(c=="img"){
						_.$("#imgContext").display("block");
					}
					
					if(c=="a"){
					
						_.$("#aContext").display("block");
					
					}
					
				}
			}
			
			,RichEdit:{
				init: function(){
					A.Data.field.find("[richedit]").click(A.Actions.Atomic.RichEdit.onClick);
					
					CKEDITOR.replace("ckeditor"
						,{
    						filebrowserUploadUrl: '/core/imager/upload.php'
						});
					A.Data.editor = CKEDITOR.instances.ckeditor;
					
					_.$("#ckaccept").click(A.Actions.Atomic.RichEdit.accept);
					_.$("#popupContext>*").click(function(e){
						e.stopPropagation();
					})
					
					_.$("#popupContext").click(function(e){
						_.$(this).display("none");
					})
				}
				
				,onClick: function(e){
					A.Data.richEdited = _.$(this);					
					A.Data.editor.setData(_.$(this).HTML()); 
					_.$("#popupContext").display("block");
				}
				
				,accept: function(e){
					var html = A.Data.editor.getData();
					A.Data.richEdited.HTML(html);
					_.$("#popupContext").display("none");
				}
			}
			
			,Iframe:{
			
				init: function(){
					A.Data.field.find("iframe[atomic]").forEach(function(e){
						var s = e.size();
						e.removeAttribute("atomic").removeAttribute("contenteditable");
						e[0].outerHTML = "<textarea code style='width: "+s.width+"px; height: "+s.height+"px;'>"+e[0].outerHTML+"</textarea>";
					});
				}
				
				,onClick: function(e){
					e.preventDefault();
					alert();
				}
			}
			
			,A:{
				
				init: function(){
					A.Data.field.find('a[atomic]').event('click', A.Actions.Atomic.A.onClick)
					this.setHandler();	
				}
				
				,unevent: function(){
					A.Data.field.find('a[atomic]').unevent('click', A.Actions.Atomic.A.onClick)
				}
				
				,onClick: function(e){
					e.stopPropagation();
					A.Data.Atomic.a = _.$(this);
					A.Actions.Atomic.Context.open("a");
					A.Actions.Atomic.A.open();
					A.Actions.Atomic.setCurrent(_.$(this));
					
				}
				
				,open: function(){
					_.$("#aHref").val = A.Data.Atomic.a.attr("href");
					_.$("#aTitle").val = A.Data.Atomic.a.attr("title");
					_.$("#aNofollow")[0].checked = A.Data.Atomic.a.attr("rel")=="nofollow" ? true : false;
					_.$("#aTargetblank")[0].checked = A.Data.Atomic.a.attr("target")=="_blank" ? true : false;
				}
				
				,setHandler: function(){
					_.$("#aSave").click(function(){
						A.Data.Atomic.a.attr("href", _.$("#aHref").val);
						A.Data.Atomic.a.attr("title", _.$("#aTitle").val);
						_.$("#aNofollow")[0].checked ? A.Data.Atomic.a.attr("rel","nofollow") : A.Data.Atomic.a.removeAttribute("rel");
						_.$("#aTargetblank")[0].checked ? A.Data.Atomic.a.attr("target","_blank") : A.Data.Atomic.a.removeAttribute("target");
						A.Actions.Atomic.Context.close();
					})
				}
				
			}
			
			,Img:{
				
				init: function(){
					A.Data.field.find('img[atomic]').event('click', A.Actions.Atomic.Img.onClick)
					this.setHandler();
				}
				
				,unevent: function(){
					A.Data.field.find('img[atomic]').unevent('click', A.Actions.Atomic.Img.onClick)
				}
				
				,onClick: function(e){
					
					A.Data.Atomic.img = _.$(this);
					A.Actions.Atomic.Context.open("img");
					A.Actions.Atomic.Img.open();
					A.Actions.Atomic.setCurrent(_.$(this));
					
				}
				
				,open: function(){
					_.$("#imgAlt").val = A.Data.Atomic.img.attr("alt");
				}
				
				,setHandler: function(){
					
					_.$("#imgSave").click(function(){
						
						var	alt=_.$("#imgAlt").val
						A.Data.Atomic.img.attr("alt", alt);
						
						if (_.$("#imgSrc").val){
							
							var d = _.new("div");
							_.$("#imgSave").val="Загружаем изображение...";
							d.fileUpload("imgSrc","/core/imager/uploadImg.php",{},function(r){
								var url = r;
								A.Data.Atomic.img.attr("src", r);
							
								_.$("#imgSrc").val="";
								_.$("#imgSave").val="Сохранить";
								A.Actions.Atomic.Context.close();
							})
							d.remove();
						}
						
						else
							A.Actions.Atomic.Context.close();
					})
				}
				
			}
			
			
		}
		
		
		,Listed:{
		
			context: function(e){
				
				e.preventDefault();
				e.stopPropagation();
				
				console.log(e);
				A.Data.listedContext.style({"top": e.screenY+(screen.availHeight-screen.height-50)+"px", "left": e.screenX+"px", "display": "block"});
			
				A.Data.currentListed = this;
				_.$(A.Data.currentListed).addClass("c_context_current");
				
				A.Data.field.find("body").click(function(){
					A.Actions.Listed.Context.close()
				})
			}
			
			,Context:{
				init: function(){
					A.Actions.Listed.Context.close()
					common = function(){
						A.Actions.Listed.Context.close()
					}
					
					_.$("#removeListed").click(function(){
						if(A.Data.currentListed){
							_.$(A.Data.currentListed).remove();
							common();
						}
					})
					
					_.$("#copyListed").click(function(){
						if(!A.Data.currentListed) return;
						
						if (A.Data.currentListed!==undefined) _.$(A.Data.currentListed).removeClass("c_context_current");
						var clone = A.Data.currentListed.cloneNode(true);
						A.Data.currentListed.parentNode.insertBefore(clone, A.Data.currentListed);
						common();
					})

				}
				
				,close: function(){
					if (A.Data.currentListed!==undefined) _.$(A.Data.currentListed).removeClass("c_context_current");
					A.Data.currentListed = 0;
					_.$("#listedContext").display("none");
					
				}
			}
		}
		
		
		,Controls:{
			init: function(){
			
				A.Actions.Controls.Save.init();
				A.Actions.Controls.Settings.init();
				A.Actions.Controls.Close.init();
			}
			
			,Close: {
				init: function(){				
					_.$("#close").click(function(){ window.close();});
				}
			}
			,Settings:{
				init: function(){
					_.$("#settings").click(A.Actions.Controls.Settings.onClick);
					_.$("#submit").click(function(){
						_.$("#mainContext").display("none");
					})
				}
				
				,onClick: function(){
					if(_.$("#mainContext").display()=="none") _.$("#mainContext").display("block");
						else _.$("#mainContext").display("none");
				}
			}
			
			,Save:{
				init: function(){
					_.$("#save").click(A.Actions.Controls.Save.onClick)
				}
				
				,onClick: function(){
					
					A.Actions.Atomic.unsetCurrent();
					A.Data.field.find("textarea[code]").forEach(function(e){
						var div = _.new("div");
						var iframe = _.new("iframe").appendTo(div);
						
						div.HTML(e.val);
						console.log(div.HTML());
						div.find("iframe").attr("atomic","");
						e[0].outerHTML = div.HTML();	
					});
					
				
					
					A.Data.field.find("body").find("iframe").HTML(" ");
					A.Data.field.find("body").find("[empty]").HTML(" ");
					A.Data.field.find("body").find("[system]").remove();
					A.Data.field.find("body").find("[contenteditable]").removeAttribute("contenteditable");
					
					
					A.Data.field.find("dynamic").forEach(function(e){
						if(e.attr("href"))
							e[0].outerHTML="[@|"+e.attr("href").slice(1)+"|@]";
					})
					var s = A.Data.field[0].body.innerHTML;
					
					var b = _.new("body").HTML(s);
					b.find("[atomic]").removeAttribute("atomic");
					b.find("[listed]").removeAttribute("listed");
					b.find("[empty]").removeAttribute("empty");
					b.find("[dynamic]").removeAttribute("dynamic");
					
					A.Actions.Save(s, b.HTML());
				}
			}
		}
		
		,Save: function(s,c){
			var id = A.Data.page;
			A.Actions.Layout.show();
			
			var title = _.$("#title").val;
			var keywords = _.$("#keywords").val;
			var description= _.$("#description").val;
			
			 
			_.$("header").post("modules/save.php",{html: s, gen: c,  id: id, title: title, description: description, keywords: keywords}, function(r){
				if(!r) location.reload();
			})
		}
	}

}

_.core(function(){
	_.$("#field")[0].onload = A.Actions.init;
})