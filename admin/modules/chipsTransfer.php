<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $user = new User($_POST['player']);
    $amount = $_POST['amount']*1;
    
    
    if($amount>0){
        $res = Poker_Accounts::IncBalance(["Player"=>$user->playername, "Amount"=>$amount]);
        if($res['Result']=="Ok"){
            $user->balance = $res['Balance']*1;
            $user->submitChanges();
            Poker_Transactions::chipsTransaction(NULL, $user, $amount);
            die(json_encode(array("status"=>"OK","data"=>$res['Balance'])));
        }else{
            die(json_encode(array("status"=>"ERROR","data"=>$res['Error'])));
        }
    }else{
        $amount = abs($amount);
        $res = Poker_Accounts::DecBalance(["Player"=>$user->playername, "Amount"=>$amount]);
        if($res['Result']=="Ok"){
            $user->balance = $res['Balance']*1;
            $user->submitChanges();
            Poker_Transactions::chipsTransaction(NULL, $user, -$amount);
            die(json_encode(array("status"=>"OK","data"=>$res['Balance'])));
        }else{
            die(json_encode(array("status"=>"ERROR","data"=>$res['Error'])));
        }
    }