<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    $user = UserMachine::getCurrentUser();
    $temp = Poker_Cache::getOpenEnabledTournaments();
    $fields = "Name,Status,Description,Auto,Game,Shootout,PW,Private,PermRegister,PermUnregister,PermObserve,PermPlayerChat,PermObserverChat,SuspendChatAllIn,Tables,Seats,StartFull,StartMin,StartCode,StartTime,RegMinutes,LateRegMinutes,MinPlayers,RecurMinutes,NoShowMinutes,BuyIn,EntryFee,PrizeBonus,MultiplyBonus,Chips,AddOnChips,TurnClock,TimeBank,BankReset,DisProtect,Level,RebuyLevels,Threshold,MaxRebuys,RebuyCost,RebuyFee,BreakTime,BreakLevels,StopOnChop,Blinds,Payout,UnregLogout";

    $tournamentList = Poker_Tournaments::_List(['Fields'=>$fields]); 

    $fields = explode(",",$fields);
    
    $temp=[];
    $counter = $tournamentList['Tournaments'];
    $sql = new SQLConnection();
    $existing = $sql->getArray("SELECT name FROM poker_cache_tournaments");
    $existing = array_map(function($el){return $el['name'];}, $existing);
    for($i = 0; $i < $counter; $i++){
        if(!in_array($data["Name"][$i], $existing)){
            $trn = [];
            $query=["default","default","default","default"];
            foreach($fields as $j=>$field){
                $trn[$field]=$data[$field][$i];
                $query[] = "'".addslashes($data[$field][$i])."'";
            }
            $query = implode(",",$query);
            $sql->query("INSERT INTO poker_cache_tournaments (id, point_fee, restart_time, point_enabled, ".implode(",",$lowerfields).") VALUES ($query)");
        }

        foreach ($tournamentList as $key => $value) {
            if ( strtolower($key) != 'result' && strtolower($key) != 'tournaments' && strtolower($key) != 'status') {
                $temp[$i][strtolower($key)] = $value[$i];
            }elseif (strtolower($key) == 'status') {

                preg_match("/registered:\s(\d+)\sof\s(\d+).*/i",$value[$i],$ar);
                #$v['seats'] = $ar[2]*1;
                $temp[$i]['freeseats'] = $ar[2]*1 - $ar[1]*1;
            }
        }
    }
    foreach($temp as $i=>$v){

        $accepted = UserMachine::isTournamentRegisteredLocal($v['name'],$user);
        $temp[$i]["accepted"] = $accepted ? 0 : 1;
        
        if(!$user){
            $temp[$i]["accepted"]=-1;
        }
        if($user){
            if($temp[$i]["accepted"]){
                // if($user->getPointBalance() < $temp[$i]["point_fee"]){
                //     $temp[$i]["accepted"] = -2;
                // }
                if(Poker_Calculations::isTournamentPlaying($temp['name'])){
                    if($temp[$i]['accepted']==0){
                        $temp[$i]['accepted'] = -3;    
                    }
                    
                }
            }
        }
    }
    
    die(json_encode(array("status"=>"OK","data"=>$temp)));