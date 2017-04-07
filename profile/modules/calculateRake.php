<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $ids = explode(",",$_POST['id']);
    
    $output = [];
    
    foreach($ids as $id){
        $user = new User($id);
        $data = "";
        $output[$id]="<span class='result'>".Poker_Calculations::calculateTotalRakeFor($user)."</span> | <a href='#' data-id='{$user->getId()}'>Details</a>  <div class='data'>$data</div>";
        
    }
    
    die(json_encode(array("status"=>"ok","data"=>$output),JSON_UNESCAPED_UNICODE));