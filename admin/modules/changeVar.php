<?php
    
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $res = Poker_Variables::set($_POST['variable'],$_POST['value']);
    require "recalculate.php";
    
    if($res){
        die(json_encode(array("status"=>"OK","data"=>"")));
    }else{
        die(json_encode(array("status"=>"ERROR","message"=>mysqli_error())));
    }