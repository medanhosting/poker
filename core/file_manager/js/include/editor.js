_.core(function(){
	
	
	
	//--------------
	resetList = function(){ 

		var T = _.all(".file");	
		var Z = _.RT(T.Container);
		T.remove();
		Z.append(_.first("ul#filelist"));
		
		

	var Temp = _.first('#filelist li').text();
	_.first("#filelist li").remove();
	
	if (_.all("h4.path").length==0){
	_.new("h4",Temp, {class: "path"}).append(_.first("form.dirs"));} else {
		_.first("h4.path").HTML(Temp);
	}

	_.all("#filelist li.dir").click( function(event){ 
			_.first(".fopen input").value(event.target.innerHTML); 
			_.first('.fopen #open').click();
		}) 

	_.all("#filelist li.file").click(function(event){

		
		
		_.first(".edit textarea").load("getfcontent.php", 'POST', {filename: event.target.innerHTML}, function(){
			
			_.first(".edit h4").HTML("Редактирование файла: "+event.target.innerHTML);
			_.first(".edit input[name='path']").value(event.target.innerHTML);
		

		}); 
			
	})	

	}


	_.first('.fopen #open').click(function(){

		var params = {filename: _.first(".fopen input").value()};
		_.first("ul#filelist").load("getfl.php", 'POST', params, resetList );		
		
	})
	
	_.first(".dirs a.add_folder").click(function(){
			
			
			if (_.first("form.add_folder").style("display")=="none") {_.first("form.add_folder").style("display", "block");}else{
			_.first("form.add_folder").style("display", "block");}

			_.first("form.add_folder input").click();
			
		});
	
	_.last("form.add_folder input").click(function(){

		var Name = _.first("form.add_folder input").value();

		_.first("form.add_folder h4").load('addfolder.php', 'POST', {folder: Name}, function(){
			
			window.setTimeout('_.first("form.add_folder").style("display", "none");	var params = {filename: "."};		_.first("ul#filelist").load("getfl.php", "POST", params, resetList );',
			500);
			
			
	
		});		

		
		
		

		});

	
	_.first("ul#filelist").load("getfl.php", 'GET', null, resetList);



	//window.setInterval('_.first("ul#filelist").load("getfl.php", "GET", null, resetList );', 500)

	_.all(".edit input[type='submit']").click(function(event){ 
		event.preventDefault();

		var params = {
				filename: _.first(".edit [name='path']").value(), 
				content: _.first(".edit textarea").value()
				};

		
		
		_.first(".edit h4.status").show().load("savefile.php", 'POST', params, function(){			
				
				_.first("ul#filelist").load("getfl.php", 'GET', null, resetList);	});
				 window.setTimeout('_.first(".edit h4.status").hide(1000);', 1000);
		
		
		
		
		})
	
		
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