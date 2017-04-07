A = {

	Data:{
		loader: "<div class='miniLoader'> <p> </p> </div>"
		,Modules:{
			folders: "modules/folders.php"
			,removeFolder: "modules/removeFolder.php"
			,addFolder: "modules/addFolder.php"
			,getImages: "modules/getImages.php"
			,appendImage: "modules/addImage.php"
			,dragdrop: "modules/dragdrop.php"
			,removeImage: "modules/removeImage.php"
		}
		,Strings:{
			confirmRemove: "Подтвердите удаление папки:"
			,confirmImageRemove: "Подтвердите удаление изображения:"
			,createFolder: "Введите название новой папки:"
		}
	}
	
	,Actions:{
		init: function(){
			A.Actions.Folders.reload();
			A.Actions.Gallery.hide();
			A.Actions.Gallery.Controls.init();
		}
		
		
		,Gallery:{
			
			hide: function(){
				_.$(".imageList").display("none");
				_.$(".imageList ul").HTML("");
			}
			
			,show: function(){
				_.$(".imageList").display("block");
			}
			
			,load: function(id){
			
				//if(!id) id=_.E.folder;
				
			
				
				_.E.folder = id;
				
				this.show();
				_.$(".imageList ul").HTML(A.Data.loader).get(A.Data.Modules.getImages,{id: id}, A.Actions.Gallery.init);
				
			}
			
			,init: function(){
				A.Actions.Gallery.RemoveButtons.init();
			}
			
			,RemoveButtons:{
				init: function(){
				
					this.unevent();
					_.$(".removeImage").click(this.onClick);
				}
				
				,unevent: function(){
					_.$(".removeImage").unevent('click',this.onClick);
				}
				
				,onClick: function(){
					if(confirm(A.Data.Strings.confirmImageRemove)){
						var id = _.$(this).data('id');
						var t = _.$(this);
						_.new("div").get(A.Data.Modules.removeImage,{id:id},function(r){
							if(r.trim()=="OK"){
								t.parent(2).remove();
							}else{
								alert(r);
							}
						})
					}
				}
			
			}
			
			,Controls:{
				init: function(){
					_.$("#image").change(this.appendImage);
						
					_.$("section ul").event("dragenter", this.handlerDrag);
					_.$("section ul").event("dragleave", this.handlerDrag);
					_.$("section ul").event("dragover", this.handlerDrag);
					_.$("section ul").event("drop", this.handlerDrag);
			
					_.$("section ul li").event("dragenter", function(e){e.stopPropagation(); e.preventDefault(); return false; });
		
				}
				
				//Перетаскивание файлов
				,handlerDrag:  function(e){
						e.preventDefault();
						e.stopPropagation();
						elem = _.$("section ul");
						
						
						if (e.type=='drop'){
							
							if (_.E.sending==1) return;
							_.E.sending=1;				
							var files = event.dataTransfer.files, info="",i=0, len;
							
							i=0;
							len = files.length;		
							var data = new FormData(), i=0;		
							while(i < len){
								info+=JSON.stringify(files[i])+"<br/>";
								data.append("file"+i,files[i]);
								i++;
							}
							
							data.append("folder", _.E.folder);
							var xhr = new XMLHttpRequest();
							xhr.open("post",A.Data.Modules.dragdrop,true);
							xhr.onreadystatechange = function(){
							
								if(xhr.readyState == 4){
									elem.HTML(xhr.responseText);
									A.Actions.Gallery.load(_.E.folder);
								}
								_.E.sending=0;
							}
							elem.HTML("Подождите, сохраняем файлы ("+len+")");
							xhr.send(data);				
							
						
						}
						return false;
					}
				
				,appendImage: function(){
					
					
					if(!_.E.folder){
						_.$("#image").val="";
					} else{
						_.new("div").fileUpload("image",A.Data.Modules.appendImage,{folder: _.E.folder},function(){
							A.Actions.Gallery.load(_.E.folder);
							_.$("#image").val="";
						});
					}
					
				}
			} 
		}
		
		,Folders:{
		
			reload: function(){			
				_.$("aside ul").HTML(A.Data.loader).get(A.Data.Modules.folders,{},A.Actions.Folders.init);
				this.AddButton.init();
			}
			
			,init: function(){
				A.Actions.Folders.unevent();
				A.Actions.Folders.RemoveButtons.init();
				_.$("aside ul li h3").click(A.Actions.Folders.onClick);
				A.Actions.Folders.Errors.destroy();
			}
			
			,onClick: function(){
				var id = _.$(this).parent().data("id");
				
				_.$("aside li").removeClass("active");
				_.$(this).parent().addClass('active');
				
				A.Actions.Gallery.load(id);
			}
			
			,unevent: function(){
				A.Actions.Folders.RemoveButtons.unevent();
				_.$("aside ul li h3").unevent("click", A.Actions.Folders.onClick);
			}
			
			,Errors:{
				destroy: function(){
					
					if(!_.$("aside ul li.error").length) return;
					
					_.$("aside ul li.error").style("transition",".4s");
					setTimeout(function(){_.$("aside ul li.error").style("opacity","0");}, 2000);
					setTimeout(function(){_.$("aside ul li.error").remove();}, 2400);
				}
			}
			,AddButton:{
			
				init: function(){
					_.$("#addFolder").unevent(this.onClick);
					_.$("#addFolder").click(this.onClick);
				}
				
				,onClick: function(){
					var name = prompt(A.Data.createFolder);
					if(name){
						_.new("div").post(A.Data.Modules.addFolder,{name: name},function(r){
							_.$("aside ul").appendHTML(r);
							A.Actions.Folders.init();
						})
					}
				}
			}
			
			,RemoveButtons: {
				init: function(){
					_.$("aside ul li .remove").click(this.onClick);
				}
				,unevent: function(){
					_.$("aside ul li .remove").unevent("click",A.Actions.Folders.RemoveButtons.onClick);
				}
				
				,onClick: function(){
					var id = _.$(this).data("id");
					if (confirm(A.Data.Strings.confirmRemove)){
						
						_.new("div").get(A.Data.Modules.removeFolder,{id: id},function(r){
							if(r.trim()=="OK") _.$("aside li[data-id='"+id+"']").remove();
							else alert(r);
						})
					}
				}
			}
		}
	}
	
	,init: function(){
		A.Actions.init();
	}
}



_.core(function(){A.init()})