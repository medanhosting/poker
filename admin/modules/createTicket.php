<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $res = Poker_Tickets::createTicket(array("tournament"=>$_POST['tournament'], "places"=>$_POST['places']*1, "for"=>$_POST['tournament_for']));
    switch($res){
        case Poker_Tickets::ERROR_TICKET_EXISTS:{
            die(json_encode(array("status"=>"ERROR","message"=>"This ticket already exists!")));
            break;
        }
        case Poker_Tickets::ERROR_DB_ERROR:{
            echo mysqli_error();
            die(json_encode(array("status"=>"ERROR","message"=>"System error occured")));
            break;
        }
        case Poker_Tickets::ERROR_NO_ERROR:{
            die(json_encode(array("status"=>"OK","data"=>"Ticket successfully created!")));
            break;
        }
        default:{
            die(json_encode(array("status"=>"ERROR","message"=>"System error occured")));
        }
    }