_.core(function(){

		A = {
			Data:{
				loader: "<p class='loader'> </p>"
				
			}
		};
			
		_.$("#add").click(function(){
		
			_.$("ul.items").load("add.php","GET",{},initList)
			
		})
	
	
	initList = function(){
		_.$("li.item>.clickable").click(function(e){
			
			var id = _.$(this).parent().attr("data-id");
			_.$("form.edit").HTML(A.Data.loader).post("form.php",{id:id},function(){
			
				initForm();
				_.E.id = id;
			})			
			_.$("li.item").removeClass("active");
			_.$(this).parent().addClass("active");
			
			_.$(".sublist ol").HTML("");
			_.$(this).parent().find(".sublist ol").get("list.php",{level: 1, id: _.$(this).parent().find(".sublist ol").data("parent")},initSubList);
		})
		
		_.$("ul.items>li>div>.btns>.remove").click(function(e){
		
			if (!confirm("Подтвердите удаление элемента. Для продолжения нажмите кнопку ОК.")) return; else
			var id = _.$(this).attr("data-id");
			_.$("ul.items").load("delete.php","POST",{id:id},initList)
			e.stopPropagation();
			_.$("form.edit").HTML("");
		})
		
		_.E.swap=0;
		_.$("li.item>.clickable").event("contextmenu",function(e){
			_.$("form.edit").HTML("");
			_.$("li.item").parent().removeClass("active");
			
			e.preventDefault();
			if(_.E.swap==0){
				_.E.swapA = _.$(this).parent().attr("data-id");
				_.$(this).parent().addClass('active');
				_.E.swap=1;
			}else{
				_.E.swapB = _.$(this).parent().attr("data-id");
				_.$(this).parent().addClass("active");
				
				_.$("aside ul").HTML(A.Data.loader).get("swap.php",{a: _.E.swapA, b: _.E.swapB},function(r){
					_.E.swap=0;
					_.$("li.item").removeClass("active");
					//if(r) alert(r);
					initList();
				})
			}
		})
	}
	
	initList();
	
	
	
	initSubList = function(){
		
		
		initAddButton = function(){
			_.$(".addSub").click(function(e){
				e.stopPropagation();
				var p = _.$(this).parent();
				p.HTML(A.Data.loader).get("add.php",{id: p.data("parent"), level: 1}, initSubList)
			})
		};
		
		initRemoveButtons = function(){
			
			_.$(".sublist li .remove").click(function(e){
				
				e.stopPropagation();
				if(!confirm("Подтвердите удаление. Это действие нельзя будет отменить.")) return;
				var t = _.$(this);
				
				t.HTML(A.Data.loader).post("delete.php",{id: t.data('id'), level: 1},function(r){
					
					if(!r.length)  t.parent(2)[0].outerHTML="";
					else alert(r)
				})
			})
		}
		
		initSL = function(){
				_.$(".sublist li>.clickable").click(function(e){
			
				var id = _.$(this).parent().attr("data-id");
				_.$("form.edit").HTML(A.Data.loader).post("form.php",{id:id, level: 1},function(){
			
					initForm(1);
					_.E.id = id;
					_.E.level = 1;
				})			
				_.$(".sublist li.item").removeClass("active");
				_.$(this).parent().addClass("active");
			
			})
		}
		
		initSwapper = function(){
			_.E.swap=0;
			_.$(".sublist li>.clickable").event("contextmenu",function(e){
				_.$("form.edit").HTML("");
				_.$("li.item").parent().removeClass("active");
				
				e.preventDefault();
				if(_.E.swap==0){
					_.E.swapA = _.$(this).parent().attr("data-id");
					_.$(this).parent().addClass('active');
					_.E.swap=1;
					_.E.pA = _.$(this).parent(2).data("parent");
				}else{
					_.E.swapB = _.$(this).parent().attr("data-id");
					_.$(this).parent().addClass("active");
					_.E.pB = _.$(this).parent(2).data("parent");
					
					_.$(".sublist ol[data-parent='"+_.E.pB+"']").HTML(A.Data.loader).get("swap.php",{a: _.E.swapA, b: _.E.swapB, level: 1},function(r){			
						_.E.swap=0;
						_.$(".sublist li").removeClass("active");
						
						_.$(".sublist ol[data-parent='"+_.E.pA+"']").HTML(A.Data.loader).get("list.php",{id: _.E.pA, level: 1}, initSubList);
						_.$(".sublist ol[data-parent='"+_.E.pB+"']").HTML(A.Data.loader).get("list.php",{id: _.E.pB, level: 1}, initSubList);
						
						//initSubList();
					})
				}
			})
		};
		
		initOpener = function(){
			_.$(".sublist li>.clickable .openList").click(function(e){
				e.stopPropagation();
				var t = _.$(this);
				_.$(".sublist li").removeClass("active");
				_.$(this).parent(3).addClass("active");
				
				_.$("form.edit").HTML(A.Data.loader).get("list.php",{id: t.data('parent'), level: 2}, function(){
					_.E.subcat = t.data('parent');
					initItemList()
				});
			})
		}
		
		initAddButton();
		initRemoveButtons();
		initSL();
		initSwapper();
		initOpener();
	}
	
	initItemList = function(){
		
		reloadItemList = function(){
			_.$("form.edit").HTML(A.Data.loader).get("list.php",{id: _.E.subcat, level: 2}, function(){						
						initItemList();
					});
		}
		
		initAddButton = function(){
			_.$("form.edit .addItem").click(function(){
				_.$("form.edit").HTML(A.Data.loader).get("add.php",{id:_.E.subcat, level: 2}, initItemList)
			})
		}
		
		initRemoveButton = function(){
			_.$("form.edit .remove").click(function(e){
				
				if(!confirm("Подтвердите удаление. Это действие нельзя будет отменить.")) return;
				e.stopPropagation();
				
				var t = _.$(this).parent(2);
				_.new("div").post("delete.php",{id: _.$(this).data("id"), level: 2},function(r){
					if(!r) t.remove();
					else alert(r);
				})
			})
		}
		
		initItems = function(){
			
			_.$("form.edit li>.clickable").click(function(e){
			
				
				var id = _.$(this).parent().attr("data-id");
				_.$("form.edit").HTML(A.Data.loader).post("form.php",{id:id, level: 2},function(){
			
					initForm();
					_.E.id = id;
					_.E.level = 2;
					
					initBackButton();
				})			
				_.$(".sublist li.item").removeClass("active");
				_.$(this).parent().addClass("active");
			
			})
			
			var initBackButton = function(){
				_.$("#reloadItems").click(reloadItemList);
			}
		
		}
		
		initSwapper = function(){
		
		}
		
		initRemoveButton();
		initAddButton();
		initItems();
		initSwapper();
	
	};
	
	initForm = function(i){
	
		
		_.$(".cImager").load("/core/modules/cImager","POST",{},function(){
	
			_.$(".cImager").display("none");
			
			_.cImager.init(_.E.imager, 
				function(i,s){
					_.$("#img").val=i;
					_.$(".cImager").display("none");
					
			});
			
			//_.$("#img").parent().click(function(e){e.preventDefault(); e.stopPropagation()})
			
			_.$("#img").click(function(e){
				//e.stopPropagation();
				_.$(".cImager").display("block");
			})
			
			
		})
		
		
		_.$("[data-id] .hidden").display("none");
		_.$("form.edit label>[data-id]").forEach(function(e){
			
			
			CKEDITOR.replace(
				e.data("id")
				,{
    				filebrowserUploadUrl: '/core/imager/upload.php'
				});
				
			CKEDITOR.instances[e.data("id")].setData(e.find(".hidden").HTML());
		})
		
		if(i){
			
			_.$("#body").parent().display('none');
			
			_.$("#openHead").click(function(){
				_.$("#body").parent().display('none');
				_.$("#head").parent().display('block');
			})
			
			_.$("#openBody").click(function(){
				_.$("#body").parent().display('block');
				_.$("#head").parent().display('none');
			})
			
			
	_.$("textarea.editor").event("keypress", function(event){
		
		var textarea =this;
		obj = textarea;		
		function brackets(str){
			if(document.selection)
      				 {
           				 document.selection.createRange().duplicate().text = str;
        			}
        			else if(obj.setSelectionRange)
        			{
           				var strFirst = obj.value.substr(0, obj.selectionStart);
 			            var strLast  = obj.value.substr(obj.selectionEnd, obj.value.length);

			            obj.value = strFirst + str + strLast;       
			            var cursor = strFirst.length + str.length-1;
			            obj.selectionStart = obj.selectionEnd = cursor;
			        }
			event.preventDefault();
			return false;
					
		}
		
		if (event.which==91){ brackets("[]"); return false;}
		if (event.which==40){ brackets("()"); return false;}
		if (event.which==123){ brackets("{}"); return false;}
		if (event.which==34){ brackets('""'); return false;}
		if (event.which==39){ brackets("''"); return false;}
		
		
	})
	
		_.$("textarea.editor").event("keydown", function(e){
			
			if (e.which==13){
			textarea = this;
			
			index = textarea.selectionStart;
			iS = index-1;
			text = textarea.value;			

			while((text[iS]!='\n')&&(iS>0)) iS--;			
			line = text.substr(iS,(index-iS));		
			
			tabs=0;
			for(i=0; i<line.length; i++){
				if (line[i]=='\t') tabs++;
			}
			
			
			if (tabs>0){
					obj=textarea;
					str="\n";
					for (i=0; i<tabs; i++){str+="\t";}					
					if(document.selection)
      				 {
           				 document.selection.createRange().duplicate().text = str;
        			}
        			else if(obj.setSelectionRange)
        			{
           			 var strFirst = obj.value.substr(0, obj.selectionStart);
 			           var strLast  = obj.value.substr(obj.selectionEnd, obj.value.length);

			            obj.value = strFirst + str + strLast;       
			            var cursor = strFirst.length + str.length;
			            obj.selectionStart = obj.selectionEnd = cursor;
			        }
				event.preventDefault();
				return false;
			}
			
			
			}else{
            	if (event.which==9){insertTab(e, e.srcElement);
			}

			}
			
			})
		}
		
		_.$("#save").click(function(){
			
			var s = new Object();
			
			//Сериализация всех id-элементов
			var els = _.$("form.edit>label>[id]");			
			var ids=[];
			els.forEach(function(e){
				if(e.id!='save'){
					ids.push(e.id);
				}
			},true)			
			s.id = _.E.id;			
			for(i in ids){
				s[ids[i]] = _.$("#"+ids[i]).val;
			}
			s.cata_level = _.E.level || 0;
			
			//Сериализация CKEDitor- элементов
			var els = _.$("form.edit [data-id]");
			els.forEach(function(e){
				var key = e.data('id');
				s[key] = CKEDITOR.instances[key].getData()
			})
			
						
			_.$("form.edit").HTML("Подождите, сохраняем...");
			
			_.$(".edit").post("save.php",s,function(){
				if(!_.E.level) _.$("ul.items").load("list.php","GET",{},initList)
				if(_.E.level==1){
					
					var id = _.$(".sublist li[data-id='"+_.E.id+"']").parent().data("parent");
					_.$(".sublist li[data-id='"+_.E.id+"']").parent().get("list.php",{id:id, level: 1},initSubList);
				}
				if(_.E.level==2){
					window.setTimeout(reloadItemList, 1500);
				}
			},
			function(r, code){
				 _.$("form.edit").HTML("Ошибка сохранения! HTTP-код "+code);
			})
		
		})
	}
	
	

})



function insertTab(evt, obj) 
{		
    evt = evt || window.event;
    var keyCode = evt.keyCode || evt.which || 0;
    
    if(keyCode == 9)
    {
        if(document.selection)
        {
            document.selection.createRange().duplicate().text = "	";
        }
        else if(obj.setSelectionRange)
        {
            var strFirst = obj.value.substr(0, obj.selectionStart);
            var strLast  = obj.value.substr(obj.selectionEnd, obj.value.length);

            obj.value = strFirst + "	" + strLast;
       
            var cursor = strFirst.length + "	".length;

            obj.selectionStart = obj.selectionEnd = cursor;
        }
        
        if(evt.preventDefault && evt.stopPropagation)
        {
            evt.preventDefault();
            evt.stopPropagation();
        }
        else {
            evt.returnValue = false;
            evt.cancelBubble = true;
        }
        
        return false;
    }
}