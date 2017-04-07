<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";
    
class Api{
    
    private static $server = "http://192.99.236.77:81" ;
    private static $requests = 0;
    public static $lastRequest = "";
    
    public static function exec($command, $params){
        $url = self::$server."/api";  // put your API path here
        $pw = "save";                  // put your API password here
          
        $params['Password'] = $pw;
        $params['JSON'] = 'Yes';
        $params['Command'] = $command;
        
        $curl = curl_init($url);
        self::$lastRequest = $url;
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_TIMEOUT, 3000);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);


        $response = curl_exec($curl);

        if (curl_errno($curl)) $obj =  array('Result' => 'Error', 'Error' => curl_error($curl)); 
        else if (empty($response)) $obj = array('Result' => 'Error', 'Error' => 'Connection failed'); 
        else $obj = json_decode($response, true);
        
        curl_close($curl);
        
        Logger::addReport("API",Logger::STATUS_WARN,"[".(++self::$requests)."]API Request $command: ".print_r($params,true));
        
        return $obj;
    }
    
    public static function getServer(){
        return self::$server;
    }
}