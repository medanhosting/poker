<?php

    date_default_timezone_set("Asia/Beirut");

    if(!$root) $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root."/classes/Classes.php";
    
    
    $sql = new SQLConnection();
    
    // die();
    if(isset($_POST['Event']) && strtolower($_POST['Event'])=='tourneyfinish'){
        $files = Poker_Grabber::putTournaments();
        
        $name = $_POST['name'];
        $time = $_POST['time']; 
        $temp = $sql->getArray("SELECT * FROM poker_cache_tournaments WHERE name='$name' AND (restart_time>0 OR lateregminutes>0 OR entryfee>0)");

        $params = ["Name"=>$name];
        #creating same tournament via API
        if($temp[0]['restart_time']){
            $time = date("Y-m-d H:i",$time+60*$temp[0]['restart_time']);
            $params['StartTime'] = $time;
        }

        if($temp[0]['lateregminutes']){
            
            $params['LateRegMinutes'] = $temp[0]['lateregminutes'];
        }
        if($temp[0]['entryfee']){
            
            $params['EntryFee'] = $temp[0]['entryfee'];
        }

        $res = print_r(Poker_Tournaments::Offline(["Name"=>$name,"Now"=>"Yes"]),true)."\n";
        $res.= print_r(Poker_Tournaments::Edit($params),true)."\n";
        $res.= print_r(Poker_Tournaments::Online(["Name"=>$name]),true)."\n";

        file_put_contents("log","\n---\n".$_POST['time'].": Restarted tournament $name on $time \n".mysqli_error()."\n ",FILE_APPEND);

        if(Poker_Tickets::isTicketTournament($name)){
            foreach($files as $f){
                $tickets = Poker_Tickets::getTicketsOf($name);            
                foreach($tickets as $t){
                    $places = $t['places']*1;
                    $target = $t['tournament_for'];
                    $players = $f['places'];
                    
                    for($i=1; $i<=$places; $i++){
                        preg_match("/([^\s]*)\s.*/",$players[$i],$pname);
                        $pname=$pname[1];
                        
                        $res = Poker_Tournaments::Register(["Name"=>$target, "Player"=>$pname]);
                        $u=UserMachine::getUserByPlayerName($tpname);
                        UserMachine::trySendMessage($u, $m);
                        
                        // print_r($res);
                        file_put_contents("log","\n".date("Y-m-d H:i:s")."\nRegistered at ticket tournament $target player {$pname}", FILE_APPEND);
                    }
                }
            }
        }

    }
    #launching re-parsing to get new tournaments
   // $tournaments = Poker_Grabber::grabTournamentList();
    
    require "tournament_fees.php";
?>