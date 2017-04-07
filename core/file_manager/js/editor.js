_.core(function(){

	var editor = _.$("body>form.editor");
	var field = _.$("body>form.editor a");
	var selector = "body>form.editor";
	_.Environment.calls = 0;
	
	startEditor = function(addr, filename){
	
		editor.style("display","block");
		
		
		
		_.$("#editor-path").value(addr);
		_.$("#editor-name").value(filename);
		
		field.load("getFileContent.php","POST",{path:addr},function(data){
		
			editor.style("display","block");
			
			_.Environment.editor = ace.edit("editor");
			_.Environment.editor.setTheme("ace/theme/textmate");
			//crimson_editor
			
			//pastel_on_dark
			//textmate
			
			
			var ext = addr.split(".");
			ext = ext[ext.length-1].trim();
			switch(ext){
				case "php": mode = "php";	break;
				case "js": mode = "javascript";	break;
				case "html": mode = "html"; break;
				case "json": mode = "json"; break;
				case "sql": mode = "mysql"; break;
				case "css": mode = "css"; break;
				default: mode = "text"; break;
			}
			
			_.Environment.editor.setValue(data);
			_.Environment.editor.getSession().setMode("ace/mode/"+mode);
			
			_.Environment.editor.clearSelection()
			_.Environment.editor.getSession().setUseWrapMode(true);
			
			_.Environment.editor.commands.addCommand({
    			name: 'Close',
    			bindKey: {win: 'Esc',  mac: 'Esc'},
    			exec: function(editor) {
        			_.$("body>form.editor").display("none");
    			},
    			readOnly: false 
			});
			
			_.Environment.editor.commands.addCommand({
    			name: 'Save',
    			bindKey: {win: 'Ctrl+S',  mac: 'Command+S'},
    			exec: function(editor) {
        			var content =_.Environment.editor.getValue();
					var path = _.$("#editor-path").value();
					_.$(selector+" span.status").load("saveFileContent.php","POST",{path:path,content:content});
    			},
    			readOnly: false 
			});
			
						
			document.title = "Файл: ..."+addr.substr(this.length-15);
			
		})
		
		
	}

// 	handlerEditor = function(){
	
// 		field.event("keydown", function(e){
// 			if (e.ctrlKey){
// 				if(e.which == 83){
// 					e.preventDefault();
// 					var content = field.value();
// 					var path = _.$("#editor-path").value();
// 					_.$(selector+" span.status").load("saveFileContent.php","POST",{path:path,content:content});
// 					return false;
// 				}
// 			}else
// 				if (e.which== 27){
// 					editor.style("display","none");
// 					document.title="Менеджер файлов";
// 					return false;
// 				}
// 			else
// 			if (e.which==13){
// 			textarea = this;
			
// 			index = textarea.selectionStart;
// 			iS = index-1;
// 			text = textarea.value;			

// 			while((text[iS]!='\n')&&(iS>0)) iS--;			
// 			line = text.substr(iS,(index-iS));		
			
// 			tabs=0;
// 			for(i=0; i<line.length; i++){
// 				if (line[i]=='\t') tabs++;
// 			}
			
			
// 			if (tabs>0){
// 					obj=textarea;
// 					str="\n";
// 					for (i=0; i<tabs; i++){str+="\t";}					
// 					if(document.selection)
//       				 {
//           				 document.selection.createRange().duplicate().text = str;
//         			}
//         			else if(obj.setSelectionRange)
//         			{
//           			 var strFirst = obj.value.substr(0, obj.selectionStart);
//  			           var strLast  = obj.value.substr(obj.selectionEnd, obj.value.length);

// 			            obj.value = strFirst + str + strLast;       
// 			            var cursor = strFirst.length + str.length;
// 			            obj.selectionStart = obj.selectionEnd = cursor;
// 			        }
// 				event.preventDefault();
// 				return false;
// 			}
			
			
// 		}else{
//             if (event.which==9){insertTab(e, e.srcElement);
// 		}

// 		}
			
// 		})
		
// 	field.event("keypress", function(event){
		
// 		var textarea =this;
// 		obj = textarea;		
// 		function brackets(str){
// 			if(document.selection)
//       				 {
//           				 document.selection.createRange().duplicate().text = str;
//         			}
//         			else if(obj.setSelectionRange)
//         			{
//           				var strFirst = obj.value.substr(0, obj.selectionStart);
//  			            var strLast  = obj.value.substr(obj.selectionEnd, obj.value.length);

// 			            obj.value = strFirst + str + strLast;       
// 			            var cursor = strFirst.length + str.length-1;
// 			            obj.selectionStart = obj.selectionEnd = cursor;
// 			        }
// 			event.preventDefault();
// 			return false;
					
// 		}
		
// 		if (event.which==91){ brackets("[]"); return false;}
// 		if (event.which==40){ brackets("()"); return false;}
// 		if (event.which==123){ brackets("{}"); return false;}
// 		if (event.which==34){ brackets('""'); return false;}
// 		if (event.which==39){ brackets("''"); return false;}
		
		
// 	})
		
// 		_.$("#editor-save").click(function(){
		
// 			var content = field.value();
// 			var path = _.$("#editor-path").value();
// 			_.$(selector+" span.status").load("saveFileContent.php","POST",{path:path,content:content});
// 		})
// 	}
	
// 	handlerEditor();
})



// function insertTab(evt, obj) 
// {		
//     evt = evt || window.event;
//     var keyCode = evt.keyCode || evt.which || 0;
    
//     if(keyCode == 9)
//     {
//         if(document.selection)
//         {
//             document.selection.createRange().duplicate().text = "	";
//         }
//         else if(obj.setSelectionRange)
//         {
//             var strFirst = obj.value.substr(0, obj.selectionStart);
//             var strLast  = obj.value.substr(obj.selectionEnd, obj.value.length);

//             obj.value = strFirst + "	" + strLast;
       
//             var cursor = strFirst.length + "	".length;

//             obj.selectionStart = obj.selectionEnd = cursor;
//         }
        
//         if(evt.preventDefault && evt.stopPropagation)
//         {
//             evt.preventDefault();
//             evt.stopPropagation();
//         }
//         else {
//             evt.returnValue = false;
//             evt.cancelBubble = true;
//         }
        
//         return false;
//     }
// }