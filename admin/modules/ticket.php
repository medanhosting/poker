<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    $tickets = Poker_Tickets::getTickets();
?>

<hgroup>
    <h2>Ticket tournaments</h2>
    <p>Set here tournaments, winning in which for first N players will open participation in another tournament.</p>
</hgroup>

<form id='createTicket'>
    <label>
        <span>First </span>
        <input type='number' value='1' min='1' max='100' step='1' id='ticket_places'/>
        <span>places </span>
    </label>
    <label>
        <span>in tournament </span>
        <select id='ticket_tournament'>
            <?php
                $trs = Poker_Tickets::getTournamentNames();
                foreach($trs as $name){
                    echo "<option value='{$name}'> $name </option>";
                }
            ?>
            <option disabled>None</option>
        </select>
    </label>
    <label>
        <span>will get ticket for tournament </span>
        <select id='ticket_for'>
            <option disabled>None</option>
            <?php
                $trs = Poker_Tickets::getTournamentNames();
                foreach($trs as $name){
                    echo "<option value='{$name}'> $name </option>";
                }
            ?>
        </select>
    </label>
    <label><input type='submit' id='saveTicket' class='button' value='Create'/> </label>
    <p class='status' id='ticketStatus'> </p>
</form>


<table id='tickets'>
    <thead>
        <td>Tournament</td>
        <td>First places</td>
        <td>Ticket for</td>
        <td></td>
    </thead>
    
    <tbody>
    <template id='ticket_template'>
            <tr data-ticket='{{id}}'>
                <td>{{tournament}}</td>
                <td>{{places}}</td>
                <td>{{tournament_for}}</td>
                <td class='actions'>
                    <input type='button' value='X' class='removeTicket' />
                </td>
            </tr>
    </template>    
<?php
    
    foreach($tickets as $t){
        echo "
            <tr data-ticket='{$t['id']}'>
                <td>{$t['tournament']}</td>
                <td>{$t['places']}</td>
                <td>{$t['tournament_for']}</td>
                <td class='actions'>
                    <input type='button' value='X' class='removeTicket' />
                </td>
            </tr>
        ";
    }
?>        

    </tbody>
</table>
