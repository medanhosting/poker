<?php

	require "config";
	
	if (isset($_GET["id"])){
		require_once "../lib/sql_class.php";	
		$sql = new SQLConnection();
		$users = $sql->getAssocArray("select * from cata_users where id=".$_GET["id"]);
		$users = $users[0];
		
		$s1 = $users["role"]==1 ? "selected='selected'" : "";
		$s2 = $users["role"]==2 ? "selected='selected'" : "";		
		$s3 = $users["role"]==3 ? "selected='selected'" : "";
		
		$urole = $users["role"];
	}
	
	if($role==3){
		$s1.=" disabled";
		$s2.=" disabled";
		
	}
	if($role==2){
		$s1.=' disabled';
	}
?>
					<article>
						<label class='user<?=$urole?>'>
						
							<input type='text' id='user-login' value='<?php echo $users["login"]; ?>' autocomplete='off'/>
						</label>
					
						<input type="button" id="remove" class="inactive" value="Удалить">
					
					</article>
					
					<fieldset>
						<label>
							Старый пароль
							<input type='password' value='' id='user-old-password' autocomplete='off'/>
						</label>
					
						<label>
							Новый пароль
							<input type='text' value='' id='user-new-password' autocomplete='off'/>
						</label> 
					</fieldset>
					
					
					<input type='hidden' id='user-id' value='<?php echo $users["id"]; ?>'/>
					
					<fieldset>
						<label>
						
							<select id='user-role'>
								<option value='1' <?php echo $s1; ?> >Администратор</option>
								<option value='2' <?php echo $s2; ?> >Модератор</option>
								<option value='3' <?php echo $s3; ?> >Гость</option>
							</select>
						</label>
					
						<label>
							Информация о пользователе
							<textarea id='user-info'><?php echo $users["info"]; ?></textarea>
						</label>
					
						<input type='button' value='Сохранить изменения' id='user-save'/>
					</fieldset>
					
					