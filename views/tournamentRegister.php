<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    $user = UserMachine::getCurrentUser();
    
    $res = Poker_Tournaments::Register(["Name"=>$_POST['tournament'], "Player"=>$user->playername, "Negative"=>"Allow"]);
    UserMachine::tournamentRegisterLocal($_POST['tournament'], $user);
    
    require_once $_SERVER['DOCUMENT_ROOT']."/cron/tournament.php";
    
    if(strtolower($res['Result'])=="error"){
        die(json_encode(array("status"=>"error", "message"=>"You already registered!")));    
    }
    die(json_encode(array("status"=>"OK", "data"=>$res)));