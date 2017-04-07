<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";

class Poker_Connections{
    
    public static function Get($params){
        return Api::exec("ConnectionsGet",$params);
    }
    
    public static function _List($params){
        return Api::exec("ConnectionsList",$params);
    }
    
    public static function Message($params){
        return Api::exec("ConnectionsMessage",$params);
    }
    
    public static function Terminate($params){
        return Api::exec("ConnectionsTerminate",$params);
    }
    
}