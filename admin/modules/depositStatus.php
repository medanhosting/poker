<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
$rq = $_POST['id']*1;
$st = $_POST['status']*1;

switch($st){
    case 1:{
        $status = Poker_Transactions::DEPOSIT_ACCEPTED;
        $result = "<span class='accepted'>Accepted</span>";
        break;
    }
    case -1:
    default:{
        $status = Poker_Transactions::DEPOSIT_DECLINED;
        $result = "<span class='declined'>Declined</span>";
    }
}
    Poker_Transactions::depositTransactionStatus($rq, $status);
    echo mysqli_error();
    die(json_encode(array("status"=>"OK", "data"=>$result)));
