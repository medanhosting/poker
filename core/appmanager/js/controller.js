_.core(function(){

	var tabs = _.$(".categories li").length;
	_.at(".categories li a", 0).addClass("active");
	_.$(".wrapper .tabs>div").display("none");
	var currentTab = 0;
	_.$(".wrapper .tabs>div[data-tab='"+currentTab+"'] ").display("block");
	
	_.$(".categories li").click(function(){
		var currentTab = _.$(this).data("tab");
		_.$(".categories li a").removeClass("active");
		_.at(".categories li[data-tab='"+currentTab+"'] a").addClass("active");
		
		_.$(".wrapper .tabs>div").display("none");
		_.$(".wrapper .tabs>div[data-tab='"+currentTab+"'] ").display("block");
	})

	_.$("#search_query").event("keyup", function(e){
		var q = _.$(this).val;
		if(q.length<2) return;
		
		_.$(".wrapper .tabs>div").display("none");
		_.$(".categories li a").removeClass("active");
		_.$(".wrapper .searchtab").display("block");
		_.$(".wrapper .searchtab ol").HTML("");
		
		
		var lis = _.$(".wrapper li");
		var res="";
		lis.forEach(function(e){ if(e.find("h2").HTML().indexOf(q)!=-1) res+=e[0].outerHTML; console.log(e[0]) });
		console.log(res);
		_.$(".wrapper .searchtab ol").HTML(res);
		setHandlers();
	})
	setHandlers();

})


	setHandlers = function(){
		_.$(".install").unevent("click", installApplication);
		_.$(".install").click(installApplication);
	}
	
	installApplication = function(e){
		var archive = _.$(this).data("archive");
		var app = _.$(this).parent(3).data("app");
		var s = {archive:archive, app:app};
		//console.log(s);
		_.$(this).val = "Установка...";
		var t = _.$(this);
		_.E.app = s.app;
		
		_.new("div").get("install.php", s, function(r){
			if(r.indexOf("Error")==-1){
				t[0].outerHTML="<a href='/core/"+s.app+"'>Открыть </a>";
				
			}else alert(r);
		})
		
	}