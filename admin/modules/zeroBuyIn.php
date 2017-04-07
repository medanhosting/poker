<hgroup>
    <h2>Fees for affiliate</h2>
    <p>Here are displayed tournaments with zero buyin and player fees.</p>
</hgroup>

<table>
    <thead>
        <td>Date</td>
        <td>Tournament</td>
        <td>Player name</td>
        <td>Fee</td>
    </thead>
    <tbody>
<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    $trn = Poker_Cache::getZeroBuyInTournaments();
    
    foreach($trn as $t){
        $players = json_decode($t['places'], true);
        
        $sum=0;
        foreach($players as $p){
            $sum +=$p['prize']*1;
        }
        foreach($players as $p){
            echo "<tr>
                <td>".date("Y-m-d",strtotime($t['date']))."</td>
                <td>{$t['name']}</td>
                <td>{$p['name']}</td>
                <td>".($sum/count($players))."</td>
            </tr>";
        }
    }
    #print_r($trn);
?> 
    </tbody>
</table>