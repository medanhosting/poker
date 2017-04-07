_.core(function(e){
	
	_.$('.cEdit').get("/core/modules/cEdit",{},function(){
		
		_.cEdit.init("Global Gathering");
	})
	
	_.$('.cImager').get("/core/modules/cImager",{},function(){
		
		_.cImager.init(1,function(id, src){alert(src)});
		_.cImager.settings.height=50;
	})
	
	_.$('#save').click(function(e){document.write(_.cEdit.val);})
})