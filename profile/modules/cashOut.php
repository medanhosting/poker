<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $user = UserMachine::getCurrentUser();
    
    if(!$user){
        die(json_encode(array("status"=>"ERROR", "message"=>"You seem to have log out before request cash out!")));
    }
    
    $amount = $_POST['sum']*1;
    $method = $_POST['method'];
    
    if($amount <=0) {
        die(json_encode(array("status"=>"ERROR", "message"=>"You can't cash out negative or zero amount of chips!")));
    }
    
    if($amount >$user->balance ) {
        die(json_encode(array("status"=>"ERROR", "message"=>"You can't cash out more than you have!")));
    }
    
    $res = Poker_Transactions::cashOut($user, $method, $amount);
    if($res===FALSE){
        die(json_encode(array("status"=>"ERROR", "message"=>"An error occured while request!")));
    }else{
        die(json_encode(array("status"=>"OK", "data"=>$res)));
    }