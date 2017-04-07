<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    if(!UserMachine::isUserByPlayerName($_POST['player'])){
        die(json_encode(array("status"=>"ERROR","message"=>"No user with this player name found!")));
    }
    $target = UserMachine::getUserByPlayerName($_POST['player']);
    $amount = $_POST['amount']*1;
    
    $user = UserMachine::getCurrentUser();
    
    if($user->getId() == $target->getId()){
        die(json_encode(array("status"=>"ERROR","message"=>"You cannot transfer chips to yourself!")));
    }
    
    if($user->balance*1 < $amount){
        die(json_encode(array("status"=>"ERROR","message"=>"You have less chips that you want to transfer!")));
    }
    
    if($amount<=0){
        die(json_encode(array("status"=>"ERROR","message"=>"You can't transfer negative or zero amount of chips!")));
    }
    
    $res = Poker_Accounts::DecBalance(["Player"=>$user->playername,"Amount"=>$amount]);
    if($res["Result"]=="Ok"){
        $user->balance = $res["Balance"];
        $user->submitChanges();
    }else{
        die(json_encode(array("status"=>"ERROR","message"=>$res["Error"])));
    }
    
    $res = Poker_Accounts::IncBalance(["Player"=>$target->playername,"Amount"=>$amount]);
    if($res["Result"]=="Ok"){
        $target->balance = $res["Balance"];
        $target->submitChanges();
        Poker_Transactions::chipsTransaction($user, $target, $amount);
        die(json_encode(array("status"=>"OK","data"=>$user->balance)));
    }else{
        print_r($target);
        die(json_encode(array("status"=>"ERROR","message"=>$res["Error"])));
    }