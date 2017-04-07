<?php
    
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $id = $_POST["id"];
    $user = new User($id);
    
    $data = array(
        "realname"=>$user->realname
        ,"playername"=>$user->playername
        ,"email"=>$user->email
        ,"comission"=>$user->comission
        ,"level2_comission"=>$user->level2_comission
        ,"level2"=>$user->level2
        ,"link2_commission"=>$user->link2_commission 
        ,"referrals"=>[]
        ,"balance"=>$user->balance*1
    );
        
    
    
    echo(json_encode(array("status"=>"OK","data"=>$data)));