<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";

class UserMachine{
    
    public static function passwordHash($pw){
        return $pw;
    }
    
    public static function ssidHash($user){
       return md5($user->playername.rand().microtime().$user->password);    
        
    }
    
    
    public static function register($data){
        $sql = new SQLConnection();
        $gender = $data['gender']=="m" ? 1 : 2;
        $password = self::passwordHash($data['password']);
        $code = self::unpackAffiliateCode($data['referral']);
        if($data['referral_level']==2){
            $data['commission'] =  0;
        }
        
        
        $q = "INSERT INTO poker_users (`id`,`name`, `balance`, `points`, `points_dec`, `tournaments_fee`,`chips`, `referral`, `referral_level`, `email`, `password`, `realname`, `location`, `gender`, `api_id`, `registered`,`totalrake`, `comission`,`level2_comission`,`rake`,`rake_parsed`) VALUES (default, '{$data['playername']}',0,default,default,0, 0,{$code['id']}, {$code['level']}, '{$data['email']}','$password', '{$data['realname']}', '{$data['location']}', $gender, 0, NOW(), default, ".($data['commission']*1).", default, 0, NOW() )";
        $sql -> query($q);
        
        if($sql->error()) echo $sql->error()." ".$q;
        $api_add = Poker_Accounts::Add(array(
            "Player"=>$data['playername']
            ,"Title"=>""
            ,"Level"=>""
            ,"RealName"=>$data['realname']
            ,"PW"=>$data['password']
            ,"Gender"=>$data['gender']
            ,"Location"=>$data['location']
            ,"Permissions"=>""
            ,"ChipsTransfer"=>""
            ,"ChipsAccept"=>""
            ,"Chat"=>""
            ,"ChatColor1"=>""
            ,"Email"=>$data['email']
            ,"ValCode"=> substr(md5(rand()),0,8)
            ,"Avatar"=> 1
            ,"AvatarFile"=> ""
            ,"Custom"=> ""
            ,"Note"=>""
            ));
        
        #if(mysqli_error()) echo mysqli_error();
        #Logger::addReport("UserMachine::register",Logger::STATUS_INFO,print_r($api_add,true));
        
        $temp = $sql->getArray("SELECT id FROM poker_users WHERE name='{$data['playername']}'");
        
        return $temp[0]['id'];
        
    }  
    
    public static function isUserByPlayerName($name){
        $name = strtolower(trim($name));
        
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT id FROM poker_users WHERE name=LOWER('$name')");
        
        return (count($temp) ? TRUE : FALSE);
    }
    
    public static function isUserByEmail($email){
        $email = strtolower(trim($email));
        
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT id FROM poker_users WHERE email=LOWER('$email1')");
        
        return (count($temp) ? TRUE : FALSE);
    }
    
    public static function getUserByPlayerName($name){
        $name = strtolower(trim($name));
        
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT id FROM poker_users WHERE name=LOWER('$name')");
        
        return (count($temp) ? new User($temp[0]['id']) : NULL);
    }
    
    
    public function authUser($user){
        
        $ssid = self::ssidHash($user);
        
        setcookie("ssid",$ssid,time()+7*86400, "/");
        $_COOKIE['ssid']=$ssid;
        
        $user->ssid = $ssid;
        $user->submitChanges();
        
    }
    
    
    public static function getCurrentUser(){
        $ssid = $_COOKIE['ssid'];
        if(!$ssid) return null;
        $sql = new SQLConnection();
        
        $temp = $sql->getArray("SELECT id FROM poker_users WHERE ssid='$ssid'");
        if(!count($temp)){
            return null;
        }
        
        return new User($temp[0]['id']);
        
    }
    
    
    public static function logoutCurrentUser(){
        
        if(self::getCurrentUser()==null){
            setcookie("ssid","",time()-1, "/");
            return;
        }else{
            $user = self::getCurrentUser();
            $user->ssid = "";
            $user->submitChanges();
            setcookie("ssid","",time()-1, "/");
            $_COOKIE["ssid"] = "";
            return;
        }
    }
    
    public static function getAllUsers(){
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT id FROM poker_users");
        $res = [];
        
        foreach($temp as $u){
            $res[] = new User($u['id']);
        }
        
        return $res;
    }
    
    public static function getTrueAffiliates(){
        $sql = new SQLConnection();
        $names = $sql->getArray("SELECT * FROM poker_affiliate_requests WHERE status=".AffiliateRequests::STATUS_ACCEPTED);
        $res=[];
        foreach($names as $i=>$v){
            $res[] = self::getUserByPlayerName($v['user']);
        }
        
        return $res;
        
    }
    
    
    public static function getAllUserNames(){
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT name FROM poker_users");
        $res = [];
        
        foreach($temp as $u){
            $res[] = $u['name'];
        }
        
        return $res;
    
    }
    public static function getUsersCount(){
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT count(id) FROM poker_users");
        
        return $temp[0][0];
    }
    
    public static function getUserPage($offset, $step, $name=""){
        $sql = new SQLConnection();
        if($name!=""){
            $name = strtolower($name);
            $temp = $sql->getArray("SELECT id FROM poker_users WHERE LOWER(name) LIKE '$name%' LIMIT $offset, $step");
        }else{
            $temp = $sql->getArray("SELECT id FROM poker_users LIMIT $offset, $step");
        }
        $res = [];
        
        foreach($temp as $u){
            $res[] = new User($u['id']);
        }
        
        return $res;
    }
    public static function searchUsersArray($namePart, $nameOnly=false){
        $sql = new SQLConnection();
        $name = strtolower($namePart);
        $temp = $sql->getArray("SELECT * FROM poker_users WHERE LOWER(name) LIKE '%$name%'");
        $res = [];
        $c= 0;
        foreach($temp as $u){
            $rake = json_decode($u['totalrake'], true);
            $rake =$rake['rake'];
            
            if($nameOnly){
                $c++;
                $res[] = ["name"=>$u['name']];
                if($c > 10) break;
            }else{
                $res[] = array(
                    "id"=>$u['id']
                    ,"playername"=>$u['name']
                    ,"realname"=>$u['realname']
                    ,"email"=>$u['email']
                    ,"comission"=>$u['comission']
                    ,"rake"=>$rake
                    ,"registered"=>$u['registered']
                    ,"referral"=>$u['referral']
                    );
            }
        }
        return $res;
    }
    
    const ADDON = 1024;
    public static function getAffiliateCode($id, $level = 1){
        return $id*2 + $level*self::ADDON + ($level-1);
    }
    
    public static function unpackAffiliateCode($code){
        if($code%2){
            #level 2
            $id = (($code-1)-2*self::ADDON)/2;
            $level = 2;
        }else{
            $id=($code - self::ADDON)/2;
            $level = 1;
        }
        return array("id"=>$id, "level"=>$level);
    }
    
    public static function isTournamentRegisteredLocal($tournament, $user){
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT * FROM poker_tournament_registrations WHERE tournament='$tournament' AND user='{$user->playername}' ");
        
        if(count($temp)){
            return true;
        }
        return false;
    }
    
    public static function tournamentRegisterLocal($tournament, $user){
        if(self::isTournamentRegisteredLocal($tournament, $user)){
            return false;
        }
        $sql = new SQLConnection;
        $sql->query("INSERT INTO poker_tournament_registrations VALUES (default, '{$user->playername}', '$tournament', NOW(), '') ");
        $trn = $sql->getAssocArray("SELECT point_fee FROM poker_cache_tournaments WHERE name='".addslashes($tournament)."'");
        $fee = $trn[0]["point_fee"]*1;
        
        $sql->query("UPDATE poker_users SET points_dec=points_dec+$fee WHERE id=".$user->getId());
        
        if(mysqli_error()){
           
            return false;
        }return true;
    }
    
    public static function tournamentUnregisterLocal($tournament, $user){
        $sql = new SQLConnection();
        $sql->query("DELETE FROM poker_tournament_registrations WHERE tournament='$tournament' AND user='{$user->playername}'");
        
         $trn = $sql->getAssocArray("SELECT point_fee FROM poker_cache_tournaments WHERE name='".addslashes($tournament)."'");
        $fee = $trn[0]["point_fee"]*1;
        $sql->query("UPDATE poker_users SET points_dec=points_dec-$fee WHERE id=".$user->getId());
        
        if(mysqli_error()){
            return false;
        }
        return true;
    }
    
    public static function tournamentRegister($tournament, $user){
        self::tournamentRegisterLocal($tournament, $user);
        $res = Poker_Tournaments::Register(["Name"=>$_POST['tournament'], "Player"=>$user->playername, "Negative"=>"Allow"]);
        return $res;
    }
    
    const MESSAGE_UNSENT = 2;
    const MESSAGE_SENT = 1;
    const MESSAGE_NO_CONNECTION = 3;
    
    public static function trySendMessage($user, $message){
        $name = $user->playername;
        $sessions = Poker_Connections::_List(["Fields"=>"Player,SessionID"]);
        $ssid = 0;
        #print_r($sessions);
        for($i=0; $i<count($sessions["Player"]); $i++){
           if($sessions["Player"][$i]==$name){
               $ssid = $sessions["SessionID"][$i];
               break;
           } 
        }
        
        if($ssid){
            $res = Poker_Connections::Message(["SessionID"=>$ssid, "Message"=>$message]);
            if($res['Result']!="Ok"){
                return self::MESSAGE_UNSENT;
            }
            return self::MESSAGE_SENT;
        }
        return self::MESSAGE_NO_CONNECTION;
    }
    
    
    public static function isAbleToAffiliate($user){
        return ($user->getRealAffiliateReferralsCount() - Poker_Variables::get("invitations_affiliate") >=0  );
    }
}