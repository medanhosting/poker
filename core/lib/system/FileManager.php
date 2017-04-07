<?php
	
require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";
	

class FileManager{

	public static function addFile($dir, $file){
		global $APP_NAME;
		$dirName=$dir;
		
		chdir($_SERVER["DOCUMENT_ROOT"].$dir);
		$dir = opendir($_SERVER["DOCUMENT_ROOT"].$dir);
		
		while($handle = readdir($dir)){
			if (!is_dir($handle)){
				if($handle==$file) {
					Logger::addReport("$APP_NAME > FileManager.php",Logger::STATUS_WARN,"Не удалось создать файл $name в папке $dirName! Файл уже существует.");
					return FALSE;
				}
			}
		}
		
		if(@touch($file)){
			Logger::addReport("$APP_NAME > FileManager.php",Logger::STATUS_INFO,"Создан файл $name в папке $dirName");
			return true;
		}else{
			Logger::addReport("$APP_NAME > FileManager.php",Logger::STATUS_WARN,"Не удалось создать файл $name в папке $dirName! Ошибка функции touch.");
		}
		return false;		
	}
	
	public static function removeFile($dir, $file){
		global $APP_NAME;
		
		chdir($_SERVER["DOCUMENT_ROOT"].$dir);
		if(!is_file($file)){
			Logger::addReport("$APP_NAME > FileManager.php",Logger::STATUS_WARN,"Не удалось удалить файл $file из папки $dir. Файл не существует!");
			return false;
		}
	
		if(@unlink($file)){
			Logger::addReport("$APP_NAME > FileManager.php",Logger::STATUS_INFO,"Удален файл {$file} из папки $dir");
			return true;
		}else{
			Logger::addReport("$APP_NAME > FileManager.php",Logger::STATUS_WARN,"Не удалось удалить файл $file из папки $dir. Ошибка функции unlink.");
			return false;
		}
	}
	

}