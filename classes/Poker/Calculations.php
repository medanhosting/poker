<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";
    
class Poker_Calculations{
    
    
    public static $cache;
    
    #$game = array("Date"=>, "Name"=>)
    #Returns array of summary rakes for all players for one hand history file
    public static function getSummaryRakesFor($game, $user=null){
        
        $history = Poker_Cache::getHandFile($game['Name'],$game['Date']);
        if($history===null){
            $history = Poker_Logs::HandHistory(array("Date"=>$game['Date'],"Name"=>$game['Name']));
        }
        
        #if($user) self::$cache[$user->playername][$game['Name']." ".$game['Date']] = [];
      
       
        $rakeVals = array("Rake"=>$rakeVals["Rake"],"RakeEvery"=>$rakeVals["RakeEvery"],"RakeMax"=>$rakeVals["RakeMax"]);
                
        $history = $history["Data"];
        $playerRakes = [];
        $flop = false;
        
        
        #echo count($history);
        #var_dump($history);
        
        
        #For each line in history file as $line
        $hand= "";
        foreach($history as $line){
            
            
            if(strpos(strtolower($line),"hand")===0){
                $hand = $line;
            }
            
            #Checking if there were flop
            if(strpos(strtolower($line),"** flop")===0){
                $flop= TRUE;
            }
            
            #Getting to the end of hand
            if(strpos(strtolower($line),"rake ")===0){
                
                
                $players = explode("Players ",$line);
                $players = trim($players[1]);
                $players = str_replace(["(",")"],"",$players);
                $players = explode(", ",$players);
                
                # $pot - pot value for this hand
                $pot=[];
                preg_match("/Pot\s\(([\d]+\))/",$line,$pot);
                $pot = intval($pot[1]);
                 
                # $r - rake value for this hanв
                $r = [];
                preg_match("/Rake\s\(([\d]+\))/",$line,$r);
                $r = intval($r[1]);
                
                $pl = [];
                foreach($players as $p){
                    $p = trim($p);
                    $p = explode(":",$p);
                    $pl[trim($p[0])] = trim($p[1]);
                }
                $players = $pl;
                $sumrake = 0;
                
                
                foreach($players as $p=>$val){
                    if(!self::$cache[$p]['games']){
                        self::$cache[$p]['games'] = [];
                    }
                    
                    if(!self::$cache[$p]['games'][$game['Name']." ".$game['Date']]){
                        self::$cache[$p]['games'][$game['Name']." ".$game['Date']] = [];
                    }
                    #$val = player bet in this hand
                    $players[$p] = $r*$val/$pot;
                    
                    
                    if($flop) self::$cache[$p]['games'][$game['Name']." ".$game['Date']][] = array("rake"=>$players[$p], "hand" =>$hand);  
                    
                    
                    $sumrake+=$players[$p];
                    if($flop) $playerRakes[$p]+=$players[$p];
                }
                
                $flop = FALSE;
            }else{
                
            }
        }
        return $playerRakes;
    }
    
    public static function initCache(){
        if(!is_array(self::$cache)){
            self::$cache = [];
        }
    }
    
    public static function clearCache(){
        self::$cache = [];
    }
    const CALCULATIONS_RAKE_CACHE = 120;
    
    public static function calculateTotalRakes(){
        self::clearCache();
        
        #Collectingall games history
        $handhistory = Poker_Cache::getHandHistory();
        $gameNames = Poker_Cache::getHandHistoryGameNames();
        #echo "HH, GN:"; print_r($gameNames);
        
        #Representing only game logs in suitable format
        $logs = [];
        foreach($handhistory["Date"] as $i=>$v){
            if(in_array($handhistory["Name"][$i], $gameNames["Name"])){
                $logs[]=array("Date"=>$v,"Name"=>$handhistory["Name"][$i]);
            }
        }
        
        $names = UserMachine::getAllUserNames();
        $sum = [];
        #print_r($names);
        foreach($names as $name){
            $sum[$name] = 0;
        }
        
        #echo "Logs:"; print_r($logs);
        foreach($logs as $game){
            #for each log getting rake
            $rake = Poker_Calculations::getSummaryRakesFor($game);
                       
            $players = array_keys($rake);
            foreach($players as $player){
                $sum[$player]+=$rake[$player]*1;
            }
        }
        
        #print_r($sum);
        foreach($sum as $u=>$r){
            $user = UserMachine::getUserByPlayerName($u);
            $user->cacheRake($r);
         # echo mysqli_error()."!!\n";
        }
        
        return $sum;
        
    }
    
    #<User> $user
    public static function calculateTotalRakeFor($user, $ignoreCache=false){
        self::clearCache();
        self::$cache[$user->playername] = [];
        
        
        
        $name = $user->playername;
        $regdate = $user->registered;
        $regts = strtotime($regdate);
        
        $handhistory = Poker_Cache::getHandHistory();
        $gameNames = Poker_Cache::getHandHistoryGameNames(); 
        
        $gameNames = $gameNames["Name"];
        
        $logs = [];
        foreach($handhistory["Date"] as $i=>$v){
            $ts = strtotime($v." 23:59:59");
          
            if($ts>$regts){
                if(in_array($handhistory["Name"][$i], $gameNames)){
                    $logs[]=array("Date"=>$v,"Name"=>$handhistory["Name"][$i]);
                    
                }
            }
        }
        self::$cache[$user->playername]["logs"] = $logs;
        #print_r(self::$cache);
        
        $sum = 0;
        $cache = $user->getRake();
        $cachetime = strtotime($cache['date']);
        
        if($cachetime>=strtotime(date("Y-m-d H:i:s"))-self::CALCULATIONS_RAKE_CACHE){
            if(!$ignoreCache){
                self::$cache[$user->playername]["rake"] = $sum;
                return $cache['rake'];
                
            }
        }
        
        foreach($logs as $game){
            #for each log getting rake
            $rake = Poker_Calculations::getSummaryRakesFor($game, $user);
            #$output.="<pre>".print_r($rake, true)."</pre>";
            
            $players = array_keys($rake);
            if(!in_array($name, $players)){
                continue;
            }else{
                $sum+=$rake[$name];
            }
        }
        
        self::$cache[$user->playername]["rake"] = $sum;
        
        $user->cacheRake($sum);
        #echo "!!";
        #echo mysqli_error();
        return $sum;
    }
    
    
    
    public static function tournamentFee($data){
        $entrants = $data['entrants']*1;
        
        $fee = explode("+", $data['buyin']);
        $fee = $fee[1]*1;
        
        $rebuy = explode("+",$data['rebuycost']);
        $rebuyFee = $rebuy[1]*1;
        
        $rebuy = $data['rebuys']*1;
        $addons = $data['addons']*1;
        
        return $entrants*$fee + ($rebuy+$addons)*$rebuyFee;
    }

    public static function getFreerollArray($data){
        $pls = json_decode($data['places'],true);
        $players = [];
        $totalPrize=0;
        foreach($pls as $pl){
            $totalPrize += $pl['prize'];
        }
        foreach($pls as $pl){
            $players[$pl['name']] = $totalPrize/count($pls);
        }
        return $players;
    }
    
    public static function getTournamentFeeArray($data){
        $pls = json_decode($data['places'],true);
        $players = [];
        
        $fee = explode("+",$data["buyin"]);
        $fee = array_sum($fee);
        
        $rfee = explode("+",$data['rebuycost']);
        $rfee = array_sum($rfee);
        for($i=1; $i<=count($pls); $i++){
            $pl = $pls[$i];
            $pl['prize']*=1;
            
            $rebuy = $pl['rebuys']*1;
            $addon = $pl['addon']*1;
            
            $f = ($fee + ($rebuy + $addon)*$rfee);
            
            $players[$pl['name']]=$f;
            
        }
        return $players;
    }
    
    public static function totalBuyIn($data){
        $entrants = $data['entrants']*1;
        $buyin = explode("+", $data['buyin']);
        $buyin = $buyin[0]*1+$buyin[1]*1;
        $rebuys = $data['rebuys']*1;
        $addons = $data['addons']*1;
        
        $rebuy = explode("+",$data['rebuycost']);
        $rebuy = $rebuy[0]*1+$rebuy[1]*1;
        
        return $entrants*$buyin + ($rebuys+$addons)*$rebuy;
    }

    public static function isTournamentAborted($data){
        
        $places = $data['places'];
        if(count(json_decode($places, true))!=$data['entrants']){
            #echo $places;
            return true;
        }
        return false;
    }
    
    public static function isTournamentPlaying($trn){
        $sql = new SQLConnection;
        $trn = addslashes($trn);
        
        $temp = $sql->getArray("SELECT status FROM poker_cache_tournaments WHERE name='$trn'");
        if(!count($temp)){
            return false;
        }
        if(strpos(strtolower($temp[0][0]),"playing")!==FALSE){
            return true;
        }
        return false;
    }
    
    public static function parseTournamentPlayers($players){
        #print_r($players);
        
        $res = [];
        foreach($players as $i=>$pl){

            $r = [];
            $arr= [];
            
            $er = preg_match("/^([^\(\)]+)\s?\((\d+)\)(.*)$/", $pl,$arr);
            preg_match("/^([^\(\)]+)\s?\((\d+)\)\s?Rebuys\:(\d+)\s?AddOn\:(.*)$/", $pl,$arr2);
            
            $r = ["name"=>trim($arr[1]), "prize"=>trim($arr[2])*1, "rebuys"=>trim($arr2[3])*1, "addon"=>trim($arr2[4])*1];
            
            $res[$i] = $r;
        }
        
        return $res;
    }
    
    public static function getTotalRake(){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT SUM(rake) FROM poker_users");
        
        return $temp[0][0];
    }
    
    
    public static function recalculateUserPoints(){
        
        $sql = new SQLConnection;
        
        $pointsperref = Poker_Variables::get("points_invitation")*1;
        $rakeforref = Poker_Variables::get("points_invitation_rake")*1;
        $refmintime = Poker_Variables::get("referral_mintime")*1;
        $pointsperrake = Poker_Variables::get("points_formula_rake")*1;
        
        $q = "SELECT id, COUNT(rake) AS count, COUNT(rake)*$pointsperref AS points FROM 
            (SELECT A.id, A.rake as aff_rake, B.id AS ref_id, B.registered, B.rake
            FROM poker_users A 
            INNER JOIN poker_users B 
            ON A.id = B.referral 
            WHERE B.rake>$rakeforref
            ORDER BY id, ref_id) refs
        GROUP BY id, aff_rake";
            
        $temp = $sql->getAssocArray($q);
        
        foreach($temp as $user){
            $u = new User($user['id']);
            $u->points = self::getReferralRake($u) / $pointsperrake + $user['points'];
            $sql->query("UPDATE poker_users SET points={$u->points} WHERE id={$user['id']}");
        }
        return $temp;
    }
    
    public static function recalculateUserIncomes(){
        $users = UserMachine::getTrueAffiliates();
        $res = [];
        foreach($users as $i=>$u){
            $u->resetIncome($u->countAffiliatesRake());
            
            $res[] = [
                "user"=>$u->playername
                ,"pay"=>$u->chipsToPay()
                ];
            if($res[$i]['pay']>0){
                $u->payIncome();
            }
        }
        return $res;
    }
    
    public static function getReferralRake($user){
        $refs = $user->getReferrals();
        $sum = 0;
        
        foreach($refs as $u){
            if(!$user->level2){
                if($u->referral_level == 1){
                    $sum+=$u->rake;
                }else{
                    $sum+=$u->countAffiliatesRake();
                }
            }else{
                $sum+=$u->rake+$u->countAffiliatesRake(); 
            }
        }
        return $sum;
    }
    
}