	// DUMP for 26.02.2015
	//28-07: fixed error with _.new + outerHTML in putAfter
	
		RT = new Object();

		RT.Core = new Object();
		RT.Core.Container=new Array();

	function Core(Nodelist)
		{

			this.__proto__=RT.Core;
			
			this.Container=new Array();
			this.Container=RT.Core.Container;
			if (Nodelist) this.Container = Nodelist;

			

		}

		RT.Environment = new Object();
	//---------------------Core methods----------------//
			RT.Core.event = function(event, func)
			{
				for (var i=0; i<this.Container.length; i++)
				{
					this.Container[i].addEventListener(event, func);
				}

				return this;
			}

			RT.Core.HTML = function(val)
			{
		

				if (val||(val===""))
				{
					for (var i=0; i<this.Container.length; i++)
					{
					if(this.Container[i]) this.Container[i].innerHTML=val;
					}
					return this;
		
				}


				var s="";
				for (var i=0; i<this.Container.length; i++)
				{
					s+=this.Container[i].innerHTML+'\n';
				}
				return s;
			}

			RT.Core.appendHTML = function(val)
			{
				if (val)
				{
					for (var i=0; i<this.Container.length; i++)
					{
					this.Container[i].innerHTML+=val;
					}
					return this;
		
				}
			}

			RT.Core.prependHTML = function(val)
			{
				if (val)
				{
					for (var i=0; i<this.Container.length; i++)
					{
					this.Container[i].innerHTML=val+this.Container[i].innerHTML;
					}
					return this;
		
				}
			}
			
			
			RT.Core.text = function()
			{
				var s="";
				for (var i=0; i<this.Container.length; i++)
				{
					s+=this.Container[i].textContent;
				}
				
				return s;


			}

			RT.Core.value = function(val)
			{
				if (val){
					for (var i=0; i<this.Container.length; i++){
						this.Container[i].value=val;
					}
					return this;

				}


				var s="";
				for (var i=0; i<this.Container.length; i++)
				{
					if(this.Container[i].value)
					s+=this.Container[i].value;
				}
				//s=s.replace(/<\/?[^>]+>/gi, ' ');
				return s;


			}
			RT.Core.addClass = function(className)
			{
				for (var i=0; i<this.Container.length; i++)
				{
					if(!this.Container[i].classList.contains(className))
					this.Container[i].classList.add(className);
				}
				return this;
			}

			RT.Core.removeClass = function(className)
			{
				for (var i=0; i<this.Container.length; i++)
				{
					if(this.Container[i].classList.contains(className))
					this.Container[i].classList.remove(className);
				}
				return this;
			}

			RT.Core.toggleClass = function(className)
			{
				for (var i=0; i<this.Container.length; i++)
				{
					
					this.Container[i].classList.toggle(className);
				}
				return this;
			}


			RT.Core.attr = function(attribute, value)
			{
				if (value!=undefined)
				{
					for (var i=0; i<this.Container.length; i++)
					{
						this.Container[i].setAttribute(attribute, value);
					}
					return this;
				}
				else
				{
					return this.Container[0].getAttribute(attribute);
				}

			}
				
			RT.Core.forEach = function(handler)
			{

				for (var i=0; i<this.Container.length; i++)
					{
						handler(this.Container[i]);
					}

			}
			
	//-------------------------------------------------------//

		RT.setTitle = function(string)
		{
			document.title = string;
			return string;
		}

	//-----Core - main function, launching when all document is loaded.
		RT.core = function(func)
		{
				if (!document.addEventListener('DOMContentLoaded', func, false)){
				if (typeof document.attachEvent!= "undefined") document.attachEvent('DOMContentLoaded', func);}
			return func;
		}

	/*======================================================
	========================================================

	RetarCore.js selector functions
	_.all - all elements satisfying selector;
	_.last - last element satisfying selector;
	_.first - first element satisfying selector;
	_.at - elements, located at given positions.


	*/
	//------SELECTOR FUNCTIONS---------------//
	//========================================================
	//========================================================
		RT.all = function(selector)
		{
			var Temp = new Core();
			
			Temp.Container = document.querySelectorAll(selector);
			Temp.length = Temp.Container.length;
			return Temp;
		}

		RT.$ = RT.all;

		RT.last = function(selector)
		{
			var Result = new Core();
			

			Temp = document.querySelectorAll(selector);
			Result.Container = new Array();
			Result.Container[0]=Temp[Temp.length-1];
			Result.Container.length=1;	
			Result.length = Result.Container.length;
			return Result;
		}	
		RT.first = function(selector)
		{
			var Result = new Core();
			Result = RT.Core;

			Result.Container=new Array();
			Result.Container[0] = document.querySelector(selector);
			Result.Container.length=1;	
			Result.length = Result.Container.length;
			return Result;
		}	


		RT.at = function(selector)
		{

			var Result = new Core();
			

			len=arguments.length;
			Result.Container = new Array();
			Temps = document.querySelectorAll(selector);
			var j=0;
			
			if (arguments[1].length){
				for (var i=0; i<arguments[1].length; i++)
				{
					num=arguments[1][i];
					num = Number(num);
					num = num || 0;
					num = Math.floor(num);	
			
					if (num>Temps.length-1) num=Temps.length-1;
					if (num<0) num=0;

					Temp = Temps[num];
			
					if (Temp)
						{
							Result.Container[j] = Temp;
							j++;
						}
				}

				Result.Container.length=j;
				Result.length = Result.Container.length;
				return Result;
			}


			for (var i=1; i<len; i++)
			{
			num=arguments[i];
			num = Number(num);
			num = num || 0;
			num = Math.floor(num);	
			
			if (num>Temps.length-1) num=Temps.length-1;
			if (num<0) num=0;

			Temp = Temps[num];
			
			if (Temp)
				{
				Result.Container[j] = Temp;
				j++;
				}
			}

			Result.Container.length=j;
			Result.length = Result.Container.length;
			return Result;
		}
		
		RT.RT = function(obj)
		{	List = new Array();
			
			if (obj.length != undefined ){
			List[0] = obj;}
			
			if (obj.length){
				for (var i=0; i<obj.length; i++)
				{	List[i] = obj[i]; }
			}
			var Result = new Core(List);

			return Result;
		}

		RT.Core.find = function(selector){

			var T = this;
			var Contain = new Array();			

			for (var i=0; i<T.length; i++)
			{
				Contain = Contain.concat(T.Container[i].querySelectorAll(selector)[0]);

			}
				
			var Result = RT.RT(Contain);
			return Result;

		}
	//========================================================
	//========================================================
	//========================================================//

	//============EVENT METHODS=================================
	//============================================================

	//=======CLICK
	RT.Core.click = function(func)
			{
				if (!func){for (var i=0; i< this.Container.length; i++)	{ this.Container[i].click(); } }
					 
			
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onclick=func;
					
				}
				return  this;
			}

	//===========DBLCLICK
	RT.Core.dblclick = function(func)
			{
				if (!func){for (var i=0; i< this.Container.length; i++)	{ this.Container[i].dblclick(); } }
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].ondblclick=func;
				}
				return this;
			}

	//============MOUSEOVER
	RT.Core.mouseover = function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onmouseover=func;
				}
				return  this;
			}
	//==========MOUSEOUT
	RT.Core.mouseout= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onmouseout=func;
				}
				return  this;
			}


	//======MOUSEMOVE
	RT.Core.mousemove= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onmousemove=func;
				}
				return  this;
			}

	//========MOUSE
	RT.Core.mouse = function(funcOn, funcOut)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onmouseover=funcOn;
					 this.Container[i].onmouseout=funcOut;
					
				}
				return  this;
			}

	//======BLUR
	RT.Core.blur= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onblur=func;
				}
				return  this;
			}

	//======ERROR
	RT.Core.error= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onerror=func;
				}
				return  this;
			}

	//======BLUR
	RT.Core.focus= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onfocus=func;
				}
				return  this;
			}

	//======KEYDOWN
	RT.Core.keydown= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onkeydown=func;
				}
				return  this;
			}

	//======KEYPRESS
	RT.Core.keypress= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onkeypress=func;
				}
				return  this;
			}


	//======KEYUP
	RT.Core.keyup= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onkeyup=func;
				}
				return  this;
			}

	//======KEY
	RT.Core.key= function(func1, func2)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onkeydown=func1;
					 this.Container[i].onkeyup = func2;
				}
				return  this;
			}

	//======SELECT
	RT.Core.select= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onselect=func;
				}
				return  this;
			}

	//======MOUSEDOWN
	RT.Core.mousedown= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onmousedown=func;
				}
				return  this;
			}

	//======MOUSEUP
	RT.Core.mouseup= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onmouseup=func;
				}
				return  this;
			}
	//=======MOUSECLICK
	RT.Core.mouseclick= function(func1, func2)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onmousedown=func1;
					 this.Container[i].onmouseup = func2;
				}
				return  this;
			}

	//======RESET
	RT.Core.reset= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onreset=func;
				}
				return  this;
			}

	//======SUBMIT
	RT.Core.submit= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onsubmit=func;
				}
				return  this;
			}
		//======CHANGE
	RT.Core.change= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onchange=func;
				}
				return  this;
			}

	RT.Core.resize= function(func)
			{
				for (var i=0; i< this.Container.length; i++)
				{
					 this.Container[i].onresize=func;
				}
				return  this;
			}


	/*==========================================================
	============================================================
	============================================================*/
	//===============STYLES===============//

	RT.Core.color = function(val)
		{
			if (val)
			for (var i=0; i<this.Container.length; i++)
				{
					this.Container[i].style.color=val;
				}
			else
			{
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("color");
			}
			return this;
		}
	//======================MARGIN
	RT.Core.marginTop = function(val)
		{
			if (val)
			for (var i=0; i<this.Container.length; i++)
				{
					this.Container[i].style.marginTop=val;
				}
			else
			{
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("margin-top");;
			}
			return this;
		}

	RT.Core.marginBottom = function(val)
		{
			if (val)
			for (var i=0; i<this.Container.length; i++)
				{
					this.Container[i].style.marginBottom=val;
				}
			else
			{
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("margin-bottom");
			}
			return this;
		}

	RT.Core.marginLeft = function(val)
		{
			if (val)
			for (var i=0; i<this.Container.length; i++)
				{
					this.Container[i].style.marginLeft=val;
				}
			else
			{
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("margin-left");
			}
			return this;
		}
	RT.Core.marginRight = function(val)
		{
			if (val)
			for (var i=0; i<this.Container.length; i++)
				{
					this.Container[i].style.marginRight=val;
				}
			else
			{
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("margin-right");
			}
			return this;
		}
	//=================PADDING
	RT.Core.paddingRight = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.paddingRight=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("padding-right"); }
			return this;	
		}

	RT.Core.paddingLeft = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.paddingLeft=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("padding-left"); }
			return this;	
		}

	RT.Core.paddingTop = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.paddingTop=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("padding-top"); }
			return this;	
		}
	RT.Core.paddingBottom = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.paddingBottom=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("padding-bottom"); }
			return this;	
		}


	//============FONT 
	RT.Core.fontSize = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.fontSize=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("font-size"); }
			return this;	
		}

	RT.Core.fontWeight = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.fontWeight=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("font-weight"); }
			return this;	
		}

	RT.Core.fontVariant = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.fontVariant=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("font-variant"); }
			return this;	
		}

	RT.Core.fontFamily = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.fontFamily=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("font-family"); }
			return this;	
		}

	RT.Core.fontStretch = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.fontStretch=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("font-stretch"); }
			return this;	
		}

	RT.Core.fontStyle = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.fontStyle=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("font-style"); }
			return this;	
		}
	//============DIMENSIONS===================
	RT.Core.minWidth = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.minWidth=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("min-width"); }
			return this;	
		}

	RT.Core.maxWidth = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.maxWidth=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("max-width"); }
			return this;	
		}
	RT.Core.width = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.width=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("width"); }
			return this;	
		}
	RT.Core.minHeight= function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.minHeight=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("min-height"); }
			return this;	
		}

	RT.Core.maxHeight = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.maxHeight=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("max-height"); }
			return this;	
		}
	RT.Core.height = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.height=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("height"); }
			return this;	
		}
	//====================TEXT DECORATION
	RT.Core.lineHeight = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.lineHeight=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("line-height"); }
			return this;	
		}

	RT.Core.textDecoration = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.textDecoration=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("text-decoration"); }
			return this;	
		}

	RT.Core.textAlign = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.textAlign=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("text-align"); }
			return this;	
		}

	RT.Core.textShadow = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.textShadow=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("text-shadow"); }
			return this;	
		}

	RT.Core.textTransform = function(val)	{
			if (val)
				for (var i=0; i<this.Container.length; i++)	
					{ 
						this.Container[i].style.textTransform=val; 
					}
			else
			{ 
				return window.getComputedStyle(this.Container[0], null).getPropertyValue("text-transform"); }
			return this;	
		}



	RT.Core.style = function(attr, val)
		{
			

			if (typeof attr === "object")
			{	
				
				for (var i=0; i<this.Container.length; i++)
				{
					for (var item in attr)
					{
					
					this.Container[i].style.cssText+=item+": "+attr[item]+";";
					}
				}
				return this;
			}

			
			if (val)
			for (var i=0; i<this.Container.length; i++)
				{
			
					this.Container[i].style.cssText+=attr+": "+val+";";
				}

			else
			{			
				return window.getComputedStyle(this.Container[0], null).getPropertyValue(attr);
			}
			return this;
		}


	RT.Core.getObjStyle = function()
	{
		var Result = new Object()
		Result = {
			marginTop: this.marginTop(),
			marginBottom: this.marginBottom(),
			marginLeft: this.marginLeft(),
			marginRight: this.marginRight(),
			width: this.width(),
			height: this.height()

		}

		return Result;
	}

	RT.Core.getLinearSizes = function()
	{
		var Res = new Array();
		for (var i=0; i<this.Container.length; i++)
		{
			var Result = new Object();
			Result.width = parseFloat(window.getComputedStyle(this.Container[i], null).getPropertyValue("width").match("^[0-9]+.?[0-9]*"));

			Result.height = parseFloat(window.getComputedStyle(this.Container[i], null).getPropertyValue("height").match("^[0-9]+.?[0-9]*"));

			Result.aspectRatio = Result.width/Result.height;
			Res[i]= Result;
		}
		return Res;
		
	}
	RT.Core.clearStyle = function(attr)
		{
			if (attr)
			{
				this.style(attr, 'initial');			
			}
			else
			{
				for (var i=0; i<this.Container.length; i++)
				{
			
					this.Container[i].style.cssText="";
				}
			}
			return this;

		}
//==============================================================
//================================================================
//================================================================
//========================AJAX====================================
	RT.Core.load = function(path, method, data, callback)
	{
		
		
		if (method==undefined) method='GET';
		if ((method=='get')||(method=='GET')||(method=='Get'))
			{	method='GET'} else 
			if ((method=='post')||(method=='POST')||(method=='Post')){ method='POST';} else method='GET';
		
		var params = "";
		if ((data!=undefined)&&(data!=null))
		{
			if (typeof data !== "object") params="param="+encodeURIComponent(data); else
			{
				for (item in data) params+=encodeURIComponent(item)+"="+encodeURIComponent(data[item])+"&";
			}
		}	
		
		//alert(typeof data);
		var Request = new XMLHttpRequest();
		var Tmp = this;

		callHandle = function(string){ if (callback) callback(string); }
		
		Request.onreadystatechange = function()
		{
			if (Request.readyState == 4) {
    				 if(Request.status == 200) {
      			 Tmp.HTML(Request.responseText);
					callHandle(Request.responseText);

      		   }
			  }
		}
		
		if (method=="GET") {
			Request.open("GET", path+"?"+params, true); 
			Request.send(null);
		} 
			else
		{
			Request.open("POST", path, true);
			Request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');			 
			Request.send(params)
		}

		return this;
		
	}
	
	


	RT.Core.indicatedLoad = function(path, method, data, image, className)
	{
		var Tmp1 = this;
		Tmp1.HTML("<img src='"+image+"' class='"+className+"'> </img>");
		Tmp1.load(path, method, data);

		return this;
		
	}
	

	RT.Core.fileUpload = function(formName, path, data,callback)
	{
		
		var form = new Core();
		form = _.first("[name='"+formName+"']");
		var formData = form.Container[0].files[0];
		var FD = new FormData()
		FD.append( 'file', formData );

		var params = "";
		callHandle = function(string){ if (callback) callback(string); };
		if ((data!=undefined)&&(data!=null))
		{
			if (typeof data !== "object") params="param="+encodeURIComponent(data); else
			{
				for (item in data) FD.append(encodeURIComponent(item), encodeURIComponent(data[item]));
			}
		}

		
		var Request= new XMLHttpRequest();
		var Temp2=this;

		Request.onreadystatechange = function()
		{
			if (Request.readyState == 4) {
    				 if(Request.status == 200) {
      			 	Temp2.HTML(Request.responseText);
					callHandle(Request.responseText);
      		   }
			  }
		}
		Request.open("POST", path);
		Request.send(FD);

		return this;
	}

	RT.fixXHR = function(){
	var xmlhttp;
  try {
	   xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		  } catch (e) {
	    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
	return xmlhttp;
	}

	
	RT.loadJSONIE = function(filename, callback){

		
		try{
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(err){
			try{ xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");} catch (e) {xmlhttp = new XMLHttpRequest();}
		}

		//alert(typeof xmlhttp);

		if (typeof XMLHttpRequest!='undefined'){
			xmlhttp = new XMLHttpRequest();
		}

		xmlhttp.onreadystatechange = function(){
			//alert(xmlhttp.readyState);
			if (xmlhttp.readyState == 4){
				//alert(xmlhttp.status);
				if(xmlhttp.status == 200) {
					//alert(xmlhttp.responseText);
					callback(JSON.parse(xmlhttp.responseText));
					}
			}

		}
		xmlhttp.open("GET", filename);
		xmlhttp.send("1");

		
	}



	
//=============================================================================
//==========================DOM================================================
//=============================================================================

	RT.new = function(string, innerData, attributes, amount)
	{
		var Temp = new Core();
		if (!amount) amount=1;

		if (amount)
		{
			for (var i=0; i<amount; i++)
			{
				if (string)
				var Element = document.createElement(string); else
				var Element = document.createElement('div');

				if (innerData) 
				{
					if (typeof innerData == 'Core')
					Element.innerHTML=innerData.HTML();

					if (typeof innerData == 'string')
					Element.innerHTML=innerData;
		
				}

				if (attributes)
				{
					for (var name in attributes)
					{
						Element.setAttribute(name, attributes[name])

					}
				}


				Temp.Container[i]=Element;
			}

		}
		return Temp;

	}


	RT.Core.putAfter = function(Elements)
	{
		
		for (var i=0; i<Elements.Container.length; i++)
		{
			var Temp = new Array();
			
			for (var j=0; j<this.Container.length; j++) 
			{
				Temp[j] = this.Container[j].cloneNode(true);
				
			}
			
			for (var j=0; j<this.Container.length; j++) 
			{
				Elements.Container[i].outerHTML+=Temp[j].outerHTML;
				
				
			}		
			
		}	

	return this;

	}

	RT.Core.insertAfter= RT.Core.putAfter;
//--------------------------------------------------	
	RT.Core.putBefore = function(Elements)
	{
		
		for (var i=0; i<Elements.Container.length; i++)
		{
			var Temp = new Array();
			
			for (var j=0; j<this.Container.length; j++) 
			{
				Temp[j] = this.Container[j].cloneNode(true);
				
			}
			
			for (var j=0; j<this.Container.length; j++) 
			{
				Elements.Container[i].insertBefore(Temp[j]);
				
				
			}		
			
		}	

	return this;

	}

	RT.Core.insertBefore = RT.Core.putBefore;
//-----------------------------------------
	RT.Core.append= function(Elements)
	{
		
		for (var i=0; i<Elements.Container.length; i++)
		{
			var Temp = new Array();
			
			for (var j=0; j<this.Container.length; j++) 
			{
				Temp[j] = this.Container[j].cloneNode(true);
				
			}
			
			for (var j=0; j<this.Container.length; j++) 
			{
				Elements.Container[i].appendChild(Temp[j]);
				
			}		
		}	

	return this;

	}


//-----------------------------------------------------
	//-----------------------------------------
	RT.Core.prepend= function(Elements)
	{
		
		for (var i=0; i<Elements.Container.length; i++)
		{
			var Temp = new Array();
			
			for (var j=0; j<this.Container.length; j++) 
			{
				Temp[j] = this.Container[j].cloneNode(true);
				
			}
			
			for (var j=0; j<this.Container.length; j++) 
			{
				var S=Elements.Container[i].innerHTML;
				Elements.Container[i].innerHTML=Temp[j].innerHTML+S;
				
			}		
		}	

	return this;

	}

	
	RT.Core.replace= function(Elements)
	{
		var Insertion = this.HTML();

			for (var i=0; i<Elements.Container.length; i++) 
			{
				
				//Elements.Container[i].previousSibling.outerHTML+=Insertion;	

				var node = 	Elements.Container[i];
				node.parentNode.removeChild(node);		
			}	
		
	return this;

	}

	RT.Core.remove = function()
	{
		for (var i=0; i<this.Container.length; i++) 
			{
				var node = 	this.Container[i];
				node.parentNode.removeChild(node);		
			}
		
		return null;

	}
//-----------------------------------------------------
//-----------------------------------------------------
//-----------------------------------------------------
//-----------------------------------------------------

//---------ANIMATION FUNCTIONS-------------------------

	RecursiveTimeout10 = function(currentTime, limitTime, handler, coreObject)
		{
			currentTime+=10;
			handler(coreObject, currentTime, limitTime);
			
			if (limitTime>currentTime) 
			window.setTimeout(RecursiveTimeout10(currentTime, limitTime, handler, coreObject), 10);
			
		}
	/*
	RecursiveTimeout10(0,value, 
			function(core, time, val){
			 	core.style({"opacity": (val-time*10)/val});
				if (time%2500==0) console.log(time);
			}, this);

	*/

	RT.Core.hide = function(value)
	{
		if (!value) {this.style({"display": "none"}); return this}	
		var i=0; 
		var tempCore = this;

		set = function(i)
		{
			tempCore.style('opacity', (value-i)/value);
			if (i>=value-10) {tempCore.hide(); tempCore.style('opacity', 'initial');}
		}

		for (var i=0; i<value; i+=10)
		{
			window.setTimeout("set("+i+")", i)

		}		
		return this;
	}
	
	
	RT.Core.show = function(value)
	{
		if (!value) {this.clearStyle("display"); this.style('visibility', 'visible'); return this}	
		var tempCore = this;
		
		this.style('opacity', 0);
		this.style('visibility', 'hidden');
		this.style('display', 'initial');

		set = function(i)
		{
			tempCore.style('opacity', (i)/value);
			if (i>value/10) tempCore.clearStyle('visibility');
			if (i>=value-10) tempCore.clearStyle('opacity');
		}
		for (var i=0; i<value; i+=10)
		{
			window.setTimeout("set("+i+")", i)

		}
		
		return this;
	}

	RT.Core.toggle = function(val){
	
		if (this.style("display") == "none") {this.show( val)} else {this.hide(val)};


	}
//=========================================
//=========================================
//=========================================
//=================ROUTER==================

		RT.Core.setRouter = function(id, path)
		{
			var Temp = this;
			
			_.all("a[href='#"+id+"']").click(function(){Temp.load(path)});
			
		}

		RT.Core.route = function(locales, router)
		{			
			for (item in locales)
			{
				this.setRouter(item, locales[item]);
				
			}

			var current = location.hash;
			current = current.split("#")[1];
			if (locales[current]) this.load(locales[current]);

		}

//========================================\\
//==============ENVIRONMENT===============\\
//===============VARIABLES================\\

	window.setInterval("ENV()",100);
	ENV = function()
	{
	
		for (item in RT.Environment)
		{
			_.all("[core-var='"+item+"']").HTML(RT.Environment[item]);
		}

		var handler = function(event){ 
				var elem = event.target || event.srcElement; 
				RT.Environment[_.RT([elem]).attr("core-controller")] = _.RT([elem]).value() ;

				};

		_.all("[core-controller]").keyup(handler).keydown(handler).change(handler).blur(handler).focus(handler);
		
	}

	
	retarcore = RT;
	_=RT;