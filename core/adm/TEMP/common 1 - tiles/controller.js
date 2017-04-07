_.core(function(){


			
		_.$("#add").click(function(){
		
			_.$("ul.items").load("add.php","GET",{},initList)
			
		})
	
	_.$("section.form").display("none");
	_.$("section.form").click(function(){_.$("section.form").display("none");})
	_.$("section.form>*").click(function(e){e.stopPropagation()});
	
	
	initList = function(){
		_.$("section.form").display("none");
		_.$("li.item").click(function(e){
			
			var id = _.$(this).attr("data-id");
			_.$("form.edit").post("form.php",{id:id},function(){
			
				initForm();
				_.E.id = id;
			})			
			
		})
		
		_.$(".remove").click(function(e){
			if (!confirm("Подтвердите удаление элемента. Для продолжения нажмите кнопку ОК.")) return; else
			var id = _.$(this).attr("data-id");
			_.$("ul.items").load("delete.php","POST",{id:id},initList)
			e.stopPropagation();
			_.$("form.edit").HTML("");
		})
		
		_.E.swap=0;
		_.$("li.item").event("contextmenu",function(e){
			_.$("form.edit").HTML("");
			_.$("li.item").removeClass("active");
			
			e.preventDefault();
			if(_.E.swap==0){
				_.E.swapA = _.$(this).attr("data-id");
				_.$(this).addClass('active');
				_.E.swap=1;
			}else{
				_.E.swapB = _.$(this).attr("data-id");
				_.$(this).addClass("active");
				
				_.$("aside ul").get("swap.php",{a: _.E.swapA, b: _.E.swapB},function(r){
					_.E.swap=0;
					_.$("li.item").removeClass("active");
					//if(r) alert(r);
					initList();
				})
			}
		})
	}
	
	initList();
	
	initForm = function(){
	
		_.$("section.form").display("block");
		
		
		_.cImager.replace({input:"img"});
		
		
		_.$("[data-id] .hidden").display("none");
		_.$("form.edit label>[data-id]").forEach(function(e){
			
			
			CKEDITOR.replace(
				e.data("id")
				,{
    				filebrowserUploadUrl: '/core/imager/upload.php'
				});
				
			CKEDITOR.instances[e.data("id")].setData(e.find(".hidden").HTML());
		})
		
		
		
		_.$("#save").click(function(){
			
			var s = new Object();
			
			//Сериализация всех id-элементов
			var els = _.$("form.edit>label>[id],form.edit input[type='hidden'][id]");			
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
			
			//Сериализация CKEDitor- элементов
			var els = _.$("form.edit .ckeditor[data-id]");
			els.forEach(function(e){
				var key = e.data('id');
				s[key] = CKEDITOR.instances[key].getData()
			})
			
						
			_.$("form.edit").HTML("Подождите, сохраняем...");
			
			_.$(".edit").post("save.php",s,function(){
				_.$("ul.items").load("list.php","GET",{},initList)
			},
			function(r, code){
				 _.$("form.edit").HTML("Ошибка сохранения! HTTP-код "+code);
			})
		
		})
	}
	
	

})