
_.UI = {

	//@horizontalSlider: Object o
	//For manual info call _.UI.manual("horizontalSlider") in console;
	horizontalSlider:{
		
		create: function(s){
			var w = s.wrapper.size().width;
			s.wl = w/s.visible;
			s.ul.children().width(s.wl+"px");
			s.amo = s.ul.children().length;
			s.ul.width(s.amo*s.wl*1.05+"px").transition(s.spin+"s");
			s.current=0;
			s.max=s.amo - s.visible;
		
			s.toggle = function(i){
				if(!i) i=1;
				s.current+=i;
				if(s.current>s.max) s.current=0;
				else if(s.current<0) s.current = s.max;
			
				s.ul.marginLeft(-s.current*s.wl+"px");
			}
		
			s.leftToggler.click(function(e){
				e.preventDefault();
				if(s.delay>0){
					clearInterval(s.interval);
					s.interval = setInterval(function(){s.toggle(1);}, s.delay*1000);
				}
				s.toggle(-1);
			});
			s.rightToggler.click(function(e){
				e.preventDefault();
				if(s.delay>0){
					clearInterval(s.interval);
					s.interval = setInterval(function(){s.toggle(1);}, s.delay*1000);
				}
				s.toggle(1);
			});
			
			if(s.delay>0)
			s.interval = setInterval(function(){
				s.toggle(1);
			}, s.delay*1000);
		},
		
		manual: function(){
		
			var s = 'Horizontal Slider usage:\nvar settings = {\n 	visible: 5	\/\/Amount of lis, visible at a time\n	,delay: 3	\/\/Amount of secs delay between toggles. Put 0 for stopped toggling.\n	,spin: 0.3	\/\/Amount of secs animation length\n	,wrapper: _.$("article.clients div.clients")	\/\/Core, containing wrapper element. Required to calculate widths.\n	,ul: _.$("article.clients ul") 	\/\/Core, containing directly slider elements\n	,leftToggler: _.$("#clientsLeft")	\/\/Core, containing left button element\n	,rightToggler:	_.$("#clientsRight") 	\/\/Core, containing left button element\n};\n _.UI.horizontalSlider.create(settings)	\/\/Initializing slider';
			console.log(s);
		}
	
	}
	
	
	,Pagination: {
	
		create: function(p){
			p.offset=0;
			p.pages = Math.ceil(p.container.children().length/p.step);
			
			p.nav.HTML("");
			
			for(i=0; i<p.pages; i++){
				p.nav.appendHTML("<li data-page='"+i+"'> <a href='#'> "+(i+1)+" </a> </li>");
			}
			_.$(p.nav.children()[0]).find("a").addClass("active");
			
			p.openPage = function(k){
				k=parseInt(k);
				p.container.children().display("none");
				_.RT(p.container.children().slice(p.step*k, p.step*(k+1))).display(p.display ? p.display : "block");
				p.nav.find('a').removeClass("active");
				_.$(p.nav.children()[k]).find("a").addClass("active");
				
				
			}
			
			p.nav.children().click(function(e){
				if(p.click) p.click(e);
				p.openPage(_.$(this).attr("data-page"));
				
			})
			p.openPage(0);	
		}
		
		,manual: function(){
			s='';
			console.log(s);
		}
	}
	
	
	,DoubleRangeBar:{
		create: function(s){
			var container = _.$("#"+s.replace);
			var min = s.min;
			var max = s.max;
			
			
			_.UI.DoubleRangeBar.addInstance(s.replace,{
				getMin: function(){
					return s.minVal;
				}
				
				,getMax: function(){
					return s.maxVal
				}
			});
			
			var HTML = "<div id='"+s.replace+"'>"
				+"<span class='drb_from_val'> "+min+"</span>"
				+"<div class='drb_empty'>"
				+"	<p class='drb_from'> </p>"
				+"	<p class='drb_line'> </p>"
				+"	<p class='drb_after'> </p>"
				+"</div>"
				+"<span class='drb_to_val'> "+max+"</span>"
			+"</div>";
			
			container[0].outerHTML = HTML;
			s.container = _.$("#"+s.replace);
			s.container.style({"width":"100%"});
			s.container.find("span").style("display","inline-block").style({"vertical-align":"middle","width":"2em","text-align":"center"});
			s.container.find(".drb_empty").style({"display":"inline-block","vertical-align":"middle","width":"calc(100% - 4em)","height":"6px","background-color":"#ccc"});
			s.container.find(".drb_line").style({"background-color":"#fff","position":"relative","height":"6px","display":"inline-block","width": "calc(100% - 7px)","vertical-align":"top","margin-right":"-14px"});
			s.container.find(".drb_from, .drb_after").style({"display": "inline-block","float":"left","width":"14px","margin-left":"-3px","margin-right":"-4px","background-color":"#006E00","height":"14px","position":"relative","top":"-4px","z-index":"4","border-radius":"10px","cursor":"pointer"});
			s.container.find(".drb_after").style("float","right");
			
			s.left = 0;
			s.right = 0;
			s.maxVal=s.max;
			s.minVal =s.min;
			s.container.find(".drb_to_val").HTML(("valFunc" in s ) ? s.valFunc(s.maxVal) : s.maxVal+"");
			s.container.find(".drb_from_val").HTML(("valFunc" in s ) ? s.valFunc(s.minVal) : s.minVal+"");
			
			dragAfter = function(e){
				//console.log(e.pageX);
				
				var x = -e.pageX;
				if(x==0) return;
				
				
				var parentX = getOffsetSum(this.parentNode).left;
				var w = _.$(this).parent().size().width;
				w = (parentX + w)+x;
				if(w<0) return;
				if (w>_.$(this).parent().size().width) return;
				if(w>(_.$(this).parent().size().width-s.left-10)) w = _.$(this).parent().size().width-s.left-10;
				
				s.container.find(".drb_line").style("width",(_.$(this).parent().size().width-w-s.left)+"px");
				
				
				_.$(this).style("right",(w-3)+"px")
				s.right = w;
				
				var pw = _.$(this).parent().size().width;
				s.maxVal = (s.max-s.min)*(pw-w)/pw+min;
				s.container.find(".drb_to_val").HTML(("valFunc" in s ) ? s.valFunc(s.maxVal) : s.maxVal+"");
				
			};
			
			s.container.find(".drb_from,.drb_after").attr("draggable",'true');
			s.container.find(".drb_after").event("drag",dragAfter).event("dragstart",dragAfter)//.event("")
			
			s.container.find(".drb_from").event("drag",function(e){
				e.preventDefault();
				var x = e.pageX;
				if(x==0) return;
				
				var parentX = getOffsetSum(this.parentNode).left;
				var w = _.$(this).parent().size().width;
				
				w = x-parentX;
				if(w<0) return;
				if (w>_.$(this).parent().size().width) return;
				if(w>(_.$(this).parent().size().width-s.right-10)) w= _.$(this).parent().size().width-s.right-10;
				_.$(this).style("left",w+"px");
				
				s.container.find(".drb_line").width((_.$(this).parent().size().width-s.right-w-3)+"px");
				s.container.find(".drb_line").style("left",(w-3)+"px");
				s.left = w;
				
				var pw = _.$(this).parent().size().width;
				s.minVal = (s.max-s.min)*w/pw+min;
				s.container.find(".drb_from_val").HTML(("valFunc" in s ) ? s.valFunc(s.minVal) : s.minVal+"");
				
			})
			
			function getOffsetSum(elem) {
    			var top=0, left=0
    			while(elem) {
        			top = top + parseFloat(elem.offsetTop)
        			left = left + parseFloat(elem.offsetLeft)
        			elem = elem.offsetParent        
   			 }    
    			return {top: Math.round(top), left: Math.round(left)}
			}
			
			
			
		}
		
		,instances: []
		
		,addInstance: function(i,o){
			_.UI.DoubleRangeBar.instances[i]=o;
		}
	
	}
	
	
	
	,manual: function(s){
		return _.UI[s].manual();
	}

}