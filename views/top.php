<?php
    if($_GET['ref']){
        setcookie("ref",$_GET['ref'],time()+7*86400,"/");
        $_COOKIE['ref']=$_GET['ref'];
    }
    
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
?>