<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $id = $_POST['hand'];
    $data = Poker_Cache::getHand($id);
    if(!$data){
        die(json_encode(array("status"=>"ERROR", "message"=>"No hand found!")));
    }
    if(mysqli_error()){
        Logger::addReport("/admin/modules/getHand.php",Logger::STATUS_ERROR,mysqli_error());
        die(json_encode(array("status"=>"ERROR", "message"=>"Database error occured! ")));
    }
    die(json_encode(array("status"=>"OK", "data"=>$data)));