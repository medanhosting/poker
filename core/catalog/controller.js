_.core(function(){


	_.Environment.nest=1;

	_.Environment.cataForm=0;

	_.$("#newCatalog").click(function(){
		_.$(".catas form").style("display","block");
		
	})

	_.$("#hideForm").click(function(){
		_.$(".catas form").style("display","none");
		
	})

	_.$(".cata_list li").click(function(e){
		var t = _.RT([e.target]);
		data = JSON.parse(t.attr("data"));
		data.type=t.attr("id").substr(4);
		data.name = t.text();
		_.$(".cata_info").load("getinfo.php","POST",data, setSchemaHandler);
	})
		
	setSchemaHandler = function(){
		_.$("#schema").click(function(e){
			var t = _.RT([e.target]);
			var data = JSON.parse(t.attr("data"));
			_.$(".cata_info").load("getcatalog.php","POST", data);
		})
			
		_.$("#proceed").click(function(e){
			var t = _.RT([e.target]);
			var data = t.attr("data");
			window.open("catalogEditor/?name="+data);
			//_.$(".cata_info").indicatedLoad("catalogEditor.php","POST",{name: data},"img/loading.gif");
		})
	}
	
	_template = function (n){
		
		s= "<fieldset class='nest"+n+"'>";
		s+='	<label class="maintable_name">';
		s+='		Название таблицы для уровня '+n+':<br/>';
		s+=	'	<span core-var="maintable"></span>_<input type="text" />';
		s+=	'</label>';
		s+= '  <h5> Поля таблицы: </h5>';
		s+=	'<div>	';
		
		s+=	'	<label>';
					
		s+=	'		<input type="text" placeholder="Название поля"/>';
		s+=	'	</label>';
		s+=	'	<label>';
		s+=	'		<select>';
		s+=	'			<option selected value="INT"> INT </option>';
		s+=	'			<option > FLOAT </option>';
		s+=	'			<option> TEXT </option>';
		s+=	'			<option> VARCHAR </option>';
		s+=	'			<option>  DATETIME </option>';
		s+=	'		</select>';
		s+=	'	</label>';
		s+= '  <label title="Размерность поля (0 - размерность не задана)"> ( <input type="number" value="0" min=0 /> )</label>';		
		s+=	'	<input type="button" value="-" class="rem"  level="'+n+'"/>';
		s+=	'</div>	';
	
		s+=	'<input type="button" class="addField" value="+" level="'+n+'"/>';
	
		s+= " </fieldset>";

		return s;
	}

	

	_.$("#nest").change(nestInput);
	function nestInput(e){var el = _.RT([e.target || e.srcElement]); nest = el.value(); nestChange(nest);}
	
	function nestChange(nest){
		
		if (nest>_.Environment.nest) {
			_.$(".catas form").appendHTML(_template(nest));
			_.$("#nest").value(nest);
		}else{
			_.last(".catas form fieldset").remove();
		}
		_.Environment.nest = nest;

		_.$("#nest").change(nestInput);
		_.$("fieldset input.rem").click(remField);
		_.$("fieldset input.addField").click(addField);
		_.$("#check").click(check);
		_.$("#create").click(create);
	}

	remField = function(e){
		var lvl = e.target.getAttribute("level");
		
		if (_.$(".nest"+lvl+" div").length<2){

			_.$(".nest"+lvl).style("border-color", "red");
			window.setTimeout(function(){_.$(".nest"+lvl).style("border-color", "initial");}, 200);
			return;
		}

		_.RT([e.target.parentNode]).hide(200);
		window.setTimeout(function(){_.RT([e.target.parentNode]).remove()}, 200);
	}

	addField = function(e){
		var lvl = e.target.getAttribute("level");

		s='';
		s+=	'	<label title="Название поля">';
					
		s+=	'		<input type="text" placeholder="Название поля"/>';
		s+=	'	</label>';
		s+=	'	<label title="Тип данных поля">';
		s+=	'		<select>';
		s+=	'			<option selected value="INT"> INT </option>';
		s+=	'			<option > FLOAT </option>';
		s+=	'			<option> TEXT </option>';
		s+=	'			<option> VARCHAR </option>';
		s+=	'			<option>  DATETIME </option>';
		s+=	'		</select>';
		s+=	'	</label>';
		s+= '  <label title="Размерность поля (0 - размерность не задана)"> ( <input type="number" value="0" min=0 /> )</label>';
		s+=	'	<input type="button" value="-" class="rem"  level="'+lvl+'"/>';

		var elem = _.new('div',s);
		elem.insertAfter(_.last(".nest"+lvl+" div"));
		
		

		_.$("fieldset input.rem").click(remField);
		_.$("#check").click(check);
		_.$("#create").click(create);
	}

	_.$("fieldset input.rem").click(remField);
	_.$("fieldset input.addField").click(addField);


	_.$("#check").click(check);

	 function check(){
		
		dump="";
		result = [];
		
		N = _.$(".catas fieldset").length;
		
		for (i=1; i<=N; i++){
			temp={
				tableName: _.Environment.maintable+"_"+_.first("fieldset.nest"+i+" input").value()
			}
			if (_.first("fieldset.nest"+i+" input").value()==""){
				dump+="\nНе задано имя для таблицы уровня "+i;
			}
			M = _.$(".catas fieldset.nest"+i+" div").length;
			for (j=1; j<=M; j++){
				field =  _.$(".catas fieldset.nest"+i+" div:nth-of-type("+j+") input[type='text']").value();
				type = _.$(".catas fieldset.nest"+i+" div:nth-of-type("+j+") select").value();
				dim = _.$(".catas fieldset.nest"+i+" div:nth-of-type("+j+") input[type='number']").value();		
				if (field=="") {dump+="\nНе задано имя "+j+"-го поля в таблице уровня "+i;}

				dim = (dim>0) ? "("+dim+")" : "";
				type+=dim;
				temp[field]=type;

				if (field="") dump+="\nНе задано имя "+j+"-го поля в таблице уровня "+i;
			}
			result.push(temp);
		}
		//alert(JSON.stringify(result));
		
		if (dump!="") {alert(dump);} else return result;
	}


	_.$("#create").click(create);
	function create(){
		data=check();
		if (data){
			_.$(".catas form").indicatedLoad("createCata.php","POST",{data: JSON.stringify(data), name: _.$("#cataName").value()},"img/loading.gif");
		}
	}
})