<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $amount = $_POST['amount']*1;
    
    $user = UserMachine::getCurrentUser();
   
    if($user->getAffilateBalance()*1 < $amount){
        die(json_encode(array("status"=>"ERROR","message"=>"You have less affiliate balance that you want to transfer!")));
    }
    
    if($amount<=0){
        die(json_encode(array("status"=>"ERROR","message"=>"You can't transfer negative or zero amount of affiliate balance!")));
    }

    $sql = new SQLConnection;
    $time = date('Y-m-d H:i:s');
    $sql->query("INSERT INTO `poker_player_rake` (`id`,`created_time`, `playername`, `amount`, `status`) VALUES (default,'$time','$user->playername',$amount,0)");

    die(json_encode(array("status"=>"OK")));

    // $res = Poker_Accounts::DecBalance(["Player"=>$user->playername,"Amount"=>$amount]);
    // if($res["Result"]=="Ok"){
    //     $user->balance = $res["Balance"];
    //     $user->submitChanges();
    // }else{
    //     die(json_encode(array("status"=>"ERROR","message"=>$res["Error"])));
    // }
    
    // $res = Poker_Accounts::IncBalance(["Player"=>$target->playername,"Amount"=>$amount]);
    
    // if($res["Result"]=="Ok"){
    //     $target->balance = $res["Balance"];
    //     $target->submitChanges();
    //     Poker_Transactions::chipsTransaction($user, $target, $amount);
    //     die(json_encode(array("status"=>"OK","data"=>$user->balance)));
    // }else{
    //     print_r($target);
    //     die(json_encode(array("status"=>"ERROR","message"=>$res["Error"])));
    // }