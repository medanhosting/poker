<?php
    
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $res = Poker_Transactions::depositTransactionAmount($_POST['id'], $_POST['amount']);
    if($res){
        die(json_encode(array("status"=>"OK", "date"=>"")));
    }
    echo mysqli_error();
    die(json_encode(array("status"=>"ERROR", "message"=>"")));