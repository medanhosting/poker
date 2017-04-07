<?php
    
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $user = UserMachine::getUserByPlayerName($_POST['user']);
    if(!$user){
        die(json_encode(["status"=>"ERROR","message"=>"User ".$_POST['user']." not found!"]));
    }
    $data = Poker_Transactions::IOTransactionList($user);
    
    die(json_encode(["status"=>"OK","data"=>$data]));