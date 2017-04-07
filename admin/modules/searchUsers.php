<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $res = UserMachine::searchUsersArray($_POST['name']);
    if(!mysqli_error()){
        die(json_encode(array("status"=>"OK", "data"=>$res)));
    }else{
        die(json_encode(array("status"=>"ERROR", "message"=>mysqli_error())));
    }