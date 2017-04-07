<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/sql_class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/System.php";

class Logger{
	
	const TABLE='cata_logger_journal';
	static $sql;
	
	const STATUS_INFO=0;
	const STATUS_WARNING=1;
	const STATUS_WARN=1;
	const STATUS_ERROR=2;
	const STATUS_CRITICAL_ERROR=3;
	const STATUS_SAFETY_WARN=4;
	const STATUS_SAFETY_WARNING=4;
	
	private static function sql(){
		if(!self::$sql) self::$sql = new SQLConnection;
		return self::$sql;
	}
	
	
	public static function getReports(){
		return self::sql()->getArray("SELECT * FROM ".self::TABLE." ORDER BY id DESC");
		
	}
	
	public static function addReport($app, $status, $content){
		
		$date = date("Y-m-d H:i:s", time());
		$millis = intval(microtime(true)*1000)%1000;	
			
		$status=$status;
		$user = CoreUsers::getCurrent();
		$user = $user['login'];
		
		$app=$app;
		$content=addslashes($content);
		$content.="\n".$_SERVER['SCRIPT_FILENAME'];
		
		self::sql()->query("INSERT INTO ".self::TABLE." VALUES (default, '$date', $millis, $status, '$user', '$app', '$content')");
		if(!self::sql()->error()) return true;
		return false;		
	}
	
}

