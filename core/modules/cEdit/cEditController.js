_.cEdit = new Object();

_.cEdit={
 	exec: function(e, c, a){
		document.execCommand(c,false,a);
		if(e) e.preventDefault()
	}

	,settings:{
	
		imgPath: "/img/cEdit/"
	}
	
	,field: _.$("#cEdit")
	,selection: ""
}

Object.defineProperties(_.cEdit,{
	val:{
		get: function(){
			return _.$(".cEdit_fieldFrame pre").HTML();
		}
		
		,set: function(v){ _.cEdit.field.HTML(v);}
	}
})

_.cEdit.init = function(r){


	_.cEdit.exec(null,"enableobjectresizing");
	_.cEdit.field = _.$("#cEdit");
	
	_.cEdit.field.event("paste", function(e){
		_.cEdit.field.find("pre").forEach(function(el){el.outerHTML = el.innerHTML;},true);
	})
	_.cEdit.field.keyup(function(){
		if (_.cEdit.field.find("pre").length>0 )
		_.cEdit.field.find("pre").forEach(function(el){el.outerHTML = el.innerHTML;},true);
	})
	
	if(r) _.cEdit.val = r;
	
	_.$("#cEdit_bold").click(function(e){
	
		document.execCommand("bold",false,null);
		e.preventDefault();
	})
	
	_.$("#cEdit_underline").click(function(e){
	
		document.execCommand("underline",false,null);
		e.preventDefault();
	})
	
	_.$("#cEdit_italic").click(function(e){
	
		document.execCommand("italic",false,null);
		e.preventDefault();
	})
	
	
	_.$("#cEdit_strike").click(function(e){_.cEdit.exec(e,"strikethrough");})
	
	_.$("#cEdit_link").click(function(e){
	
		var l = prompt("Введите абсолютный адрес ссылки: ");
		if(l){ _.cEdit.exec(e,"createlink",l)}
		
	})
	_.$("#cEdit_unlink").click(function(e){_.cEdit.exec(e,"unlink");})
	
	_.$("#cEdit_indent").click(function(e){
	
		document.execCommand("indent",false,null);
		e.preventDefault();
	})
	
	
	_.$("#cEdit_outdent").click(function(e){_.cEdit.exec(e,"outdent");})
	_.$("#cEdit_ol").click(function(e){_.cEdit.exec(e,"insertorderedlist");})
	_.$("#cEdit_ul").click(function(e){_.cEdit.exec(e,"insertunorderedlist");})
	_.$("#cEdit_alignL").click(function(e){_.cEdit.exec(e,"justifyleft");})
	_.$("#cEdit_alignC").click(function(e){_.cEdit.exec(e,"justifycenter");})
	_.$("#cEdit_alignR").click(function(e){_.cEdit.exec(e,"justifyright");})
	_.$("#cEdit_alignJ").click(function(e){_.cEdit.exec(e,"justifyFull");})
	
	_.$("#cEdit_undo").click(function(e){_.cEdit.exec(e,"undo");})
	_.$("#cEdit_redo").click(function(e){_.cEdit.exec(e,"redo");})
	
	_.$("#cEdit_img").change(function(e){
		_.$("#cEdit_image").backgroundImage("/core/modules/cEdit/icons/loading.gif");
		_.new("div").fileUpload("cEdit_img","/core/modules/cEdit/addImg.php",{path: _.cEdit.settings.imgPath},function(r){
		
			
			_.cEdit.exec(null,"insertimage",r);
			_.cEdit.exec(null,"enableObjectResizing")
			_.$("#cEdit_image").backgroundImage("/core/modules/cEdit/icons/image.png");
		})
	})
	
	_.$("#cEdit_fontsize").change(function(e){ 
	
		_.cEdit.exec(e,"fontsize",_.$("#cEdit_fontsize").val);
	})
	
	//------FontFamily
	_.$("#cEdit_font ul").display("none");
	_.$("#cEdit_font").mouseover(function(e){
		_.cEdit.selection = document.getSelection()
		if (_.cEdit.selection.rangeCount>0) _.cEdit.selection = _.cEdit.selection.getRangeAt(0);
		
		_.$("#cEdit_font ul").display("block");
		var sel = document.getSelection();
		sel.removeAllRanges();
		sel.addRange(_.cEdit.selection);
	})
	_.$("#cEdit_font").mouseout(function(e){
		_.$("#cEdit_font ul").display("none");
	})
	_.$("#cEdit_font ul li").click(function(e){
		
		var sel = document.getSelection();
		sel.removeAllRanges();
		sel.addRange(_.cEdit.selection);
		var font = _.RT(this).HTML();
		_.$("#cEdit_font span").HTML(font).fontFamily(font);
		_.cEdit.exec(e,"fontname",font);	
		_.$("#cEdit_font ul").display("none");
		e.stopPropagation();
	})
}

_.core(_.cEdit.init)