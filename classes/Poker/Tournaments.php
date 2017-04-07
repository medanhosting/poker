<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";
   
class Poker_Tournaments{
    
    public static function Add($params){
        return Api::exec("Tournaments"."Add",$params);
    }
    
    public static function Delete($params){
        return Api::exec("Tournaments"."Delete",$params);
    }
    
    public static function Edit($params){
        return Api::exec("Tournaments"."Edit",$params);
    }
    
    public static function Get($params){
        return Api::exec("Tournaments"."Get",$params);
    }
    
    public static function _List($params){
        return Api::exec("Tournaments"."List",$params);
    }
    
    public static function Message($params){
        return Api::exec("Tournaments"."Message",$params);
    }
    
    public static function Offline($params){
        return Api::exec("Tournaments"."Offline",$params);
    }
    
    public static function Online($params){
        return Api::exec("Tournaments"."Online",$params);
    }
    
    public static function Open($params){
        return Api::exec("Tournaments"."Open",$params);
    }
    
    public static function Pause($params){
        return Api::exec("Tournaments"."Pause",$params);
    }
    
    public static function Playing($params){
        return Api::exec("Tournaments"."Playing",$params);
    }
    public static function Register($params){
        return Api::exec("Tournaments"."Register",$params);
    }
    
    public static function RemoveNoShows($params){
        return Api::exec("Tournaments"."RemoveNoShows",$params);
    }
    
    public static function Results($params){
        return Api::exec("Tournaments"."Results",$params);
    }
    
    public static function Resume($params){
        return Api::exec("Tournaments"."Resume",$params);
    }
    
    public static function Start($params){
        return Api::exec("Tournaments"."Start",$params);
    }
    
    public static function Stats($params){
        return Api::exec("Tournaments"."Stats",$params);
    }
    
    public static function Unregister($params){
        return Api::exec("Tournaments"."Unregister",$params);
    }
    
    public static function Waiting($params){
        return Api::exec("Tournaments"."Waiting",$params);
    }
}