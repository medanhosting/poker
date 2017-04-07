_.core(function(){

	
clock = function(i){

	if (i==null) i=0;
		
	watch = _.$("footer.time p.time");
	date = new Date();
	mins = date.getMinutes()+1<10 ? "0"+date.getMinutes() : date.getMinutes();	
	hrs = date.getHours(); 
	day = date.getDate()<10 ? "0"+date.getDate() : date.getDate();
	month = (date.getMonth()+1)<10 ? "0"+(1+date.getMonth()) : (1+date.getMonth());
	
	_.Environment.toggler=!_.Environment.toggler;
	
	str = hrs+(_.Environment.toggler ? ":" : " ")+mins+" "+day+"."+month;
	watch.HTML(str);
}

setInterval(clock, 500);
	_.Environment.toggler = true;
	
	
	
})