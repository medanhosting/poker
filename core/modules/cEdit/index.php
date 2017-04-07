
<div class='cEdit_window'>


	
	<link rel='stylesheet' href='/core/modules/cEdit/cEdit.css'/>
	<meta charset='utf-8'/>
	
	<div class='cEdit_editor'>
	
		<div class='cEdit_menu'>
		
			<nav>
				<ul class='buttons'>
					<li class='btn'><a href='#' id='cEdit_undo' title='Отменить'>S</a> </li>
					<li class='btn'><a href='#' id='cEdit_redo' title='Повторить'>S</a> </li>
					
					<li class='separator'> | </li>
					<li class='btn'><a href='#' id='cEdit_bold' title='Жирный'>В</a> </li>
					<li class='btn'><a href='#' id='cEdit_underline' title='Подчеркнутый'>U</a> </li>
					<li class='btn'><a href='#' id='cEdit_italic' title='Курсив'>I</a> </li>
					<li class='btn'><a href='#' id='cEdit_strike' title='Зачеркнутый'>U</a> </li>
					<li class='separator'> | </li>
					<li class='btn fsize'>
						<select id="cEdit_fontsize" title='Задать размер шрифта' class='down'>
							<option value='1'> 10pt </option>
							<option value='2'> 13pt </option>
							<option value='3'> 16pt </option>
							<option value='4'> 18pt </option>
							<option value='5'> 24pt </option>
							<option value='6'> 32pt </option>
							<option value='7'> 48pt </option>
						</select>
					</li>
					<li class='btn font'>
						<div id='cEdit_font' title='Изменить шрифт' class='down'>
							<span class='title'style='font-family: "Times New Roman"'> Times New Roman</span>
							<ul class='drop'>
								<li style='font-family: "Arial"'> Arial</li>
								<li style='font-family: "Calibri"'> Calibri </li>
								<li style='font-family: "Cambria"'> Cambria</li>
								<li style='font-family: "Comic Sans Ms"'> Comic Sans Ms</li>
								<li style='font-family: "Consolas"'> Consolas </li>							
								<li style='font-family: "Open Sans"'> Open Sans </li>
								<li style='font-family: "Verdana"'> Verdana</li>
								<li style='font-family: "Segoe Script"'> Segoe Script</li>								
								<li style='font-family: "Tahoma"'> Tahoma</li>
								<li style='font-family: "Times New Roman"'> Times New Roman</li>
								
							</ul>
						</div>
					</li>
					<li class='separator'> | </li>
					<li class='btn'><a href='#' id='cEdit_link' title='Добавить ссылку'>S</a> </li>
					<li class='btn'><a href='#' id='cEdit_unlink' title='Удалить ссылку'>S</a> </li>
					<li class='btn'><a href='#' id='cEdit_image' title='Добавить изображение'><input type='file' name='cEdit_img' id='cEdit_img'/> S </a> </li>
					<li class='separator'> | </li>
					
					<li class='btn'><a href='#' id='cEdit_indent' title='Добавить отступ'>S</a> </li>
					<li class='btn'><a href='#' id='cEdit_outdent' title='Удалить отступ'>S</a> </li>
					<li class='btn'><a href='#' id='cEdit_alignL' title='По левому краю'>S</a> </li>
					<li class='btn'><a href='#' id='cEdit_alignC' title='По центру'>S</a> </li>
					<li class='btn'><a href='#' id='cEdit_alignR' title='По правому краю'>S</a> </li>
					<li class='separator'> | </li>
					<li class='btn'><a href='#' id='cEdit_ol' title='Добавить нумерованный список'>S</a> </li>
					<li class='btn'><a href='#' id='cEdit_ul' title='Добавить маркированный список'>S</a> </li>
					
					
					
					
					
				</ul>
				
			</nav>
		</div>

		<div class='cEdit_field'>
			<div class='cEdit_fieldFrame'>		
				<pre class='cEdit_pre' id='cEdit' contenteditable='true'> TEST</pre>
			</div>
		</div>
	</div>


</div>

<script> _.cEdit.init(); </script>