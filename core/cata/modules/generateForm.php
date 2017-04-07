
<?php
	$name = $_GET[name];
	#echo $name;
	
	require $_SERVER['DOCUMENT_ROOT']."/core/cata/config.inc";
	$catalog = new RCatalog($name);
	
	$scheme = $catalog->getSchemaJSON();
	$scheme = json_decode ($scheme, true);
	
	#print_r($scheme);
	$i=0;
	
	foreach($scheme as $name => $level){
		$fields = array_keys($level);
		$select = "<select>";
		foreach($fields as $f){
			$select.="<option value='$f'> $f</option>";
		}
		$select.="</select>";
		
		$actionSelect = "<select>
			<option value=1> Открытие редактирования элемента</option>
			<option value=2> Загрузка потомков </option>
			<option value=3> Инициирование обмена </option>
		</select>";
		
		$loadingSelect = "<select>
			<option value=1> Подсписок</option>
			<option value=2> В основную форму </option>
			
		</select>";
		
		
		$listSelect =  "<select id='listSelect'>
			<option value='-1'> Простой элемент списка</option>
			<option value='-2'> Полноразмерная картинка</option>
			
		</select>";
		
		$contentSelect =  "<select id='contentSelect'>
			<option value=1> Изображение галереи </option>
			<option value=2> Позиция</option>
			<option value=3> Позиция Х2</option>
			<option value=4> Позиция Х3</option>
			
		</select>";
		
		$buttonSelect = "<select >
			<option value=1> Удаление элемента </option>
			<option value=2> Редактирование элемента</option>
			<option value=3> Переход по ссылке</option>
			<option value=4> Загрузка потомков</option>
			<option value=4> Инициирование обмена</option>
		</select>
		";
		
		
		$nextButton="<input type='button' class='generateNext' value='Далее к уровню ".($i+1)."'/> ";
		if($catalog->getNest()==$i+1){ $nextButton="<input type='button' value='Генерировать!' id='generate'/>";}
		
		$table =$catalog->getTables(); $table = $table[$i];
		
		echo "
			<fieldset data-level='$i' data-name='{$name}'>
				<div class='title'>
					<h2> Уровень: $i [".$table."]</h2>
					
				</div>
				<div class='column1'>
					<div class='fields'>
						<h3> Отображаемые поля</h3>
						<p class='info'> Выберите поля, которые будут отображаться в списке элементов.</p>
						<div class='displayed'>
							<p>$select <input type='button' value='X' class='remVisibleField'/> </p>
						</div>
						<input type='button' value='+' class='addVisibleField'/>
					</div>
					
					<div class='actions'>
						<h3> Действия</h3>
						<p class='info'> Выберите действия, производимые при нажатии:</p>
						<div class='actionList'>
							<p class='gAction'> <label class='right'> Правой кнопки мыши </label> $actionSelect</p>	
							<p class='gAction'> <label class='left'> Правой кнопки мыши </label> $actionSelect</p>
							
						</div>
					</div>

					<div class='childrenLoad'>
						<h3> Потомки </h3>
						<p class='info'> Выберите, куда будут загружаться потомки элементов данного уровня.</p>
						<label> $loadingSelect </label>
					</div>

				</div>
				
				<div class='column2'>
					<div class='template'>
						<h3> Шаблон элемента</h3>
						<p class='info'> Выберите шаблон, при помощи которого будут отображаться элементы данного уровня </p>
						<div class='templateSelects'>
							$listSelect $contentSelect
						</div>
					</div>
					
					<div class='listButtons'>
						<h3> Кнопки </h3>
						<p class='info'> Если для элементов уровня необходимо ввести дополнительные кнопки, создайте их здесь.</p>
						<div class='listButtons_list'>
						
						</div>
						<input type='button' value='+' class='addListButton'/>
						
						<div class='listButtons_template'>
							
							<div>
								<input class='removeListButton' value='X' type='button'/>
								<p> <input type='button' class='example' data-button='1'/> $buttonSelect</p>
							</div>
						</div>
						
					</div>
					
					$nextButton
				</div>
			</fieldset>
		
		";
		$i++;
	}
	
	$icons = "";
	$p=0;
	$handle = opendir("../icons");
	while ($f = readdir($handle)){
		
		if (is_file("../icons/".$f)){
			
			if($p) $icons.=("|".$f);
			else $icons = $f;
			
			$p++;
		}
	}
	echo "<div id='iconList' style='display: none'> $icons </div>";
?>