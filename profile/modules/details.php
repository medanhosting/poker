<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $id = $_GET['id'];
    $user = new User($id);
    // $user->playername = 'SiSi';

    $currentPage = ($_GET['page']) ? $_GET['page'] : 1;
    #print_r($user);
    // echo "<script src='/js/detail.js'></script>";
    echo "<hgroup>
        <h2>Playing details for user {$user->playername}</h2>
        <p>Here you cans see details about how often your referral user play and how much money does he spend and you earn.</p>
    </hgroup>
    <ul class='nav'>
        <li><a href='' class='rakes active'>Rakes</a></li>
        <li><a href='' class='fees'>Tournament fees</a></li>
    </ul>
    ";
    
    echo "<div id='rakes'><table>
        <thead>
            <td>Date</td>
            <td>Ring game</td>
            <td>Rake</td>
            <td>Rake every </td>
            <td>Hand ID</td>
            <td>Player rake </td>
            <td></td>
        </thead>
    ";
    
    $total = Poker_Cache::countHandByPlayer($user->playername);
    
    $handData = Poker_Cache::getHandByPlayer($user->playername,($currentPage-1)*10);
    
    foreach($handData as $hand){
        $game = Poker_Cache::getRingGame($hand['ring_name']);
       
        echo "<tr>
            <td>{$hand['date']}</td>
            <td>{$hand['ring_name']}</td>
            <td>{$game['rake']}</td>
            <td>{$game['rakeevery']}</td>
            <td>{$hand['hand_id']}</td>
            <td>{$hand['player_rake']}</td>
            <td><a href='#' class='view' data-hand='$h' onClick='openHanHistory(\"".$hand['hand_id']."\",\"".$hand['date']."\",\"".$hand['ring_name']."\")'>View hand history</a>
                <div class='hand'>
                $handDetails
                </div>
            </td>
        </tr>";
        
    }
    
    echo "

        <tfoot>
            <td colspan='5'>Total</td>
            <td colspan='2'>$sum</td>
        </tfoot>
    </table>";
    $last = ceil($total['Total']/10);
    $links = 10; 
    $start      = ( ( $currentPage - $links ) > 0 ) ? $currentPage - $links : 1;
    $end        = ( ( $currentPage + $links ) < $last ) ? $currentPage + $links : $last;

    $html       = '<div class="pagination">';
 
    $class      = ( $currentPage == 1 ) ? "disabled" : "";
    $html       .= '<a href="#" onClick="pagination('.$id.','. ( $currentPage - 1 ).')">&laquo;</a>';
 
    if ( $start > 1 ) {
        $html   .= '<a href="#" onClick="pagination('.$id.',1)">1</a>';
        $html   .= '<a href="#" class="disabled"><span>...</span></a>';
    }
 
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $currentPage == $i ) ? "active" : "";
        $html   .= '<a class="'.$class.'"  onClick="pagination('.$id.','.  $i.')">' . $i . '</a>';
    }
 
    if ( $end < $last ) {
        $html   .= '<a href="#" class="disabled"><span>...</span></a>';
        $html   .= '<a onClick="pagination('.$id.','.  $last.')">' . $last . '</a>';
    }
 
    $class      = ( $currentPage == $last ) ? "disabled" : "";
    $html       .= '<a onClick="pagination('.$id.','.  ($currentPage+1) .')"" href="#">&raquo;</a>';
 
    $html       .= '</div>';

    echo $html;
    echo '</div>';

    echo "<table id='fees'>
        <thead>
            <td>Date</td>
            <td>Name</td>
            <td>Tournament Fee</td>
            <td>Freeroll Fee</td>
        </thead>
        
        <tbody>";
            
        $trs = Poker_Cache::getTournamentsOf($user);
        $sum = 0;
        $sumFee = 0;
        foreach($trs as $tr){
           # if($trs['buyin']!="0+0"){
               
                $sum+=$fee*1;

                $date = date("Y-m-d",strtotime($tr["date"]));
                $fees = Poker_Calculations::getTournamentFeeArray($tr);
                $freerolls = Poker_Calculations::getFreerollArray($tr);
                $fee = $fees[$user->playername];
                $freeroll = $freerolls[$user->playername];
                $sum+=$fee*1;
                $sumFee+=$freeroll*1;

                echo "<tr>
                    <td>$date</td>
                    <td><a onClick='viewTournamentResult({{$tr['id']}})' href='#''>{{$tr['name']}}</a></td>
                    <td>$fee</td>
                    <td>$freeroll</td>
                </tr>";
           # }
        }
    
    echo "
        <tr>
            <td colspan='2'>Total</td>
            <td>$sum</td>
            <td>$sumFee</td>
        </tr>
        </tbody>
    </table>
    ";
    
?>
<style>
    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
    }

    .pagination a.active {
        background-color: rgb(183, 8,25);
        color: white;
    }

    .pagination a:hover:not(.active) {background-color: #ddd;}
</style>
<script type="text/javascript">
    pagination = function(){
        alert("hihi");
    }
</script>