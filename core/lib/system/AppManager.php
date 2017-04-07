<?php
require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";

class AppManager{
	
	private static $key="1";
	private static $catalog; 
	
	const CATEGORY_SYSTEM=3;
	const CATEGORY_ADMIN=1;
	const CATEGORY_GENERAL=2;
	const CATEGORY_DEV=4;
	
	private function __autoload($class){
		require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/".$class.".php";
		
	}
	
	private static function buildRequestURL(){
		$version = Core::version();
		return "http://app.retarcorp.com?key=".self::$key."&version=$version";
	}
	
	public static function getRemoteAppTree(){
		$url = self::buildRequestURL();
		$data = file_get_contents($url);
			
		return json_decode($data, true);
		
	}
	
	public static function getRemoteAppList(){
		$tree = self::getRemoteAppTree();
		$d = array_map(function($d){return $d['apps'];}, $tree);
		$data=[];
		foreach($d as $a){
			$data=  array_merge($data, $a);
		}
		return $data;
	}
	
	public static function getRemoteAppInfo($name){
		$apps = self::getRemoteAppList();		
		foreach($apps as $i=>$ap){
			if($ap['name']==$_GET['app']) return $ap;	
		}
		
		return NULL;
	}
	
	public static function installRemoteApp($app){
		Logger::addReport("AppManager.php",Logger::STATUS_INFO,"Попытка установить приложение {$app['name']}");
		$archive = $app['archive'];
		if(strpos($archive, "http")!=0); $app['archive']="http:".$archive;
				
		$icon= $app['icon'];
		if(strpos($icon, "http")!=0); $app['icon']="http:".$icon;
		$archiveLoc = $_SERVER["DOCUMENT_ROOT"]."/core/appmanager/".$app["name"].".zip";
		
		if(!@file_put_contents($archiveLoc, file_get_contents($app["archive"]))){
			Logger::addReport("AppManager.php",Logger::STATUS_ERROR,"Не удалось скачать приложение {$app['name']} с удаленного сервера!");
			throw new Exception("Error: Application data not found on remote server or unable to copy!");			
			return false;
		}
			
			
		$zip = new ZipArchive;
		$zip->open($archiveLoc);
	    $zip->extractTo($_SERVER['DOCUMENT_ROOT']."/core/");
	    $zip->close();

		unlink($archiveLoc);
		
		$catalog = self::catalog();
		file_put_contents($_SERVER['DOCUMENT_ROOT']."/core/img/".$app['name'].".png", file_get_contents($app['icon']));
		
		$cat = $app['category'];
		$link = $app['name'];
		$app = array($app['name'],$app["title"], $app['name'].".png",$app['name']."/",$app["version"], $app['description'], 2);
		
		$catalog->addItem($app, $cat, 0);
		
		if (!mysqli_error())
			return true;
		else{ 
			throw new Exception("Error: ".mysqli_error()." ".$catalog->getLastQuery());
			Logger::addReport("AppManager.php",Logger::STATUS_ERROR,"Не удалось добавить приложение {$app[0]} в виртуальный директорий приложений!");
			return false;
		}
		
		Logger::addReport("AppManager.php",Logger::STATUS_INFO,"Приложение {$app['name']} установлено в систему.");
		return true;
			
	}
	
	
	public static function installLocalApp($app, $category, $icon){
		file_put_contents($_SERVER['DOCUMENT_ROOT']."/core/img/".$app[2], file_get_contents($_SERVER['DOCUMENT_ROOT'].$icon));
		if(AppManager::isInstalled($app[0])){
			self::removeApp($app[0]);
		}
		self::catalog()->addItem($app,$category, 0);
		return true;
	}
	
	private static function catalog(){
		return new RCatalog('cata_apps');
	}
	
	public static function getInstalledApplications(){		
		return self::catalog()->getItemsAt(1);
	}
	
	
	public static function removeApp($name){
		if(!self::isInstalled($name)) return false;
		$app = self::appByName($name);
		self::catalog()->remove($app[id],1);
	}
	
	
	public static function isInstalled($name){
				
		$apps = self::catalog()->getAllByQuery(1, "name='$name'");
		if(count($apps)) return true;
		return false;
	}
	
	public static function appById($id){
		$app = self::catalog()->getItemAt($id, 1);
		if(count($app)) return $app;
		return NULL;
	}
	
	public static function appByName($name){
		$apps = self::catalog()->getAllByQuery(1, "name='$name'");
		if(count($apps)) return $apps[0];
		return NULL;
	}

}


?>