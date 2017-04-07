<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $id = $_POST['id'];
    $user = new User($id);
    
    $user->playername = $_POST['playername'];
    $user->realname = $_POST['realname'];
    $user->email = $_POST['email'];
    $user->level2 = $_POST['level2'];
    $user->comission = $_POST['comission']*1;
    $user->level2_comission = $_POST['level2_comission']*1;
    $user->link2_commission = $_POST['link2_commission']*1;
    
    $user->submitChanges();
    
    if(!mysqli_error()){
        die(json_encode(array("status"=>"OK","data"=>"Changes saved successfully")));
    }else{
        die(mysqli_error());
    }
    