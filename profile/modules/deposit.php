<?php

require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
$user = UserMachine::getCurrentUser();
$amount = $_POST['amount']*1;

$res = Poker_Transactions::depositTransaction($user, $amount);

if($res){
    die(json_encode(array("status"=>"OK","data"=>$user->balance)));
}else{
    echo mysqli_error();
    die(json_encode(array("status"=>"ERROR", "message"=>"An error occured!")));
}