<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";
   
class Poker_System{
    
    
    
    public static function Balance($params){
        return Api::exec("SystemBalance",$params);
    }
    
    public static function LobbyMessage($params){
        return Api::exec("SystemLobbyMessage",$params);
    }
    
    public static function FeeDec($params){
        return Api::exec("SystemFeeDec",$params);
    }
    
    public static function FeeGet($params){
        return Api::exec("SystemFeeGet",$params);
    }
    
    public static function FeeInc($params){
        return Api::exec("SystemFeeInc",$params);
    }
    
    public static function EntryFeeSet($params){
        return Api::exec("SystemEntryFeeSet",$params);
    }
    
    public static function RakeDec($params){
        return Api::exec("SystemRakeDec",$params);
    }
    
    public static function RakeGet($params){
        return Api::exec("SystemRakeGet",$params);
    }
    
    public static function RakeInc($params){
        return Api::exec("SystemRakeInc",$params);
    }
    
    public static function RakeSet($params){
        return Api::exec("SystemRakeSet",$params);
    }
    
    public static function Reboot($params){
        return Api::exec("SystemReboot",$params);
    }
    
    public static function Stats($params){
        return Api::exec("SystemStats",$params);
    }
}