_.cImager = {

	Data:{
		Modules:{
			index: "/core/modules/cImager/index.php"
			,imageList: "/core/modules/cImager/imageList.php"
			,stylesheet: "/core/modules/cImager/cImager.css"
			,uploadImage: "/core/modules/cImager/uploadImage.php"
		}
		,loader: "Загружаем изображения"
	}
	,replace: function(s){
		//s = {input: "image", folder: 0}
		if(!s.folder) s.folder = 0;
		var img = _.$("#"+s.input).val;
		
		if(_.$("link.cImager_style").length==0)
		_.new("link").attr("rel","stylesheet").addClass("cImager_style").attr("href",_.cImager.Data.Modules.stylesheet).appendTo(_.$("head"));
		
		
		_.new("div").get(_.cImager.Data.Modules.index,{img: img, folder: s.folder, input: s.input},function(r){
			_.$("#"+s.input)[0].outerHTML = r;
			_.cImager.init(s.input);
		})
	}
	
	,init: function(input){
		var window = _.$(".cImager_field[data-field='"+input+"']");
		var input = window.find("input#"+input);
		
		onClick  = function(){
						
					
						
						window.data("image",_.$(this).data("id"))
						window.data("folder",_.$(this).data("folder"))
						
						window.find(".cImager_main").attr("src",_.$(this).attr("src"));
						window.find(".cImager_window").display("none");
						
						input.val = _.$(this).data("id");
					};
		
		var reinit = function(){
			
			window.find(".cImager_content img").unevent("click",onClick)
			window.find(".cImager_content img").click(onClick)
					
					
		}
		
		window.find("select").change(function(){
						var folder = _.$(this).val;
						window.find(".cImager_window .cImager_content ul")
							.HTML(_.cImager.Data.loader)
							.get(_.cImager.Data.Modules.imageList,{image: input.val, folder: folder},function(){
								
								window.find(".cImager_content").data("folder",folder);
								reinit();
							})
					})
					
		window.find("input[type='file']").change(function(){
			
			var e = _.$(this);
			window.find("select").attr("disabled","disabled");
			
			_.new("div").fileUpload(e.attr("name"),_.cImager.Data.Modules.uploadImage,{folder:window.find(".cImager_content").data("folder"), img: window.data("image")},function(r){
				
				window.find(".cImager_content ul").prependHTML(r);
				window.find("select").removeAttribute("disabled");
				reinit();
				e.val="";
			});
		})
					
		window.find(".cImager_window").click(function(){
			window.find(".cImager_window").display("none");
		})
		
		window.find(".cImager_window>*").click(function(e){
			e.stopPropagation();
		})
		
		window.find("img.cImager_main").click(function(){
			
			window.find(".cImager_content").data("folder",window.data("folder"));
			window.find(".cImager_window").display("block");
			window.find(".cImager_window .cImager_content ul")
				.HTML(_.cImager.Data.loader)
				.get(_.cImager.Data.Modules.imageList,{image: input.val, folder: window.data("folder")},function(){
					
					reinit();
				})
				
		})
		
	}
}