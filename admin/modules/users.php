<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $users = UserMachine::getUserPage($_POST['offset'], $_POST['step'], $_POST['name']);
    
    $res = [];
    foreach($users as $u){
        
        $balance = ($u->getRakeValue() + $u->tournaments_fee - $u->points_dec)*$u->comission;
        $ref = $u->getOwnerAffiliateName();
        $ref = $ref=="[None]" ? "<span class='weak'>[None]</span>":  $ref;
        $res[]= array(
            "id"=>$u->getId()
            ,"playername"=>$u->playername
            ,"realname"=>$u->realname
            ,"email"=>$u->email
            ,"rake"=>$u->getRakeValue()
            ,"fees"=>$u->tournaments_fee
            ,"freerolls"=>$u->points_dec
            ,"balance"=>$balance
            ,"points"=>$u->points
            ,"referrals"=>$u->getRealReferralsCount()
            ,"affiliate"=>$ref
        );
        
    }
    
    echo json_encode(array("status"=>"OK", "data"=>$res));