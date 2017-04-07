<?php
    
require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $id = $_POST['id'];
    
    $user = new User($id);
    $refs = $user->getReferrals();
    
    $result = array_map(function($el){
        return array("name"=>$el->playername, "id"=>$el->getId(), "rake"=>$el->getRake(), "email"=>$el->email);
    },$refs);
    
    echo json_encode(array("status"=>"OK","data"=>$result));