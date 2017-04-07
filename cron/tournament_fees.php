<?php

    date_default_timezone_set("Europe/Minsk");
    
    if(!$root) $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root."/classes/Classes.php";
    
    $users = [];
    $freeroll = [];
    $files = Poker_Cache::getTournamentResults();   
    // echo "<pre>";print_r($files);die();
    foreach($files as $file){
        $data = Poker_Calculations::getTournamentFeeArray($file);
        $dataFreeroll =  Poker_Calculations::getFreerollArray($file);
        foreach($data as $u => $v){
            if(!isset($users[$u])){
                $users[$u]=0;
            }
            $users[$u] += $v*1;
        }

        foreach($dataFreeroll as $u => $v){
            if(!isset($freeroll[$u])){
                $freeroll[$u]=0;
            }
            $freeroll[$u] += $v*1;
        }
    }
    $sql = new SQLConnection;
    
    $sql->query("UPDATE poker_users SET tournaments_fee = 0");
    foreach($users as $u=>$v){
        $sql->query("UPDATE poker_users SET tournaments_fee = $v WHERE name='$u'");
    }

    $sql->query("UPDATE poker_users SET points_dec = 0");
    foreach($freeroll as $u=>$v){
        $sql->query("UPDATE poker_users SET points_dec = $v WHERE name='$u'");
    }