<hgroup>
    <h2>Tournament fees</h2>
    <p>Here are shown statistics about all previous and current tournaments.</p>
</hgroup>

<table id='tournaments'>
    
    <thead>
        <td>Tournament</td>
        <td>Start</td>
        <td>Stop</td>
        <td>Players</td>
        <td>Fee</td>
        <td>Total BuyIn</td>
        <td>Total Prize</td>
        
    </thead>
    
    <tbody>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
        
        $items = Poker_Cache::getTournamentResults();
        
        #print_r(Poker_Tournaments::Results(["Name"=>"Heads up", "Date"=>"2016-09-20"]));
        
        $totalFee = 0;
        $totalBuyIn = 0;
        
        file_put_contents('log',"1",FILE_APPEND);
       foreach($items as $data){

        if(Poker_Calculations::isTournamentAborted($data)){
            continue;
        }
        
        $fee = explode("+", $data['buyin']);
        $fee = $fee[1]*1;
        
        $rebuy = explode("+",$data['rebuycost']);
        $rebuy = $rebuy[1]*1;
        
        
        
        $dt="<p>Fee = Entrant*fee + (rebuy+addon)*rebuy fee</p>
        <p>Entrant = {$data['entrants']}</p>
        <p>Fee = $fee</p>
        <p>Rebuy =  {$data['rebuys']}</p>
        <p>Addon =  {$data['addons']}</p>
        <p>Rebuy fee = $rebuy</p>
        ";
        
        $dt= Poker_Calculations::tournamentFee($data);
        $tbn = Poker_Calculations::totalBuyIn($data);
        
        if(!$dt) continue;
        
        
        $pls = json_decode($data['places'],true);
        $sum = 0;
        $players = "";
        
        $fee = explode("+",$data["buyin"]);
        $fee = $fee[1];
        
        $rfee = explode("+",$data['rebuycost']);
        $rfee = $rfee[1];
        
        #$players.=print_r($pls, true);
        for($i=1; $i<=count($pls); $i++){
            $pl = $pls[$i];
            $pl['prize']*=1;
            
            $rebuy = $pl['rebuys']*1;
            $addon = $pl['addon']*1;
            
            #print_r($pl);
            
            #$f = "($fee + ($rebuy + $addon)*$rfee)=".($fee + ($rebuy + $addon)*$rfee);
            $f = ($fee + ($rebuy + $addon)*$rfee);
            
            $players.="<p>Place ".($i).": {$pl['name']} won {$pl['prize']}. Fee: $f</p>";
            $sum+=$pl["prize"]*1;
        }
        
        if($tbn - $sum == $dt){
            $sum = "<span class='ok'>$sum</span>";
        }else{
            $sum = "<span class='error'>$sum: unverified!</span><pre>".print_r($data, true)."</pre>";
        }
            $totalFee+=$dt;
            $totalBuyIn+=$tbn;
            
            echo "<tr>
                <td>{$data['name']}</td>
                <td class='date'>{$data['start']}</td>
                <td class='date'>{$data['stop']}</td>
                <td >$players</td>
                <td class='number'>$dt</td>
                <td class='number'>$tbn</td>
                <td>$sum</td>
               
            </tr>";
        }
        file_put_contents('log',"2",FILE_APPEND);
        echo "
            <tfoot>
                <td colspan='3'>Total</td>
                <td class='number'>Summary rake: ".(round(Poker_Calculations::getTotalRake()*100)/100)."</td>
                <td class='number'>$totalFee</td>
                <td class='number'>$totalBuyIn</td>
                <td colspan='1'></td>
            </tfoot>
        ";
    ?>
    </tbody>
</table>
<pre>
<?php
    #$stats = Poker_System::Balance([]);
    #print_r($stats);

?>

</pre>