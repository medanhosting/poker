<hgroup>
    <h2>Manage current tournaments</h2>
    <p>On this page you may manage current tournaments to reset it's entry fee.</p>
</hgroup>
<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";

    $sql = new SQLConnection;
    $temp = $sql->getArray("SELECT * FROM cata_settings_vars WHERE `key`='show_entry_fee'");
    $check = 0;
    if($temp){
        $check = $temp[0]['value'];
    }
?>
<table>
    <tr>
        <td colspan='5'>
            <label>
                <input type='checkbox'  class='enabled enableentrypoint' value="1" <?= ($check) ? 'checked' : ''?> /> Show Entry point fees
            </label>
        </td>
        <td>
            <input type='submit' value='Change' class='editentryfee button' data-tournament='423'/>
        </td>
    </tr>
</table>
<table id='tournamententries'>
    <thead>
        <td>Tournament</td>
        <td>Entry point fees</td>
        <td>Late registration</td>
        <td>Restart time</td>
        <td>Enabled</td>
        <td></td>
    </thead>
    
    <tbody>
        <?php
            // require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
            $trs = Poker_Cache::getOpenTournaments();
            
            foreach($trs as $i=>$tr){
                echo "
                    <tr>
                        <td>{$tr['name']}</td>
                        <td><input type='number' step='0.01' value='{$tr['point_fee']}' class='entryfee fee' /></td>
                        <td><input type='number' step='0.01' value='{$tr['lateregminutes']}' class='entryfee latereg' /></td>
                        <td><input type='number' step='0.01' value='{$tr['restart_time']}' class='entryfee restart' /></td>
                        <td class='center'><label><input type='checkbox' ".($tr['point_enabled']*1 ? "checked" : "")." class='enabled entryfee'/></label></td>
                        <td><input type='button' value='Change' class='editentryfee button' data-tournament='{$tr['name']}'/></td>
                        
                    </tr>
                ";
            }
        ?>
    </tbody>
</table>