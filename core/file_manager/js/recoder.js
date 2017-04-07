_.first("textarea[name='content']").keypress(function(event){
	console.log(event.which);
}) 

function recode(content, stop){
  
  _.first(".code").Container[0].contentEditable = true;

	
	if (stop) {
		_.all("pre div").prependHTML("<i>\n</i>");
		recode(_.first("pre").text());
		return;
	}
	exp = /&emsp;&emsp;/g;
	content = content.replace(exp, "	");
	
	
	

 	exp = /[\<]+/;
  while(content.match(exp)){
  content = content.replace(exp,"&lt;");
  }
	exp = /[\>]+/;
  while(content.match(exp)){
  content = content.replace(exp,"&gt;");
  }
	
	
	 exp = /&/g;
	//content = content.replace(exp, "&#38;");

	//console.log(content);

	var filename = _.all("input[name='path']").value();

  if (filename.indexOf(".js",0)>0){

   var keys = Array("([^a-zA-Z0-9_])(function)(\\()", "( )(function)( )", "([^a-zA-Z0-9_])(for)([ ]*\\()", "()(in)()", "()(while)()", "()(if)()", "()(else)()", "()(var)()","()(string)()", "()(document)()","()(Array)()", "()(Object)()","([^a-zA-Z0-9_])(event)()","()(window)()", "()(RegExp)()", "( )(new)( )", "(=)(new)( )");
  for (var i=0; i<keys.length; i++){
  var exp = new RegExp(keys[i], "gm");
  content = content.replace(exp,"$1<span class='js_keyword'>"+"$2"+"</span>$3");
  }

  exp = /([^\>]{1})(\"[^\"\n]*\")([^\<]{1})/;
  while(content.match(exp)){
  content = content.replace(exp,"$1<span class='js_string'>"+"$2"+"</span>$3");
  }

  exp = new RegExp("(\/\/.*\/\/)","g");
  content = content.replace(exp,"<span class='js_comment'>"+"$1"+"</span>");
  
  exp = new RegExp("(\/\/.*)\n","g");
  content = content.replace(exp,"<span class='js_comment'>"+"$1"+"</span>\n");
  
  exp = new RegExp("(/\\*.+\\*/)","g");
  content = content.replace(exp,"<span class='js_comment'>"+"$1"+"</span>");
  


	//console.log(content);


  _.all("pre").HTML(content);

  _.all("span.js_string").forEach(function(element){var temp = element.textContent; element.innerHTML = ""; element.textContent = temp})
  _.all("span.js_comment").forEach(function(element){var temp = element.textContent; element.innerHTML = ""; element.textContent = temp})
  
  }

  var filename = _.all("input[name='path']").value(); 
  if (filename.indexOf(".css",0)>0) { 
  

   


    var keys = Array("margin-top", "margin-bottom", "margin-left", "margin-right", "margin",  "background-attachment", "background-clip", "background-color", "background-image", "background-origin", "background-position", "background-repeat","background-size", "background", "border-bottom", "border-bottom-color", "border-bottom-left-radius", "border-bottom-right-radius", "border-bottom-style", "border-bottom-width", "border-collapse", "border-color", "border-image", "border-left", "border-left-color", "border-left-style", "border-left-width", "border-radius", "border-right", "border-right-color", "border-right-style", "border-right-width", "border-spacing", "border-style", "border-top", "border-top-color", "border-top-left-radius", "border-top-right-radius", "border-top-style", "border-top-width", "border-width", "border",  "bottom","box-shadow", "box-sizing","caption-side", "clear", "clip", "color", "column-count", "column-gap", "column-rule", "column-width","columns", "content", "counter-increment", "counter-reset", "cursor", "direction", "display", "empty-cells", "float",  "font-family", "font-size", "font-stretch","font-style", "font-variant", "font-weight", "font", "left", "letter-spacing", "line-height", "list-style-image", "list-style-position", "list-style-type", "list-style", "margin-bottom", "max-height", "max-width", "min-height", "min-width", "opacity", "orphans","outline", "outline-color", "outline-offset", "outline-style", "outline-width", "overflow", "overflow-x", "overflow-y", "padding-top", "padding-bottom", "padding-left", "padding-right", "padding" , "page-break-after", "page-break-before", "page-break-inside", "position", "quotes", "resize", "right", "tab-size", "table-layout", "text-align","text-align-last", "text-decoration","text-decoration-color", "text-decoration-line", "text-decoration-style", "text-indent","text-overflow", "text-shadow", "text-transform", "top","transform", "transform-origin", "transition-delay", "transition-duration", "transition-property", "transition-timing-function", "transition",  "unicode-bidi", "vertical-align", "visibility", "white-space", "widows", "width",  "height", "word-break", "word-spacing", "word-wrap", "writing-mode", "z-index");
    for (var i=0; i<keys.length; i++){
    var exp = new RegExp("^([\s\t\v]*)("+keys[i]+")([\s]*:)", "gm");
    content = content.replace(exp,"$1<span class='css_property'>"+"$2"+"</span>$3");
    }
 
     var keys = Array("auto", "no-repeat", "repeat-x", "repeat-y", "none", "inherit", "solid", "double", "dashed", "inset", "outset", "white", "red", "green", "blue", "transparent","left", "right", "both", "pointer", "arrow", "block", "inline-block", "inline", "list-item", "table", "ltr", "rtl", "hidden", "scroll", "scroll-x", "scroll-y", "underline", "overline", "bold", "normal", "italic", "oblique","bolder", "x-small", "small", "large", "x-large", "smaller", "larger", "break-word", "center", "uppercase", "lowercase", "capitalize", "cover", "contain", "url", "serif", "black", "sans-serif", "monospace", "absolute", "relative", "fixed", "static", "Consolas", "Verdana", "Tahoma", "Calibri");
    for (var i=0; i<keys.length; i++){
    var exp = new RegExp("(:[^;]*)("+keys[i]+")", "g");
    content = content.replace(exp,"$1<span class='css_keyword'>"+"$2"+"</span>");
    }

    var keys = Array("px", "%", "pt", "em", "ex", "vh", "vw");
    for (var i=0; i<keys.length; i++){
    var exp = new RegExp("(:[^;]*)("+keys[i]+")(.*;)", "gm");
	
    content = content.replace(exp,"$1<span class='css_unit'>"+"$2"+"</span>$3");
    }

  	var exp = new RegExp("([\s]*)(\#[0-9a-fA-F]{3})([^0-9a-fA-F])", "g");
    content = content.replace(exp,"$1<span class='css_number'>"+"$2"+"</span>$3");
	
	var exp = new RegExp("([\s]*)(\#[0-9a-fA-F]{6})([^0-9a-fA-F])", "g");
    content = content.replace(exp,"$1<span class='css_number'>"+"$2"+"</span>$3");

    var exp = new RegExp("([\s]*)([0-9]+)", "g");
    content = content.replace(exp,"$1<span class='css_number'>"+"$2"+"</span>");
 	
	

   
    var exp = new RegExp("}(\n*.*\n*){", "g");
    content = content.replace(exp,"}<span class='css_selector'>"+"$1"+"</span>{");
    
    var exp = new RegExp("(\\.{1}[a-zA-Z0-9_]*)(\\s)", "g");
    content = content.replace(exp,"<span class='css_class'>$1</span>$2");
    var exp = new RegExp("(\\.{1}[a-zA-Z0-9_]*)(,)", "g");
    content = content.replace(exp,"<span class='css_class'>$1</span>$2");      
   
    
  

 	
	

  	_.all("pre").HTML(content);

  _.all("span.css_keyword").forEach(function(element){var temp = element.textContent; element.innerHTML = ""; element.textContent = temp})
  _.all("span.css_property").forEach(function(element){var temp = element.textContent; element.innerHTML = ""; element.textContent = temp})
  _.all("span.js_string").forEach(function(element){var temp = element.textContent; element.innerHTML = ""; element.textContent = temp})
	_.all("span.css_number").forEach(function(element){var temp = element.textContent; element.innerHTML = ""; element.textContent = temp})

  }

	

	if ((filename.indexOf(".php",0)>0)||(filename.indexOf(".html",0)>0)){

	var exp = /(&lt;)([a-zA-Z0-9]+)(&gt;)/g;
    content = content.replace(exp,"<span class='html_bracket'>$1</span><span class='html_tag'>"+"$2"+"</span><span class='html_bracket'>$3</span>");
	
	var exp = /(&lt;\/)([a-zA-Z0-9]+)(&gt;)/g;
    content = content.replace(exp,"<span class='html_bracket'>$1</span><span class='html_tag'>"+"$2"+"</span><span class='html_bracket'>$3</span>");
	
	var exp = /(&lt;)([a-zA-Z0-9]+)(\s{1}[^&]+)(&gt;)/g;
    content = content.replace(exp,"<span class='html_bracket'>$1</span><span class='html_tag'>"+"$2"+"</span>$3<span class='html_bracket'>$4</span>");

	exp = /([^\>]{1}[=]{1})(\"[^\"\n]*\")([\<\s]{1})/;
  while(content.match(exp)){
  content = content.replace(exp,"$1<span class='html_string'>"+"$2"+"</span>$3");
  }


	exp = /([\s])([a-zA-Z]+)([=])(\<span class=\'html_string)/gi
	content = content.replace(exp,"$1<span class='html_attr'>$2$3</span>$4");

	exp= /(&lt;!doctype html&gt;)/gi;
 	content = content.replace(exp,"<span class='css_class' style='text-transform: uppercase;'>$1</span>");

	_.all("pre").HTML(content);
}

  

  
  window.setTimeout("sizers(); ",20);
  
_.first("pre").keydown(function(event){

	if ((event.ctrlKey)&&(event.which == 83)){

		var text = _.first("pre").text();
		_.first("textarea").HTML("1");
		_.first("textarea").value(text);

		var params = {
				filename: _.first(".edit [name='path']").value(), 
				content: _.first(".edit textarea").value()
				};
		
		_.first(".edit h4.status").show().load("savefile.php", 'POST', params, function(){					
			//_.first("ul#filelist").load("getfl.php", 'GET', null, resetList);	
				recode(text);

			});
		window.setTimeout('_.first(".edit h4.status").hide(1000);', 1000);
	

		event.preventDefault();
		return false;
	}


	if (event.which == 9){
		insertTab(event, event.srcElement);

		var sel = document.getSelection();
		//console.log(sel);

		var str = sel.focusNode.data;
		str = str.split('');
		
		//console.log(str);
		var off = sel.baseOffset;

		//str[sel.baseOffset-1]+="	";
		str[off]="	"+str[off];	
		str = str.join('');

		sel.focusNode.data = str;
		var T = document.createRange();

		//console.log(sel); 
		var elem = sel.anchorNode;
		//console.log(off);

		T.setStart(elem, off+1);
		T.setEnd(elem, off+1);
		
		sel.removeAllRanges();
		sel.addRange(T);

		event.preventDefault();
		return false;
	}
})

  _.first("pre").keyup(function(event){

    
	if (((event.which <=40)&&(event.which >=33 ))||(event.which == 9)||(event.which == 17)||(event.which == 16)||(event.which == 27)||(event.which == 45)) return;
	
	
	type=false;
	if (event.which == 13){		
		//var sel = document.getSelection();
		//console.log(sel.focusNode);
		
		//sel.focusNode.data="\n"+sel.focusNode.data;
		//var type = sel.focusNode.nodeType-3;
		//var T = document.createRange();
		
		//if (sel.anchorNode == _.all("pre").Container[0].lastChild){
		//	console.log("!");
		//}

		//T.setStart(sel.focusNode,2);
		//T.setEnd(sel.focusNode,2);
		
		type = true;
		
	}

	


   sel = document.getSelection() || document.selection;
   
  var pre = _.all("pre").Container[0];

  var rng = document.createRange();
  rng.setStart(pre, 0);
  rng.setEnd(sel.anchorNode, sel.anchorOffset);
	var selLength = rng.toString().length;
	

  	//console.log(rng);

	
	recode(_.first('pre').Container[0].textContent, type);  
	var pre = _.all("pre").Container[0];

	
	var p = true;

	if (type) {selLength++}

	for (var i=0; (i<pre.childNodes.length)&&p; i++){
		
		selLength-=pre.childNodes[i].textContent.length;

		if (selLength<=0) { p=!p;
			var Offset = pre.childNodes[i].textContent.length + selLength;
			var Node = pre.childNodes[i];
			if (Node.tagName) Node = Node.firstChild;
		}
	}
	
	

	rng.setStart(Node, Offset);
	rng.setEnd(Node,Offset);

	sel.removeAllRanges();
	sel.addRange(rng);

   		   
        
    

           
    })
}


function sizers(){

  var H = _.all("pre").Container[0].scrollHeight;
  var Amo = Math.ceil(H/16);
  _.all(".coder ol").HTML("");
  for (var i=1; i<Amo; i++){ _.new("li",""+i).append(_.all(".coder ol"))}
}