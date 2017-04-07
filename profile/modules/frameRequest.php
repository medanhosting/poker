<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    $user = UserMachine::getCurrentUser();
    
    if(FrameRequests::hasRequest($user)){
        die(json_encode(array("status"=>"ERROR","message"=>"You have already sent a request!"),true));
    }
    
    if(FrameRequests::request($user)){
        die(json_encode(array("status"=>"OK","data"=>"Code request successfully sent!"),true));
    }else{
        die(json_encode(array("status"=>"ERROR","message"=>"An unexpected error happened. Please, try again a bit later. "),true));
    }