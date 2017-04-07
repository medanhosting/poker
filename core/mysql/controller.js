_.core(function(){

	_.$("textarea")[0].focus();
	_.$("aside ul li xmp").click(function(e){
		_.$('aside textarea').val = _.$(this).HTML().trim();
	})
	_.$("section>p.info").click(function(){
		_.$('aside textarea').val = _.$(this).HTML().trim();
	})
	
	_.$("body *").keydown(function(e){
		e.stopPropagation();
		if(e.which==13)
			if(e.ctrlKey==true){
				_.$("#execute")[0].click();
			}
		console.log(e.which)
	})
	
	_.$("td").mouse(function(){
		var i = 0;
		var n = 1;
		var t = this;
		_.$(this).parent().find("td").forEach(function(e){
			i++;
			if(t==e) n=i;			
		}, true);
		
		_.$("td").removeClass("active");
		_.$("td:nth-child("+n+")").addClass("active");
	}
	, function(){
		_.$("td").removeClass("active");
	})
	
	_.$("td xmp").click(function(){
		
		_.$(this).parent(2).find("xmp").maxHeight("none")
	});
})