<?php
	$nest = $_GET['nest']*1;
	require "primitive.php";
	require "abstract.php";
?>
<div class='levels'>
<fieldset class='save'>
	<label class='type_label'>
					<div class='tabs'>
						<a href='#' class='primitive_tab active' > Примитивные </a>
						<a href='#' class='abstract_tab'> Абстрактные</a>
					</div>
					<ul class='primitive'>
						<?=$primitives?>
					</ul>
					
					<ul class='abstract'>
						<?=$abstracts;?>
					</ul>
				</label>
	<input type='button' id='save' value='Сохранить' />
	<input type='button' id='back' value='Назад к выбору уровней' />
	<div class='st' id='saveStatus'> </div>
</fieldset>


<?php

for($i=0; $i<$nest;$i++){
echo "

	<fieldset class='level' data-level='$i'>
		<h3> Название уровня $i: <input type='text' value='' class='levelName'/></h3>
		<div class='title'>
			<p class='fN'> Название поля (техн.)</p>
			<p class='fT'>Заголовок поля (для людей)</p>
		</div>
		<div class='fields'>
		
		<div class='field'>
			<label> <input type='text' class='fieldName' /></label>
			<label> <input type='text' class='fieldTitle' /></label>
			<div class='type'>
				<input type='button' class='setType' value='INT' data-val='INT' data-set='primitive' />
				
			
			</div>
			<input type='button' class='remField' value='X'/>
		</div>
		
		</div>
		<input type='button' class='addField' value='+' data-level='$i'/>
	</fieldset>

";
}


?>
</div>