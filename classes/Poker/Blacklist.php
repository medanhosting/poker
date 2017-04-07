<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";

class Poker_Blacklist{
    
    public static function Add($params){
        return Api::exec("BlacklistAdd",$params);
    }
    
    public static function Delete($params){
        return Api::exec("BlacklistDelete",$params);
    }
    
    public static function Edit($params){
        return Api::exec("BlacklistEdit",$params);
    }
    
    public static function Get($params){
        return Api::exec("BlacklistGet",$params);
    }
    
    public static function _List($params){
        return Api::exec("BlacklistList",$params);
    }
    
}