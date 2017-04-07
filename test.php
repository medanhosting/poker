<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $res = Poker_Tournaments::Unregister(["Name"=>"Heads up","Player"=>"PokerMaster"]);
    print_r($res);