<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/views/top.php";

?>
<!doctype html>
<html>
    <head>
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT']."/views/head.php";
        ?>
        
        <title> Play game </title>
        <link rel='stylesheet' href='/css/play.css'/>
        
        <script src='/js/play.js'></script>
    </head>
    
    <body>
        <?php  require_once $_SERVER['DOCUMENT_ROOT']."/views/header.php"; ?>
        
        <main>
            <?php
                $server = Poker_Variables::get('url_game_frame');

                
                $api = Poker_Accounts::SessionKey(array(
                    "Player"=>$user->playername
                    ));
                $key = $api['SessionKey'];
                
                if($key){
                    $src= "?LoginName={$user->playername}&SessionKey=$key";
                }
               
            ?>
           <iframe src='<?=$server?><?=$src?>'></iframe> 
        </main>
        
    
        <?php  require_once $_SERVER['DOCUMENT_ROOT']."/views/footer.php"; ?>
    </body>
</html>