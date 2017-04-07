<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/views/top.php";
    $cookie = "918462935623654682";
    if(isset($_POST['login'])){
        if($_POST['login']=="admin" && $_POST["password"]="1604"){
            setcookie("adssid",$cookie,time()+86400,"/");
            $_COOKIE['adssid']=$cookie;
        }else{
            $status = "<p class='status'><i class='error'>Incorrect login or password!</i></p>";
        }
    }
?>

<!doctype html>
<html>
    <head>
        <?php require_once $_SERVER['DOCUMENT_ROOT']."/views/head.php";?>
        
        <title>Administration page</title>
        <link rel='stylesheet' href='/css/admin.css' />
        <script src='/js/admin.js'></script>
    </head>
    
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT']."/views/header.php";?>
        <main>
            <?php 
                if ($_COOKIE['adssid']!=$cookie){
                    require_once $_SERVER['DOCUMENT_ROOT']."/admin/form.php";
                }else{
                    require_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.php";
                }
            ?>
            
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT']."/views/footer.php";?>
    </body>
</html>