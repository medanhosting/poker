<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $user = new User($_POST['id']);
    
    $res = $user->getReferralsArray();
    echo mysqli_error();
    
    die(json_encode(array("status"=>"OK","data"=>$res)));