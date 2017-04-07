<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    #print_r($_POST);
    $user = new User($_POST['id']*1);
    
    $res = UserMachine::trySendMessage($user, $_POST['message']);
    switch($res){
        case UserMachine::MESSAGE_SENT:{
            die(json_encode(array("status"=>"OK","data"=>"Message successfully sent.")));
            break;
        }
        case UserMachine::MESSAGE_UNSENT:{
            die(json_encode(array("status"=>"ERROR","message"=>"An error occured while sending message.")));
        }
        case UserMachine::MESSAGE_NO_CONNECTION:
        default:
            {
            die(json_encode(array("status"=>"ERROR","message"=>"User is not connected to game.")));
        }
    }