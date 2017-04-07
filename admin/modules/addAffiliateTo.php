<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
$ref = new User($_POST['ref']);
    $ref->referral = $_POST['id'];
    $ref->submitChanges();
    
    echo mysqli_error();
    die(json_encode(array("status"=>"OK","data"=>"OK")));