<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    switch ($_POST['status']){
        case "accepted":{
            $res = AffiliateRequests::accept($_POST['id']);
            if($res){
                die(json_encode(array("status"=>"OK","data"=>"<span class='stat accepted'>Accepted</span>")));
            }else{
                 die(json_encode(array("status"=>"ERROR","message"=>mysqli_error())));
            }
            break;
        }
        case "declined":{
            $res = AffiliateRequests::decline($_POST['id']);
            if($res){
                die(json_encode(array("status"=>"OK","data"=>"<span class='stat declined'>Declined</span>")));
            }else{
                 die(json_encode(array("status"=>"ERROR","message"=>mysqli_error())));
            }
            break;
        }
        default:{
            die(json_encode(array("status"=>"ERROR","message"=>"No such status found!")));
        }
        
    }