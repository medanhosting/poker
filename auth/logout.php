<?php
    
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    UserMachine::logoutCurrentUser();
    header("Location: /");
    die();