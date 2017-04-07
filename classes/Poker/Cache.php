<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";


class Poker_Cache{
    
    public static function getHandFile($name, $date){
    
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT * FROM ".Poker_Grabber::HAND_HISTORY_TABLE." WHERE name='$name' AND `date`='$date 00:00:00'");
        if(count($temp)){
            Logger::addReport("Poker Cache",Logger::STATUS_INFO,"Got hand history file from cache: $name / $date");
            return array("Result"=>"Ok","Data"=>json_decode($temp[0]['data'],true));
        }
        else return null;
    }
    
    public static function getHandHistory($till="0000-00-00 00:00:00"){
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT name, `date` FROM ".Poker_Grabber::HAND_HISTORY_TABLE." WHERE `date`>='$till'");
        $result = [
            "Result"=>"Ok"
            ,"Files"=>count($temp)
            ,"Date"=>[]
            ,"Name"=>[]
            ];
        foreach($temp as $i=>$v){
            $d = $temp[$i]["date"];
            $d = explode(" ",$d);
            $result["Date"][$i]=$d[0];
            $result["Name"][$i]=$temp[$i]["name"];
        }
        
        return $result;
    }
    
    
    public static function getHandHistoryGameNames(){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT DISTINCT name FROM ".Poker_Grabber::HAND_HISTORY_TABLE." WHERE type=".Poker_Grabber::TYPE_GAME);
        
        $res = [];
        foreach($temp as $i=>$v){
            $res[]=$temp[$i][0];
        }
        
        return array("Result"=>"Ok","Name"=>$res);
        
    }
    
    public static function getRingGame($name){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT * FROM poker_cache_ringgames WHERE name='$name'");
        
        return $temp[0];
        
        
    }

    public static function getListRingGame(){
         $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT * FROM poker_cache_ringgames ");
        
        return $temp;
    }
    
    public static function getHand($id){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT * FROM poker_cache_hands WHERE hand='$id'");
        
        return $temp[0];
    }

    public static function getHandByPlayer($player,$offset=0){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT * FROM poker_cache_hands WHERE `player_name`='$player' ORDER BY `date` DESC LIMIT $offset, 10");
        return $temp;
    }
    
    public static function countHandByPlayer($player){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT count(*) as Total FROM poker_cache_hands WHERE `player_name`='$player'");
        return $temp['0'];
    }

    public static function getTournamentList(){
        $sql = new SQLConnection;
        $temp = $sql->getAssocArray("SELECT * FROM poker_cache_tournaments");
        
        return $temp;
    }
    
    public static function getTournamentByName($name){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT * FROM poker_cache_tournaments WHERE LOWER('$name') = LOWER('name')");
        
        return $temp[0];
    }
    
    
    public static function getTournamentResults(){
        $sql = new SQLConnection;
        $temp = $sql->getAssocArray("select * from poker_cache_tournament_results order by stop desc");
        
        return $temp;
    }
    
    public static function getZeroBuyInTournaments(){
        $sql = new SQLConnection;
        $temp = $sql->getAssocArray("select * from poker_cache_tournament_results where buyin='0+0' order by date desc");
        
        return $temp;
    }
    
    /**
        returns an array of tournaments in which user $user took part
    */
    public static function getTournamentsOf($user){
        $sql = new SQLConnection();
        $name = $user->playername;
        $temp = $sql->getAssocArray("select * from poker_cache_tournament_results WHERE places LIKE '%\"$name\"%' ORDER BY date DESC");
        return $temp;
    }
    
    public static function getTournamentsByQuery($q){
        $sql = new SQLConnection();
        
        $temp = $sql->getAssocArray($q);

        
        $res = [];
        foreach($temp as $i=>$v){
            $st = $v['status'];
            if(strpos(strtolower($st), "registered")===FALSE){
                continue;
            }
            preg_match("/registered:\s(\d+)\sof\s(\d+).*/i",strtolower($st),$ar);
            #$v['seats'] = $ar[2]*1;
            $v['freeseats'] = $ar[2]*1 - $ar[1]*1;
            
            if($v['freeseats']!=0){
                $res[]=$v;
            }
        }

        return $res;
    }
    public static function getOpenTournaments(){
        return self::getTournamentsByQuery("SELECT * FROM poker_cache_tournaments");
        
    }
    
    public static function getOpenEnabledTournaments(){
         return self::getTournamentsByQuery("SELECT * FROM poker_cache_tournaments WHERE point_enabled>0");
    }
    
    public static function getOpenTournamentNames(){
        $sql = new SQLConnection();
        $temp = $sql->getAssocArray("SELECT * FROM poker_cache_tournaments");
        
        $res = [];
        foreach($temp as $i=>$v){
            $st = $v['status'];
            if(strpos(strtolower($st), "registered")===FALSE){
                continue;
            }
            preg_match("/registered:\s(\d+)\sof\s(\d+).*/i",strtolower($st),$ar);
            #$v['seats'] = $ar[2]*1;
            $v['freeseats'] = $ar[2]*1 - $ar[1]*1;
            
            if($v['freeseats']!=0){
                $res[]=$v['name'];
            }
        }
        
        return $res;
    }
    

}