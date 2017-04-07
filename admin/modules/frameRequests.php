<div class='frameRequests'>
<h2>Frame Requests</h2>
<p>Here are located all requests from users to get provided with the iframe code for inserting game code to their site. You can accept or decline their requests here.</p>

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
            
            foreach(FrameRequests::_list() as $v){
                $user = new User($v['user']);
                switch($v['status']){
                    case FrameRequests::STATUS_WAITING:{
                        $status = "<span class='stat waiting'>Waiting</span>";
                        break;
                    }
                    
                    case FrameRequests::STATUS_ACCEPTED:{
                        $status = "<span class='stat accepted'>Accepted</span>";
                        break;
                    }
                    
                    case FrameRequests::STATUS_DECLINED:{
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

    