<pre>
    <?php

    date_default_timezone_set("Europe/Minsk");
    
    if(!$root) $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root."/classes/Classes.php";
    
    $users = Poker_Grabber::grabNewUsers(true);
    print_r($users);
?>
</pre>