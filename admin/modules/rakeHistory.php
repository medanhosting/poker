<div class='rakeHistory'>
    <hgroup>
        <h2>Rake history</h2>
        <p>Here are displayed rakes for today's games.</p>
    </hgroup>
    
    <div>
        <div id='rakeHistoryHand' class='popup'>
            <div class='wrap'>
                
            </div>
        </div>
        <table>
            <thead>
                <td>Date</td>
                <td>Name</td>
                <td>Data</td>
            </thead>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
            
            function toHTML($array){
                $res = "<div class='summary'>";
                foreach($array as $k=>$v){
                    $res.="<p><span>$k</span> : <span class='value'>$v</span></p>";
                }    
                return $res."</div>";
            }
            
            function proceed($history,$data){
               
                $rakes = "<ul>";
                #$rakeVals = Poker_RingGames::Get(["Name"=>$data[1]]);
                #$rakeVals = array("Rake"=>$rakeVals["Rake"],"RakeEvery"=>$rakeVals["RakeEvery"],"RakeMax"=>$rakeVals["RakeMax"]);
                
                
                $flop = FALSE;
                $playerRakes = [];
                foreach($history as $v){
                    if(strpos(strtolower($v),"** flop")===0){
                        $flop= TRUE;
                    }
                    if(strpos(strtolower($v),"rake ")===0){
                        
                        
                        $players = explode("Players ",$v);
                        $players = trim($players[1]);
                        $players = str_replace(["(",")"],"",$players);
                        $players = explode(", ",$players);
                        
                        # $pot - pot value for this hand
                        $pot=[];
                        preg_match("/Pot\s\(([\d]+\))/",$v,$pot);
                        $pot = intval($pot[1]);
                         
                        # $r - rake value for this hanв
                        $r = [];
                        preg_match("/Rake\s\(([\d]+\))/",$v,$r);
                        $r = intval($r[1]);
                        
                        $pl = [];
                        foreach($players as $p){
                            $p = trim($p);
                            $p = explode(":",$p);
                            $pl[trim($p[0])] = trim($p[1]);
                        }
                        $players = $pl;
                        $sumrake = 0;
                        
                        $output="";
                        foreach($players as $p=>$val){
                            #$val = player bet in this hand
                            
                            #$players[$p] = ($val/$rakeVals["RakeEvery"])*$rakeVals["Rake"];
                            $players[$p] = $r*$val/$pot;
                            #$output.="$p -  $r*$val/$pot=(".($r*$val/$pot).") ; ";
                            
                            $sumrake+=$players[$p];
                            if($flop) $playerRakes[$p]+=$players[$p];
                        }
                        
                        
                        
                        $sumrake = ($sumrake == floatval($r)) ? "TRUE" : "FALSE";
                        $rakes.= ($flop ? "<p class='desc'>$v</p>$output<h5>Rakes are following:</h5>".toHTML($players)."<p>Verification:"."$sumrake</p>" : $v."<p><b>There were no flop! Rake is ignored for this hand!</b></p>")."</li>" ;
                        $flop = FALSE;
                    }else{
                        #Hand title 
                        
                        if(strpos(strtolower($v),"hand")===0){
                            
                            preg_match('/#(\d+)/',$v, $hnd);
                            $hnd = intval($hnd[1]);
                            $rakes.="<li data-hand='$hnd'><h4>$v</h4> ";  
                        } 
                    }
                }
                
                $rakes.="<li><h3>Summary rakes:</h3>".toHTML($playerRakes)."</li></ul>";
                
                
                echo "<tr>
                    <td>{$data[0]}</td>
                    <td>{$data[1]}</td>
                    <td>$rakes</td>
                </tr>";
            }
            
            
            # grab all hand histories
            
            #$histories = Poker_Logs::HandHistory([]);
            $histories = Poker_Cache::getHandHistory();
            //print_r($histories);
            
            #for each hand history grab players and show rakes.
            $count= 0;
            
            #grabbing games to furhter check if our file corresponds to game, not to tournament
            #$games = Poker_RingGames::_List(["Fields"=>"Name"]); 
            
            $games = Poker_Cache::getHandHistoryGameNames();
            $games = $games["Name"];
            
            foreach($histories["Date"] as $i=>$v){
                
                $ts = strtotime($v." 00:00:00");
                $cts = strtotime(date("Y-m-d ")."00:00:00");
                
                #echo ":".$v." ".strtotime($v." 00:00:00")."-".strtotime(date("Y-m-d ")."00:00:00")."  ".($cts-$ts)."<br/>";
                
                #We ger only hand hostories for today's day.
                if(($cts-$ts)>0) continue;
                $count++;
                
                if(!in_array($histories["Name"][$i],$games)) continue;
                $history=Poker_Cache::getHandFile($histories["Name"][$i], $v);
                #$history = Poker_Logs::HandHistory(array("Date"=>$v,"Name"=>$histories["Name"][$i]));
                
                
                proceed($history["Data"],array($histories["Date"][$i],$histories["Name"][$i]));
            }
            
        ?>
        </table>
    </div>
</div>