<div class='affiliateRequests'>
<h2>Affiliate Requests</h2>
<p>Here are displayed all players' requests to become an affiliate and start earning real money instead of points!</p>

<table>
    <thead>
        <td>Player name</td>
        <td>Request datetime</td>
        <td>Actions</td>
        <td>Status</td>
    </thead>
    
    <tbody>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
            
            foreach(AffiliateRequests::_list() as $v){
                $user = UserMachine::getUserByPlayerName($v['user']);
                switch($v['status']){
                    case AffiliateRequests::STATUS_WAITING:{
                        $status = "<span class='stat waiting'>Waiting</span>";
                        break;
                    }
                    
                    case AffiliateRequests::STATUS_ACCEPTED:{
                        $status = "<span class='stat accepted'>Accepted</span>";
                        break;
                    }
                    
                    case AffiliateRequests::STATUS_DECLINED:{
                        $status = "<span class='stat declined'>Declined</span>";
                        break;
                    }
                    
                    default:
                        $status = "<span class='stat unknown'>Unknown</span>";
                }
                echo "<tr data-id='{$v['id']}'>
                        <td>{$user->playername}</td>
                        <td>{$v['created']}</td>
                        <td>
                            <input type='button' class='accept' value='+'/> 
                            <input type='button' class='decline' value='-'/>
                        </td>
                        <td class='st'>$status</td>
                    </tr>";
            }
        ?>
    </tbody>
</table>

</div>
<?php

    