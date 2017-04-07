<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";
    
class Poker_RingGames{
    
    public static function Add($params){
        return Api::exec("RingGamesAdd",$params);
    }
    
    public static function Delete($params){
        return Api::exec("RingGamesDelete",$params);
    }
    
    public static function Edit($params){
        return Api::exec("RingGamesEdit",$params);
    }
    
    public static function Get($params){
        return Api::exec("RingGamesGet",$params);
    }
    
    public static function _List($params){
        return Api::exec("RingGamesList",$params);
    }
    
    public static function Message($params){
        return Api::exec("RingGamesMessage",$params);
    }
    
    public static function Offline($params){
        return Api::exec("RingGamesOffline",$params);
    }
    
    public static function Online($params){
        return Api::exec("RingGamesOnline",$params);
    }
    
    public static function Open($params){
        return Api::exec("RingGamesOpen",$params);
    }
    
    public static function Pause($params){
        return Api::exec("RingGamesPause",$params);
    }
    
    public static function Playing($params){
        return Api::exec("RingGamesPlaying",$params);
    }
    
    public static function Resume($params){
        return Api::exec("RingGamesResume",$params);
    }
    
    public static function Waiting($params){
        return Api::exec("RingGamesWaiting",$params);
    }
    
}