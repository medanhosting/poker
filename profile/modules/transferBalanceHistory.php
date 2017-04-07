<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";

    echo "<hgroup><h2>Transfer history: </h2></hgroup>";
    echo "<div id='transfer'><table>
        <thead>
            <td>Date</td>
            <td>Amount</td>
            <td>Status</td>
        </thead>
    ";
    
    $transferHistorySql =  $sql->getArray("SELECT * FROM poker_users_transfer WHERE `playername`= '$this->playername' AND `status` = 1");
    if($transferHistorySql){
        foreach ($transferHistorySql as $v) {
            switch($v['status']){
                case 0:{
                    $status = "<span class='stat waiting'>Waiting</span>";
                    break;
                }
                
                case 1:{
                    $status = "<span class='stat accepted'>Accepted</span>";
                    break;
                }
                
                case 2:{
                    $status = "<span class='stat declined'>Declined</span>";
                    break;
                }
                
                default:
                    $status = "<span class='stat unknown'>Unknown</span>";
            }
            echo "<tr data-id='{$v['id']}'>
                    <td>{$v['created_time']}</td>
                    <td>{$v['amount']}</td>
                    <td class='st'>$status</td>
                </tr>";
        }
    }
    echo "</table>";
?>