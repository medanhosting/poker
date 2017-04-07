<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";
    
class Poker_Accounts{
    

    public static function Add($params){
        $params['location'] = count($params['Location']) ? $params['Location'] : "N/A";
        return Api::exec("AccountsAdd", $params);
    }

    public static function DecBalance($params){
        return Api::exec("AccountsDecBalance",$params);
    }

    public static function Delete($params){
        return Api::exec("AccountsDelete",$params);
    }
    
    public static function Edit($params){
        return Api::exec("AccountsEdit",$params);
    }
    
    public static function Get($params){
        return Api::exec("AccountsGet",$params);
    }
    
    public static function IncBalance($params){
        return Api::exec("AccountsIncBalance",$params);
    }
    
    public static function _List($params){
        return Api::exec("AccountsList",$params);
    }
    
    public static function Password($params){
        return Api::exec("AccountsPassword",$params);
    }
    
    public static function Permission($params){
        return Api::exec("AccountsPermission",$params);
    }
    
    public static function SessionKey($params){
        return Api::exec("AccountsSessionKey",$params);
    }
    
}