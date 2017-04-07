<hgroup>
    <h2>Cash out requests</h2>
    <p>Here are shown all cash out requests. You should accept request when deposite is done or decline if you don't want to withdraw chips for this player.</p>
</hgroup>
<?php require $_SERVER['DOCUMENT_ROOT']."/admin/modules/history.php"; ?>
<table id='cashouts'>
    <thead>
        <td>Date</td>
        <td>Player</td>
        <td>Amount</td>
        <td>Chips left</td>
        <td>Player rake</td>
        <td>Status</td>
        <td>Actions</td>
    </thead>    
    
    <tbody>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
            $tr = Poker_Transactions::cashOutTransactions();
            foreach($tr as $t){
                $user = UserMachine::getUserByPlayerName($t['user']);
                $btns = "";
                $editbtn = "";
                switch ($t['status']){
                    case Poker_Transactions::CASHOUT_PENDING:{
                        $status = "<span>Pending</span>";
                        $btns = "<input type='button' class='accept' />
                            <input type='button' class='decline' />";
                            $editbtn = "<input type='button' class='editAmount' />";
                        break;
                    }
                    case Poker_Transactions::CASHOUT_ACCEPTED:{
                        $status = "<span class='accepted'>Accepted</span>";
                        break;
                    }
                    case Poker_Transactions::CASHOUT_DECLINED:{
                        $status = "<span class='declined'>Declined</span>";
                        break;
                    }
                }
                echo "
                    <tr data-id='{$t['id']}'>
                        <td>{$t['date']}</td>
                        <td><span class='user'>{$t['user']}</span><input type='button' class='history' /></td>
                        <td><span class='number'>{$t['amount']}</span> $editbtn</td>
                        <td>{$user->balance}</td>
                        <td>{$user->getRakeValue()}</td>
                        <td class='stat'>$status</td>
                        <td class='buttons'>
                            $btns
                        </td>
                    </tr>
                ";
            }
        ?>
    </tbody>
</table>


<?php
    

    
    