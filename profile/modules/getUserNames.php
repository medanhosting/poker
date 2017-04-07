<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $users = UserMachine::searchUsersArray($_POST['text'], true);
    #print_r($users);
    die(json_encode(array("status"=>"OK","data"=>$users)));