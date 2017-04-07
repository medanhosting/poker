<?php
    $x;
    set_time_limit(0);
    function formatT($d){
        global $x;
        $x+=(round($d*100000)/100);
        return (round($d*100000)/100)." ms";
    }
  /*  $root = "C:/inetpub/wwwroot/poker 1/";

    $_SERVER['DOCUMENT_ROOT']=$root;
    $_SERVER['SCRIPT_FILENAME']=$root."/cron/index.php";*/
    date_default_timezone_set("Asia/Beirut");
    
    require_once "../classes/Classes.php";
    Logger::addReport("Cron script",Logger::STATUS_INFO, "Timetable script proceed.");
    
    #tables are:
    file_put_contents("log","\n---\n".date("Y-m-d H:i:s").": Test server ".json_encode($_POST)." \n",FILE_APPEND);

    # Grabber should grab all hand history logs, and find ones that are:
    # 1) Are not present in local database
    # 2) Are for today's day
    // $t1 = microtime(true);
    // $files = Poker_Grabber::getHandHistoryList();
    // echo "<p><b>Poker_Grabber::getHandHistoryList() ".formatT(microtime(true)-$t1)."</b> </p>";
    // $i = 0;
    // $today = date('Y-m-d');
    // foreach($files as $file){
    //     # Then for each file grabber should collect from API file and put it under keys date and name in database, with a time this file was grabbed.
    //     if($today!==$file['Date'])
    //       continue;
    //     $t1 = microtime(true);
    //     $data = Poker_Grabber::grabFile($file);
    //     echo "<p><b>Poker_Grabber::grabFile() ".formatT(microtime(true)-$t1)."</b> </p>";
        
    //     echo "<h3>Grabbed file:</h3>";
    //     // print_r($file);
    //    /* if(mysqli_error()){
    //         echo "<p><b>Error occured:</b>".mysqli_error()."</p>";
    //     }*/
    //     $i++;
        
        
    //     #print_r($data);
    //     # All the new files are to be parsed to find out full hands and to put them to the database.
    //     $hands = Poker_Grabber::grabHands($data, $file);
    //     #print_r($hands);
    //     echo "<h4> Grabbed ".count($hands)." new hands.</h4>";
        
        
    // }
    
    $sql = new SQLConnection();
    if(isset($_POST['Event']) && strtolower($_POST['Event'])=='hand' && strtolower($_POST['Type'])=='ring'){
        $time = date('Y-m-d',strtotime($_POST['Time']));
        $handData = Poker_Logs::HandHistory(['Hand'=>$_POST['Hand']]);
        $rake=$pot=0;
        $players=[];

        foreach($handData['Data'] as $key=>$value ){
            if(strpos(strtolower(trim($value)),"** deck **")===0){
                $stats = $handData['Data'][$key-1];

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
            }
            
        }
        foreach($players as $player=>$bet){
            $sql->query("INSERT INTO `poker_cache_hands` (`id`, `date`, `hand_id`, `player_name`, `ring_name`, `player_rake`) VALUES (default, '$time', '{$_POST['Hand']}', '{$player}', '{$_POST['Name']}', '".($bet/$pot)*$rake."')");

            echo "INSERT INTO `poker_cache_hands` (`id`, `date`, `hand_id`, `player_name`, `ring_name`, `player_rake`) VALUES (default, '$time', '{$_POST['Hand']}', '{$player}', '{$_POST['Name']}', '".($bet/$pot)*$rake."')";

            $handSql = $sql->getArray("SELECT * FROM `poker_player_rake` WHERE `player_name`='{$player}'");
            if($handSql){
                $newRake = $handSql[0]['total_rake'] + ($bet/$pot)*$rake;
                $newRake = ceil($newRake);
                $sql->query("UPDATE `poker_player_rake` SET `total_rake` = {$newRake} WHERE `player_name`='{$player}'");

            }else{
                $newRake = ceil(($bet/$pot)*$rake);
                $sql->query("INSERT INTO `poker_player_rake` (`id`, `date`, `player_name`, `total_rake`) VALUES (default, '$time', '$player', '$newRake')");
            }
        }

    }      
   // file_put_contents("log","\n---\n".date("Y-m-d H:i:s").": sum rake player ".json_encode(Poker_Grabber::$rakeSum)." \n",FILE_APPEND);
    // die();
    
    $t1 = microtime(true);
    $file = Poker_Grabber::grabRingGames();
    echo "<h3>Grabbed ".count($file)." ring games</h3>";
    echo "<p><b>Poker_Grabber::grabRingGames() ".formatT(microtime(true)-$t1)."</b> </p>";
    
    $t0 = microtime(true);
    // $users = UserMachine::getallUsers();
    
    // foreach($users as $user){
    //     $t1 = microtime(true);
    //     Poker_Calculations::calculateTotalRakeFor($user);
    //     echo "<p><b>Poker_Grabber::calculateTotalRakeFor() ".(microtime(true)-$t1)."</b> </p>";
    // }
    //print_r(Poker_Calculations::calculateTotalRakes());
    
    Poker_Calculations::recalculateUserPoints();
    
    # Finding all affiliates and paying them difference in chips.
    # 
    #echo "<h3> Affiliate pays: </h3>";
    #print_r(Poker_Calculations::recalculateUserIncomes());
    
    echo "<p><b>Poker_Grabber::calculateTotalForAll: ".formatT(microtime(true)-$t0)."</b> </p>";
    
    
    
    $t1 = microtime(true);
    require_once "../cron/tournament.php";
    echo "<p><b>Tournaments: ".formatT(microtime(true)-$t1)."</b> </p>";
    
    #$tournaments = Poker_Grabber::grabTournamentList();
    #echo "<h3>Grabbed ".count($tournaments)." tournaments</h3>";
  
    echo "<p>Totally spent on calculations: $x ms</p>";
?>
</pre>