<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $user = new User($_POST['ref']);
    $user->referral = 0;
    $user->submitChanges();
    
    if(!mysqli_error()){
        die(json_encode(array("status"=>"OK","data"=>"OK")));
    }else{
        die(mysqli_error());
    }