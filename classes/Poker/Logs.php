<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";
    
class Poker_Logs{
    
    public static function AddEvent($params){
        return Api::exec("LogsAddEvent",$params);
    }
    
    public static function Error($params){
        return Api::exec("LogsError",$params);
    }
    
    public static function Event($params){
        return Api::exec("LogsEvent",$params);
    }
    
    public static function HandHistory($params){
        return Api::exec("LogsHandHistory",$params);
    }
    
    public static function LobbyChat($params){
        return Api::exec("LogsLobbyChat",$params);
    }

}