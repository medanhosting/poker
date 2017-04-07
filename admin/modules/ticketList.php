<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    $tickets = Poker_Tickets::getTickets();
    
    die(json_encode(array("status"=>"OK","data"=>$tickets)));
?>
