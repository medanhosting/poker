_.core(function(){

	_.$("#proceed").click(function(){
	
		_.$("section.main").load("installer.php","POST",{path:_.$("#path").value()},function(response){
		
				if (response=="OK") location.href="../";
		});
	})
})