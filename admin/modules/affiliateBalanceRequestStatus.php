<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    $sql = new SQLConnection;
    $transferData =  $sql->getArray("SELECT * FROM poker_users_transfer WHERE id = $_POST['id']");

    switch ($_POST['status']){
        case "accepted":{
            $res = $sql->query("UPDATE poker_users_transfer SET `status`= 1 WHERE id = $_POST['id']");
            if($res){
                die(json_encode(array("status"=>"OK","data"=>"<span class='stat accepted'>Accepted</span>")));
            }else{
                 die(json_encode(array("status"=>"ERROR","message"=>mysqli_error())));
            }
            break;
        }
        case "declined":{
            $res = $sql->query("UPDATE poker_users_transfer SET `status`= 2 WHERE id = $_POST['id']");
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