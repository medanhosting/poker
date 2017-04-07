<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    $user = UserMachine::getCurrentUser();
    
    if(AffiliateRequests::hasRequest($user)){
        die(json_encode(array("status"=>"ERROR","message"=>"You have already sent a request!"),true));
    }
    
    if(AffiliateRequests::request($user)){
        die(json_encode(array("status"=>"OK","data"=>"Request successfully sent!"),true));
    }else{
        die(json_encode(array("status"=>"ERROR","message"=>"An unexpected error happened. Please, try again a bit later. "),true));
    }