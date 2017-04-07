<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    Poker_Tickets::removeTicket($_POST['id']);
    
    if(mysqli_error()){
        die( json_encode( array("status"=>"ERROR", "message"=>mysqli_error())));
    }else{
        die( json_encode( array("status"=>"OK", "data"=>"")));
    }