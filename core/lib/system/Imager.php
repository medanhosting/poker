<?php
	
require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";
require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/utils/Utils.php";

class Imager{
	
	
	const CATALOG_NAME = "cata_images";
	
	public static function getFolders(){
		$catalog = new RCatalog(self::CATALOG_NAME);
		$folders = $catalog->getAllByQuery(0," 1 order by id ASC");
		
		return $folders;
	}
	
	public static function removeFolder($id){
		global $APP_NAME;
		
		$catalog = new RCatalog(self::CATALOG_NAME);
		$result = $catalog->remove($id, 0);
		if(!mysqli_error()) Logger::addReport("$APP_NAME > Imager.php",Logger::STATUS_INFO,"Удалена папка под номером $id из хранилища изображений.");
		else Logger::addReport("$APP_NAME > Imager.php",Logger::STATUS_ERROR,"Не удалось удалить папку с номером $id из хранилища изображений! ".mysqli_error());
		
		return $result;
	}
	
	public static function removeImage($id){
		global $APP_NAME;
		
		$url = RImages::getURL($id);
		$catalog = new RCatalog(self::CATALOG_NAME);
	
			if(unlink($_SERVER['DOCUMENT_ROOT'].$url))
				Logger::addReport("$APP_NAME > Imager.php",Logger::STATUS_INFO,"Удалено изображение $url из файловой системы.");		
			else	
				Logger::addReport("$APP_NAME > Imager.php",Logger::STATUS_WARN,"Не удалось удалить изображение $url из файловой системы!");		
		
		$catalog->remove($id,1);
		if(!mysqli_error()) Logger::addReport("$APP_NAME > Imager.php",Logger::STATUS_INFO,"Удалено изображение с номером $id из хранилища.");
		else Logger::addReport("$APP_NAME > Imager.php",Logger::STATUS_ERROR,"Не удалось удалить изображение с номером $id из хранилища! ".mysqli_error());
		
	}
	
	public static function addFolder($name){
		global $APP_NAME;
		
		$catalog = new RCatalog(self::CATALOG_NAME);
		$res = $catalog->getAllByQuery(0, "name='$name'");	
			
		if(count($res)){
			Logger::addReport("$APP_NAME > Imager.php",Logger::STATUS_ERROR,"Не удалось создать папку $name  в хранилище изображений! Папка уже существует.");		
			return 0;
		} 
		$result = $catalog->addItem(array($name));
		
		if($result){
			$res = $catalog->getAllByQuery(0, "name='$name'");
			$res = $res[0]['id'];
			Logger::addReport("$APP_NAME > Imager.php",Logger::STATUS_INFO,"Создана папка $name в хранилище изображений под номером $res.");
		}
		return $res;
	}
	
	public static function getImages($id){
		return RImages::getImages($id); 
	}
	
	public static function uploadImage($file, $folder){
		global $APP_NAME;
		
		Logger::addReport("$APP_NAME > Imager.php",Logger::STATUS_INFO,"Попытка загрузить новое изображение ({$file['name']}) в хранилище изображений.");
		return RImages::addImage($folder, $file);
	}
}