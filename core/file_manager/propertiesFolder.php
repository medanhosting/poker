<?php
	$target = $_SERVER["DOCUMENT_ROOT"].$_POST["name"];
	echo "<h4>".basename($target)."</h4>";
	echo "<h5>Папка с файлами</h5>";
	
	
	function sizeF($dir, $size){
		$handle = opendir($dir);
		while($file = readdir($handle)){
		
			if (is_file($dir."/".$file)){
				$size+=(float)(filesize($dir."/".$file));
			}else{
				if (($file!='.')&&($file!="..")){
					$size+=(float)(sizeF($dir."/".$file,0));
				}
			}
		}
		
		closedir($handle);
		return $size;
	}
	
		
	function amountFolders($dir, $amo){
		$handle = opendir($dir);
		while($file = readdir($handle)){
		
			if (is_file($dir."/".$file)){
				
			}else{
				if (($file!='.')&&($file!="..")){
					$amo++;
					#echo $dir."/".$file."<br/>";
					$amo = (amountFolders($dir."/".$file,$amo));
				}
			}
		}		
		closedir($handle);
		return $amo;
	}
	
	function amountFiles($dir, $amo){
		$handle = opendir($dir);
		while($file = readdir($handle)){
		
			if (is_file($dir."/".$file)){
				$amo++;
			}else{
				if (($file!='.')&&($file!="..")){
					
					
					$amo += (amountFiles($dir."/".$file,0));
				}
			}
		}		
		closedir($handle);
		return $amo;
	}
	$size = sizeF($target,0);
	$postfix = " байт";
	
	if($size>1024){
		$size = $size/1024;
		$postfix = "Кбайт";
		
		if($size>1024){
			$size = $size/1024;
			$postfix = "Мбайт";
		}
	}
	$size = round($size,3);
	echo "<h5>Общий размер: $size $postfix</h5>";
	echo "<h5>Папок: ".amountFolders($target,0)."</h5>";
	echo "<h5>Файлов: ".amountFiles($target,0)."</h5>";
	echo "<input type='button' class='close' value='Закрыть'/>";
?>