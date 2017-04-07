_.cEdit = new Object();

_.cEdit={
 	exec: function(e, c, a){
		document.execCommand(c,false,a);
		if(e) e.preventDefault()
	}
	
	,path: "/core/modules/cEdit/"

	,settings:{
	
		imgPath: "/img/cEdit/"
	}
	
	,field: _.$("#cEdit")
	,selection: ""
	
	,create: function(r){
		
		_.$("#"+r)[0].outerHTML = "<iframe src='"+_.cEdit.path+"' id='"+r+"' width='600' height='300'> </iframe>";
		_.$("#"+r).event("load", function(){
			_.cEdit.editors.push(_.cEdit.editor.create(r));
			alert();
		})
		
	}
	
	,editors: []
}

_.cEdit.editor={

	create: function(r){
		var o = {
		
			name: r
			 
		
		}
		o.document = _.$(_.$("#"+r)[0].contentWindow.document);
		o.field=o.document.find("#cEdit");
		
		o.exec = function(e, c, a){
			o.document[0].execCommand(c,false,a);
			if(e) e.preventDefault()
		}
		
		
		o.init = function(){
		
			o.exec(null,"enableobjectresizing");
			
			o.field.event("paste", function(e){
				o.field.find("pre").forEach(function(el){el.outerHTML = el.innerHTML;},true);
				o.document.find("#cEdit *").removeAttribute("class");
			})
			o.field.keyup(function(){
				if (o.field.find("pre").length>0 )
				o.field.find("pre").forEach(function(el){el.outerHTML = el.innerHTML;},true);
				o.document.find("#cEdit *").removeAttribute("class").removeAttribute("style");
			})
						
			o.document.find("#cEdit_bold").click(function(e){o.exec(e,"bold");})			
			o.document.find("#cEdit_underline").click(function(e){o.exec(e,"underline",null);})
			o.document.find("#cEdit_italic").click(function(e){o.exec(e,"italic",null);})			
			o.document.find("#cEdit_strike").click(function(e){o.exec(e,"strikethrough");})
			
			o.document.find("#cEdit_link").click(function(e){var l = prompt("Введите абсолютный адрес ссылки: ");
				if(l){ o.exec(e,"createlink",l)}				
			})
			
			o.document.find("#cEdit_unlink").click(function(e){o.exec(e,"unlink");})
			o.document.find("#cEdit_indent").click(function(e){o.exec(e,"indent");})
		
			
			o.document.find("#cEdit_outdent").click(function(e){o.exec(e,"outdent");})
			o.document.find("#cEdit_ol").click(function(e){o.exec(e,"insertorderedlist");})
			o.document.find("#cEdit_ul").click(function(e){o.exec(e,"insertunorderedlist");})
			o.document.find("#cEdit_alignL").click(function(e){o.exec(e,"justifyleft");})
			o.document.find("#cEdit_alignC").click(function(e){o.exec(e,"justifycenter");})
			o.document.find("#cEdit_alignR").click(function(e){o.exec(e,"justifyright");})
			o.document.find("#cEdit_alignJ").click(function(e){o.exec(e,"justifyFull");})
			
			o.document.find("#cEdit_undo").click(function(e){o.exec(e,"undo");})
			o.document.find("#cEdit_redo").click(function(e){o.exec(e,"redo");})
			
			
			o.document.find("#cEdit_img").change(function(e){
				o.document.find("#cEdit_image").backgroundImage("/core/modules/cEdit/icons/loading.gif");
				_.new("div").fileUpload("cEdit_img","/core/modules/cEdit/addImg.php",{path: _.cEdit.settings.imgPath},function(r){
				
					
					o.exec(null,"insertimage",r);
					o.exec(null,"enableObjectResizing")
					o.document.find("#cEdit_image").backgroundImage("/core/modules/cEdit/icons/image.png");
				})
			})
			
			o.document.find("#cEdit_fontsize").change(function(e){ 
			
				o.exec(e,"fontsize",o.document.find("#cEdit_fontsize").val);
			})
			
			//------FontFamily
			o.document.find("#cEdit_font ul").display("none");
			o.document.find("#cEdit_font").mouseover(function(e){
				o.selection = document.getSelection()
				if (o.selection.rangeCount>0) o.selection = o.selection.getRangeAt(0);
				
				o.document.find("#cEdit_font ul").display("block");
				var sel = o.document[0].getSelection();
				sel.removeAllRanges();
				sel.addRange(_.cEdit.selection);
			})
			
			o.document.find("#cEdit_font").mouseout(function(e){
				o.document.find("#cEdit_font ul").display("none");
			})
			o.document.find("#cEdit_font ul li").click(function(e){
				
				var sel = o.document[0].getSelection();
				sel.removeAllRanges();
				sel.addRange(o.selection);
				var font = _.RT(this).HTML();
				o.document.find("#cEdit_font span").HTML(font).fontFamily(font);
				o.exec(e,"fontname",font);	
				o.document.find("#cEdit_font ul").display("none");
				e.stopPropagation();
			})
			
		}
		
		o.init();
		return o;
	}
}
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