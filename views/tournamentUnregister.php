<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    $user = UserMachine::getCurrentUser();
    
    $open = Poker_Cache::getOpenTournamentNames();
    if(!in_array($_POST['tournament'], $open)){
        die(json_encode(array("status"=>"error", "message"=>"Tournament has already started!".print_r($open, true))));   
    }
    
    $res = Poker_Tournaments::Unregister(["Name"=>$_POST['tournament'], "Player"=>$user->playername, "Negative"=>"Allow"]);
    UserMachine::tournamentUnregisterLocal($_POST['tournament'], $user);
    
    require_once $_SERVER['DOCUMENT_ROOT']."/cron/tournament.php";
    
    if(strtolower($res['Result'])=="error"){
        die(json_encode(array("status"=>"error", "message"=>print_r($res,true))));    
    }
    die(json_encode(array("status"=>"OK", "data"=>$res)));