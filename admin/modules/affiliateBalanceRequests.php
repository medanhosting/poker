<div class='affiliateRequests'>
<h2>Affiliate Balance Requests</h2>
<p>Here are displayed all players' tranfer balance requests to become an affiliate and start earning real money instead of points!</p>

<table>
    <thead>
        <td>Player name</td>
        <td>Request datetime</td>
        <td>Amount</td>
        <td>Affilate Balance</td>
        <td>Actions</td>
        <td>Status</td>
    </thead>
    
    <tbody>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
            $sql = new SQLConnection;

            $transferHistorySql =  $sql->getArray("SELECT * FROM poker_users_transfer");
            if($transferHistorySql){
                foreach ($transferHistorySql as $v) {
                    $user = UserMachine::getUserByPlayerName($v['playername']);
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
                            <td>{$v['playername']}</td>
                            <td>{$v['created_time']}</td>
                            <td>{$v['amount']}</td>
                            <td>{$user->getAffilateBalance()}</td>
                            <td>
                                <input type='button' class='accept' value='+'/> 
                                <input type='button' class='decline' value='-'/>
                            </td>
                            <td class='st'>$status</td>
                        </tr>";
                }
            }
        ?>
    </tbody>
</table>

</div>
<?php

    