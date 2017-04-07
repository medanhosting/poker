<?php

# CoreUsers class created to encapsulate operations with core users.
#
#
#

require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/System.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RCatalog.php";


class CoreUsers{

	const ADMIN = 1;
	const MODERATOR = 2;
	const GUEST = 3;
	const LIFETIME = 3600;
	
	private static $table = "cata_users";
	
	# getCurrent: Array
	# Returns an array of current user or FALSE if no user authotized.
	public static function getCurrent(){
		$ssid = $_COOKIE['ssid'];
		if(!$ssid) return false;
		
		$sql = new SQLConnection;
		$q = "SELECT * FROM ".self::$table." WHERE ssid='$ssid'";
		$users = $sql->getAssocArray($q);
		
		if(!count($users)) return false;
		return $users[0];
		
	}
	
	# getId (string, string) : int | bool
	# Returns an id of user with login and password sent, or FALSE if there's no such user in database
	public static function getId($login, $password){
		$sql = new SQLConnection;
		
		$q = "SELECT * FROM ".self::$table." WHERE login='$login' AND password='$password';";
		$users = $sql->getArray($q);
		
		if(count($users)){ return $users[0]['id'];}
		return false;
	}
	
	# getUser(int): Array
	# returns an array of user from database by id.	
	private static function getUser($id){
		$sql = new SQLConnection;
		
		$q = "SELECT * FROM ".self::$table." WHERE id='$id';";
		$users = $sql->getArray($q);
		
		if(count($users)){ return $users[0];}
		return false;
	}
	
	# isUserId (int, string) : bool
	# returns TRUE if user with given id has given password hash, FALSE otherwise
	public static function isUserId($id, $password){
		$sql = new SQLConnection;
		
		$q = "SELECT * FROM ".self::$table." WHERE id=$id AND password='$password';";
		$users = $sql->getArray($q);
		
		if(count($users)){ return true;}
		return false;
	}
	
	# getSSID(string, string) : string
	# creates unique SSID for user with given login and password.
	public static function getSSID($login, $password){
		return md5(md5(microtime(true)).md5($login).md5($password));
	}
	
	# login (string, string) : bool
	# tries to login a user with given login and raw password. If successfull, sets a cookie SSID and returns true.
	public static function login($login, $passwordstr){
		
		$password = md5($passwordstr);
		$sql = new SQLConnection;
		
		$q = "SELECT * FROM ".self::$table." WHERE login='$login' AND password='$password';";
		$users = $sql->getArray($q);
		
		if(count($users)){
			$ssid = self::getSSID($login, $password);
			$id = $users[0]['id'];
			
			self::setSSID($ssid);
			
			$q = "UPDATE ".self::$table." SET ssid='$ssid' WHERE id='$id'";
			$sql->query($q);
			
			
			Logger::addReport("CoreUsers.php",Logger::STATUS_INFO,"Авторизован пользователь $login. [{$_SERVER['REMOTE_ADDR']}]");
			return true;
		}
		Logger::addReport("CoreUsers.php",Logger::STATUS_SAFETY_WARNING,"Попытка войти в систему под некорректными данными, под логином $login, паролем $passwordstr! [{$_SERVER['REMOTE_ADDR']}]");
		return false;
	}
	
	# logout(): bool
	# unsets dynamic SSID for user and database.
	public static function logout(){
		$user = self::getCurrent();
		if($user){
			$sql = new SQLConnection;
			$id = $user['id'];
			$Q = "UPDATE ".self::$table." SET ssid='' WHERE id='$id'";
			$sql->query($Q);
			
		}
		Logger::addReport("CoreUsers.php",Logger::STATUS_INFO,"Пользователь {$user['login']} вышел из системы. [{$_SERVER['REMOTE_ADDR']}]");
		setcookie("ssid","",time()-10,"/core");
		unset($_COOKIE['ssid']);
		return true;
		
	}
	
	
	# setSSID(string) : bool
	# tries to set cookie SSID. If successfull, returns TRUE.
	private static function setSSID($ssid){
		$_COOKIE['ssid'] = $ssid;
		if (setcookie("ssid", $ssid, time()+self::LIFETIME, "/core")) return true;
		return false;
	}
	
	# reauth() : bool
	# tries to reset SSID for user in terms of dynamic ssid authorization system.
	public static function reauth(){
		$ssid = $_COOKIE['ssid'];
		if(!$ssid) return false;
		
		$sql = new SQLConnection;
		
		$q = "SELECT * FROM ".self::$table." WHERE ssid='$ssid'";
		$users = $sql->getAssocArray($q);
		
		if(count($users)){
			$ssid = self::getSSID($users[0]['login'], $users[0]['password']);
			$id = $users[0]['id'];
			
			self::setSSID($ssid);
			$q = "UPDATE ".self::$table." SET ssid='$ssid' WHERE id='$id'";
			$sql->query($q);
			
			Logger::addReport("CoreUsers.php",Logger::STATUS_INFO,"Изменен динамический SSID пользователя {$users[0]['login']}! [{$_SERVER['REMOTE_ADDR']}]");
			return true;
		}
		
		Logger::addReport("CoreUsers.php",Logger::STATUS_SAFETY_WARNING,"Неудачная попытка сменить динамический SSID пользователя {$users[0]['login']}! [{$_SERVER['REMOTE_ADDR']}]");
		return false;
	}
	
	# authorized() : bool
	# Returns TRUE if current user is authorized, and reauthorizates. If current user is not authorized, returns FALSE.
	public static function authorized(){
		$ssid = $_COOKIE['ssid'];
		if(!$ssid) return false;
		
		$sql = new SQLConnection;
		
		$q = "SELECT * FROM ".self::$table." WHERE ssid='$ssid'";
		$users = $sql->getArray($q);
		
		if(count($users)){
			self::reauth();
			return true;
		}
		
		return false;
	}
	
	# add(string, string, string) : bool
	# Creates new user in database. If user already exists, throws UserAlreadyExistsException exception.
	public static function add($login, $rpassword, $role){
		
		$password = md5($rpassword);
		$sql = new SQLConnection;
		
		$Q ="SELECT * FROM ".self::$table." WHERE login='$login'";
		$users = $sql->getArray($Q);
		
		if(count($users)){
			throw new UserAlreadyExistsException();
			Logger::addReport("CoreUsers.php",Logger::STATUS_ERROR,"Попытка создать уже существующего пользователя под логином {$users[0]['login']}");
			return false;
			
		}else{
			$Q="INSERT INTO ".self::$table." VALUES (default, '$login', '$password', $role, '', '')";
			mysqli_query($Q);
			
			if (mysqli_error()) return false;
			
			Logger::addReport("CoreUsers.php",Logger::STATUS_INFO,"Создан новый пользователь под логином $login");
			return true;
		}
	}
	
	# edit (int, Array) : bool
	# Tries to edit user. Data array should look like the following template:
	# $data = array("login"=> , "password"=> , ...);
	public static function edit($id, $data){
		$sql=new SQLConnection;
		if(!count($data)) return true;
		
		$Q = "UPDATE cata_users SET id=$id ";
		foreach ($data as $k=>$d){
			$Q.=" ,$k='$d' ";
		}
		$Q.=" WHERE id=$id";
		if ($sql->query($Q)) return true;
		return false;
	}
	
	# remove(int):bool
	# Removes user from database.
	public static function remove($id){
		$current = self::getCurrent();
		$role = $current['role'];
		
		$user = self::getUser($id);
		
		if($role>$user['role']){
			throw new NotEnoughRightsException();
			return false;
		} 
		$Q = "DELETE FROM ".self::$table." WHERE id='$id'";
		
		$sql = new SQLConnection;
		$sql->query($Q);
		if(!mysqli_error()) return true;
		return false;
	}
}

class NotEnoughRightsException extends Exception{
	public function __construct($message="Недостаточно прав пользователя для осуществления операции!"){
		parent::__construct($message);
	}
}

class UserAlreadyExistsException extends Exception{	
	public function __construct($message="Пользователь с таким логином уже существует!"){		
		parent::__construct($message);
	}
}