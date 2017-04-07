<?php
	require "config";
	chdir($_SERVER["DOCUMENT_ROOT"].$_POST["path"]);
	$ext = explode(".",$_POST["name"]);
	
	if(count($ext)==1) $ext = "Неизвестный тип файла"; else
	switch($ext[1]){
		
		case "php": $ext="Скрипт PHP"; break;
		case "css": $ext="Таблица стилей CSS"; break;
		case "js": $ext="Клиентский скрипт JS"; break;
		case "html": $ext="Веб-страница в формате html"; break;
		case "txt": $ext="Текстовый файл"; break;
		case "zip": $ext="ZIP-архив"; break;
		case "exe": $ext="Исполняемый Windows-файл"; break;
		case "jpg": $ext="Изображение JPEG"; break;
		case "png": $ext="Изображение PNG"; break;
		case "gif": $ext="Изображение GIF"; break;
		case "mp3": $ext="Аудиофайл в формате MP3"; break;
		case "mp4": $ext="Видеофайл формата MP4"; break;
		case "xml": $ext="XML-документ"; break;
		
		default: $ext = "Файл ".$ext;
	}
	echo "<h4> Файл: ".$_POST["name"]."</h4>";
	echo "<h5>$ext</h5>";
	
	$size = filesize($_POST["name"]);
	$prefix = "байт";
	
	if($size > 1024){
		$size = $size / 1024;
		$prefix = "Кбайт";
			if($size > 1024){
				$size = $size / 1024;
				$prefix = "Мбайт";
			}
	}
	$size = round($size,2);	
	echo "<h5>Размер файла: $size $prefix</h5>";
	echo "<h5>Последнее изменение файла: ".date("d-m-Y H:i:s.",filemtime($_POST["name"]))."</h5>";
	echo "<h5>Последний доступ к файлу: ".date("d-m-Y H:i:s.",fileatime($_POST["name"]))."</h5>";
	echo "<input type='button' class='close' value='Закрыть'/>";
?>