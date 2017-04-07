_.core(function(){


	
	
	handler = function(e){
	
		target = e.target;
		while (target.tagName!="LI") target = target.parentNode;
		
		id = _.RT([target]).attr("data-id");
		val = _.$("li[data-id='"+id+"'] p").HTML();
		newVal = prompt("Новое значение переменной",val);
		
		if(newVal!=null){
			_.$("section ul").load("newVal.php","POST",{id: id, val: newVal}, function(){
				_.$("section li").click(handler);
			})
		}
	}
	
	_.$("section li").click(handler);
})