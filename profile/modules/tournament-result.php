<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $tournamentId = $_GET['tournament_id'];

    $sql = new SQLConnection();
    $temp = $sql->getAssocArray("select * from poker_cache_tournament_results WHERE id = $tournamentId ORDER BY date DESC");

    $handData = $temp[0];
    echo "<hgroup><h2>Tournament Result: ".$handId."</h2></hgroup>";
    echo "<ul id='hands'>";
    
    foreach ($handData as $key => $value) {
        echo "<li>$key :  $value</li>";
    }
    echo "</ul>";
?>