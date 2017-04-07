<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";
  
class Poker_Grabber{
    
    const TYPE_GAME = 1;
    const TYPE_TOURNAMENT = 2;
    const HAND_HISTORY_TABLE = "poker_cache_handhistory";
    const HANDS_TABLE = "poker_cache_hands";
    const CACHE_DELAY = 90000;
    
    
    public static $cache = [];

    public static $rakeSum = [];
    
    public static function getHandHistoryList(){
        $files = Poker_Logs::HandHistory([]);
        $games = Poker_RingGames::_List(["Fields"=>"Name"]);
        $games = $games['Name'];
        
        $result = [];
     
        foreach($files["Date"] as $i=>$v){
            if(in_array($files["Name"][$i], $games)){
                $type=self::TYPE_GAME;
            }else{
                $type=self::TYPE_TOURNAMENT;
            }
            $result[]=array("Date"=>$v,"Name"=>$files["Name"][$i],"Type"=>$type);
        }
        $result = self::excludeCached($result);
        return $result;
    }
    
    public static function excludeCached($data){
        $sql = new SQLConnection;
        $res = [];
        
       
        
        foreach ($data as $file){
            
            $fts = strtotime($file['Date']." 00:00:00");
            $ts = strtotime(date("Y-m-d H:i:s"));
            
            
            if($fts>($ts-self::CACHE_DELAY)){
                $res[]=$file;
                
                
                #echo "<p> Included because is not old enough. </p>";
                continue;
            }
            
            // $temp = $sql->getArray("SELECT * FROM ".self::HAND_HISTORY_TABLE." WHERE name='{$file['Name']}' AND `date`='{$file['Date']} 00:00:00'");
            $temp = [];
            if(!count($temp)){
                $res[] = $file;
                #echo "<p> Included because is absent in DB. </p>";
            }else{
                #print_r($temp[0]);
            }
        }
        
        return $res;
    }
    
    public static function grabFile($file){
        $sql = new SQLConnection();
        $data = Poker_Logs::HandHistory(["Date"=>$file['Date'],"Name"=>$file["Name"]]);

        if(!$data["Data"]){
            return null;
        }
        $data = $data["Data"];
        
        // $sql->query("DELETE FROM ".self::HAND_HISTORY_TABLE." WHERE name='{$file['Name']}' AND `date`='{$file['Date']} 00:00:00' ");
        // $sql->query("INSERT INTO ".self::HAND_HISTORY_TABLE." VALUES (default, '{$file['Name']}', '{$file['Date']} 00:00:00', '".addslashes(json_encode($data))."', NOW(), {$file['Type']})");
        
        return $data;    
    }
    
    
    public static function grabHands($data, $file){
        $type = $file["Type"];
        $sql = new SQLConnection();
        
        #returns an array of hands in file data
        $hands = [];
        $res = [];
        $hc = "";
        $story= [];
        foreach($data as $i=>$v){
            if(!$v) continue;
            
            if($v[0]=="H" || $v[0]=="h"){
                if(strpos(strtolower(trim($v)),"hand")===0){
                    $hc = $v;
                    $story=[];
                    $res = [];
                    
                    preg_match("/#([\d]+)/", $hc, $matches);
                }
            }
            
            $story[]=addslashes($v);
            if($v[0]=="*"){
                if(strpos(strtolower(trim($v)),"** deck **")===0){
                    if($type = Poker_Grabber::TYPE_GAME){
                        $stats = $data[$i-1];
                        $statsT = $stats;
                        
                        preg_match("/Rake\s+\((\d+)\)/",$stats,$matches);
                        $rake = $matches[1];
                        
                        preg_match("/Pot\s+\((\d+)\)/",$stats,$matches);
                        $pot = $matches[1];
                        
                        $pl = explode("Players",$stats);
                        $pl = str_replace("(","",$pl);
                        $pl = str_replace(")","",$pl);
                        $pl = trim($pl[1]);
                        
                        $pl = explode(",",$pl);
                        $players = [];
                        foreach($pl as $p){
                            $t = explode(":",$p);
                            $players[addslashes(trim($t[0]))]=floatval(trim($t[1]));
                        }
                        
                        $stats = array(
                            "Rake"=>$rake
                            ,"Pot"=>$pot
                            ,"Players"=>$players
                            );
                        $stats = json_encode($stats);
                    
                        preg_match("/#([\d]+)/", $hc, $matches);
                        $hand= $matches[1];
                        
                        preg_match("/#([\d\-]+)/", $hc, $matches);
                        $hn = $matches[1];

                        $handSql = $sql->query("SELECT `id` FROM `poker_cache_hands` WHERE `hand_id`='{$hn}'");

                        if($handSql->num_rows)
                            continue;
                        
                        preg_match("/\s(\d{4}\-\d{1,2}\-\d{1,2}\s\d{1,2}\:\d{1,2}\:\d{1,2})/", $hc, $matches);
                        $date = $matches[1];
                        
                        $story = json_encode($story);
                        
                        $hands[]=array("HandTitle"=>$hc,"StatsTitle"=>$statsT,"History"=>$story, "Hand"=>$hand,"HandNumber"=>$hn, "Date"=>$date, "Stats"=>$stats);
                        
                        $story = addslashes($story);
                        $statsT = addslashes($statsT);
                        $hc = addslashes($hc);


                        foreach($players as $player=>$bet){
                            $sql->query("INSERT INTO `poker_cache_hands` (`id`, `date`, `hand_id`, `player_name`, `ring_name`) VALUES (default, '$date', '$hn', '$player', '{$file['Date']}')");

                            $handSql = $sql->getArray("SELECT * FROM `poker_player_rake` WHERE `player_name`='{$player}'");

                            if($handSql){
                                $newRake = $handSql[0]['totalrake'] + ($bet/$pot)*$rake;
                                $newRake = ceil($newRake);
                                $sql->query("UPDATE INTO `poker_cache_hands` SET `total_rake` = {$newRake} WHERE `player_name`='{$player}'");

                            }else{
                                $newRake = ceil(($bet/$pot)*$rake);
                                $sql->query("INSERT INTO `poker_cache_hands` (`id`, `date`, `player_name`, `total_rake`) VALUES (default, '$date', '$player', '$newRake')");
                            }
                        }
                            

                        
                        
                        $story=[];
                        $res = [];  
                    }
                    
                }
            }
        }
        return $hands;
        
    }
    
    
    public static function grabRingGames(){
        $fields = "Name,Status,Description,Auto,Game,PW,Private,PermPlay,PermObserve,PermPlayerChat,PermObserverChat,SuspendChatAllIn,Seats,SmallestChip,BuyInMin,BuyInMax,BuyInDef,Rake,RakeEvery,RakeMax,TurnClock,TimeBank,BankReset,DisProtect,SmallBlind,BigBlind,DupeIPs,RatholeMinutes,SitoutMinutes,SitoutRelaxed";
        $data = Poker_RingGames::_List(["Fields"=>"$fields"]);
        $count = $data['RingGames'];
        
        $sql = new SQLConnection();
        $sql->query("DELETE FROM poker_cache_ringgames");
        
        $lowerfields = explode(",",strtolower($fields));
        $fields = explode(",",$fields);
        
        $games = [];
        for($i=0;$i<$count;$i++){
            
            $game = [];
            $query=["default"];
            foreach($fields as $j=>$field){
                $game[$field]=$data[$field][$i];
                $query[] = "'".addslashes($data[$field][$i])."'";
            }
            $query = implode(",",$query);
            
            #echo "INSERT INTO poker_cache_ringgames VALUES ($query)";
            $sql->query("INSERT INTO poker_cache_ringgames (id, ".implode(",",$lowerfields).") VALUES ($query)");
            echo $sql->error();
            $games[]=$game;
        }
        
        return $games;
    }
    
    public static function grabTournamentList(){
        $fields = "Name,Status,Description,Auto,Game,Shootout,PW,Private,PermRegister,PermUnregister,PermObserve,PermPlayerChat,PermObserverChat,SuspendChatAllIn,Tables,Seats,StartFull,StartMin,StartCode,StartTime,RegMinutes,LateRegMinutes,MinPlayers,RecurMinutes,NoShowMinutes,BuyIn,EntryFee,PrizeBonus,MultiplyBonus,Chips,AddOnChips,TurnClock,TimeBank,BankReset,DisProtect,Level,RebuyLevels,Threshold,MaxRebuys,RebuyCost,RebuyFee,BreakTime,BreakLevels,StopOnChop,Blinds,Payout,UnregLogout";
        $data = Poker_Tournaments::_List(["Fields"=>$fields]);
        
        $count = $data['Tournaments'];
        
        $sql = new SQLConnection();
        #$sql->query("DELETE FROM poker_cache_tournaments");
        
        $lowerfields = explode(",",strtolower($fields));
        $fields = explode(",",$fields);
        
        $tournaments = [];
        $existing = $sql->getArray("SELECT name FROM poker_cache_tournaments");
        $existing = array_map(function($el){return $el['name'];}, $existing);
        
        for($i=0;$i<$count;$i++){

            if(!in_array($data["Name"][$i], $existing)){
                 $trn = [];
                $query=["default","default","default","default"];
                foreach($fields as $j=>$field){
                    $trn[$field]=$data[$field][$i];
                    $query[] = "'".addslashes($data[$field][$i])."'";
                }
                $query = implode(",",$query);
                $sql->query("INSERT INTO poker_cache_tournaments (id, point_fee, restart_time, point_enabled, ".implode(",",$lowerfields).") VALUES ($query)");
            }else{
                
                $query=[];
                foreach($fields as $j=>$field){
                    $query[]= strtolower($field)."='".addslashes($data[$field][$i])."'";
                }
                $query = implode(",",$query);
                $q = "UPDATE poker_cache_tournaments SET $query WHERE name='{$data['Name'][$i]}'";
                #echo $q."\n";
                $sql->query($q);
            }
            echo $sql->error();
            $tournaments[]=$game;
        }
        
        return $tournaments;
        
    }
    
    public static function grabTournamentResultFiles(){
        
        return Poker_Tournaments::Results([]);
    }
    
    public static function grabNewTournamentResultFiles(){
        
        $results = self::grabTournamentResultFiles();
        $sql = new SQLConnection();
        $res = [];
        
        for($i=0; $i<$results["Files"]; $i++){
            $temp = $sql->getArray("SELECT * FROM poker_cache_tournament_results WHERE name='{$results['Name'][$i]}' AND `date`='{$results['Date'][$i]} 00:00:00'");
            if(!count($temp)){
                $res[]=array("Date"=>$results['Date'][$i], "Name"=>$results['Name'][$i]);
            }else{
                #echo strtotime($results['Date'][$i]." 23:59:59")." <-> ".(strtotime(date("Y-m-d H:i:s"))-2*self::CACHE_DELAY)."\n";
                if(strtotime($results['Date'][$i]." 23:59:59")>(strtotime(date("Y-m-d H:i:s"))-self::CACHE_DELAY)){
                    $res[]=array("Date"=>$results['Date'][$i], "Name"=>$results['Name'][$i]);
                }
            }
            
        }
        
       
        return $res;
    }
    
    public static function grabTournamentResults(){
        
        $files = self::grabNewTournamentResultFiles();
        $data = [];
        foreach($files as $file){
            $raw = Poker_Tournaments::Results(["Name"=>$file['Name'], "Date"=>$file["Date"]]);
            $data = array_merge($data, self::parseTournaments($raw["Data"], $file)); 
            
        }
        
        
        return $data;
    }
    
    public static function putTournaments(){
        $sql = new SQLConnection();
        $i = 0;
        $result = [];
        
        $data = self::grabTournamentResults();

        foreach($data as $res){
            $temp = $sql->getAssocArray("SELECT * FROM poker_cache_tournament_results WHERE id='{$res['Number']}' ");
            if(!count($temp)){
                $result[] = $res;
                $sql->query("INSERT INTO poker_cache_tournament_results (
                    id 
                    ,name
                    ,date
                    ,tournament
                    ,number
                    ,buyin
                    ,prizebonus
                    ,multiplybonus
                    ,entrants
                    ,late
                    ,removed
                    ,rebuys
                    ,addons
                    ,rebuycost
                    ,netbonus
                    ,stoponchop
                    ,start
                    ,stop
                    ,places
                ) VALUES 
                (
                    {$res['Number']}
                    ,'{$res['Name']}'
                    ,'{$res['Date']}'
                    ,'{$res['Tournament']}'
                    ,{$res['Number']}
                    ,'{$res['BuyIn']}'
                    ,'{$res['PrizeBonus']}'
                    ,'{$res['MultiplyBonus']}'
                    ,'{$res['Entrants']}'
                    ,'{$res['Late']}'
                    ,'{$res['Removed']}'
                    ,'{$res['Rebuys']}'
                    ,'{$res['Addons']}'
                    ,'{$res['RebuyCost']}'
                    ,'{$res['NetBonus']}'
                    ,'{$res['StopOnChop']}'
                    ,'{$res['Start']}'
                    ,'{$res['Stop']}'
                    ,'{$res['Places']}'
                )");
                # Creating new tournament result line in db
                
                
                #echo mysqli_error();
            }
        }
        
        
        return $result;
    }
    
    public static function parseTournaments($data, $file){
        $res = [];
        foreach($data as $d){
            
            if(!trim($d)){
                
                $places = Poker_Calculations::parseTournamentPlayers($r['places']);
                $r['Places'] = json_encode($places);
                
                
                $r['Date'] = $file['Date'];
                $r['Name'] = $file['Name'];
                
                $res[]=$r;
                continue;
            }
            
            $val = explode("=",$d);
            $prop = $val[0];
            $val = $val[1];
            
            if(strpos(strtolower($d),"tournament")===0){
                $r = [];
            }
            
            if(strpos(strtolower($prop),"place")===0){
                
                if(!isset($r['places'])){
                    $r['places']=[];
                }
                
                $pr = explode("place",strtolower($prop));
                $i = $pr[1];
                $r['places'][$i]=$val;
                
               # continue;
            }
            
            $r[$prop] = $val;
        }
        return $res;
    }
    
    
    public static function grabNewUsers($print){
        $users = Poker_Accounts::_List(["Fields"=>"Player,Location,Email,Balance,Gender,RealName,FirstLogin"]);
        $sql = new SQLConnection;
        $count = $users['Accounts'];
        $res = [];
        
        for($i=0; $i<$count; $i++){
            $user = array(
                "name"=>$users["Player"][$i]
                ,"realname"=>$users["RealName"][$i]
                ,"gender"=>$users["Gender"][$i]=="Female" ? 1 : 2
                ,"location"=>$users["Location"][$i]
                ,"balance"=>$users["Balance"][$i]
                ,"email"=>$users["Email"][$i]
                ,"registered"=>$users["FirstLogin"][$i]
            );
            
            #print_r($user);
            $temp = $sql->getArray("SELECT id FROM poker_users WHERE name='{$user['name']}'");
            
            
            if(!count($temp)){
               $sql -> query("INSERT INTO poker_users (`id`,`name`, `balance`, `chips`, `referral`, `email`, `password`, `realname`, `location`, `gender`, `api_id`, `registered`,`totalrake`, `comission`,`rake`,`rake_parsed`) VALUES (default, '{$user['name']}',{$user['balance']},0,0,'{$user['email']}','', '{$user['realname']}', '{$user['location']}', {$user['gender']}, 0, '{$user['registered']}', default, default, 0, NOW() )");
               $res[] = $user;
            }else{
                #Updating some fields for existing users.
                if($print) echo "Updated user ".$user['name']."\n";
               $sql -> query("UPDATE poker_users SET balance={$user['balance']}, chips={$user['chips']} WHERE id={$temp[0]['id']}");
            }
        }
        
        return $res;
    }
}