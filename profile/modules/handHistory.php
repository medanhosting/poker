<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $handId = $_GET['hand_id'];
    $date = $_GET['date'];
    $name = $_GET['name'];
    
    $handData = Poker_Logs::HandHistory(['Date'=>$date,'Name'=>$name]);
    echo "<hgroup><h2>Hand history: ".$handId."</h2></hgroup>";
    echo "<ul id='hands'>";
    $checkHand = false;
    for($i=0; $i<count($handData['Data']);$i++){
        $hand = $handData['Data'][$i];       
        if(strpos(trim($hand), $handId) !==false){
            $checkHand = true;
        }       
        if($checkHand){
            echo "<li>{$hand}</li>";
            if(strpos(strtolower(trim($hand)),"** deck **")===0){
                break;
            }
        }

    }
    echo "</ul>";
?>