<?php
	$image = $_GET['img'];
	$input = $_GET['input'];
	
	$folder = $_GET['folder'];
	
	require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/utils/Utils.php";
	$catalog = new RCatalog("cata_images");
	if(!$folder){
		$folder=$catalog->getParentOf($image, 1);
	}
	
?>

<div class='cImager_field' data-field='<?=$input?>' data-folder='<?=$folder?>' data-image='<?=$image?>'>
	<input type='hidden' id='<?=$input?>' value='<?=$image?>' />
	<?=RImages::getImage($image,"class='cImager_main'")?>
	<div class='cImager_window'>
		<div class='cImager_top'>
			<select>
				
			<?php
				$f = $folder*1;
				$folders =$catalog->getItemsAt(0);
				foreach($folders as $folder){
					
					$selected = $folder['id']==$f ? "selected":"";
					if($folder['id']==$f ) $tap=1;
					echo "<option value='{$folder['id']}' $selected> {$folder['name']} </option>";
				}
				if(!$tap) echo "<option value='0' disabled selected> Выберите папку ... </option>";
			?>
			</select>
			<form enctype='multipart/form-data'>
			<label for='<?=$input?>_file'>
				<span>Загрузить новое</span>
				<input type='file' name='<?=$input?>_file' id='<?=$input?>_file'/>
			</label>
			</form>
		</div>
		
		<div class='cImager_content'>
			<ul> </ul>
		</div>
	</div>
</div>