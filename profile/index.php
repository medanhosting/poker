<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/profile/auth.php";
    $user = UserMachine::getCurrentUser();

    $cookie = "918462935623654682";

    if ($_COOKIE['adssid']==$cookie && isset($_GET['player']) && !empty($_GET['player'])){
       $user = UserMachine::getUserByPlayerName($_GET['player']);
    }

    $refs = $user->getReferrals();
    $sum = 0;
    $sql = new SQLConnection;
    $temp = $sql->getArray("SELECT * FROM poker_player_rake");
    $rakeUser = [];
    $totalHandRakeReferral = $totalTournamentFee = $totalFreerollFeeReferal = 0;
    if($temp){
        foreach ($temp as $key => $value) {
            $rakeUser[$value['player_name']] = $value['total_rake'];
        }
    }

    foreach($refs as $u){
        if($u->referral_level != 1){
            continue;
        }

        $uRake = (isset($rakeUser[$u->playername])) ? $rakeUser[$u->playername] : 0;
        $totalHandRakeReferral += $uRake;
        $totalTournamentFee +=$u->tournament_fee;
        $totalFreerollFeeReferal +=$u->points_dec;
    }

?>

<!doctype html>
<html>
    <head>
        <?php require_once $_SERVER['DOCUMENT_ROOT']."/views/head.php";?>
        
        <title>My Profile</title>
        <link rel='stylesheet' href='/css/profile.css' />
        <script src='/js/profile.js'></script>
    </head>
    
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT']."/views/header.php";?>
        <main>
            <div class='hello'>
                <h2>Hello, <?=($_COOKIE['adssid'] ==$cookie  && isset($_GET['player']) && !empty($_GET['player'])) ? 'Administrator you are view profile of '.$user->playername : $user->playername ?>!</h2>
                <p>We are glad to meet you at our poker community, where you can easily play and earn real money even without playing! Know more about our affiliate program.</p>
            </div>
            <a href='/profile/play' class='button'> Play game</a>
            
            <div class='wrapper'>
                <div class='column'>
                    
                    
                    <fieldset class='transfer-chips'>
                        <hgroup>
                            <h3>Transfer chips</h3>
                            <p>Here you can select any player and transfer some amount of your chips to him.</p>
                        </hgroup>
                        
                        <form id='transferChips'>
                            <label>
                                <span>Player:</span>
                                <input type='text' id='transfer_player' list='players' required/>
                                <datalist id='players'>
                                    <template id='player-option'>
                                        <option value='{{name}}'>{{name}}</option>
                                    </template>
                                </datalist>
                            </label>
                            
                            <label>
                                <span>Chips to be transferred:</span>
                                <input type='number' min='1' max='<?=$user->balance?>' id='transfer_amount'/>
                                <span>of <b class='accBalance'><?=$user->balance?></b></span>
                            </label>
                            
                            <input type='submit' class='button' value='Send' />
                            <p id='transfer-status' class='status'></p>
                        </form>
                    </fieldset>
                    
                    <fieldset class='become-affiliate'>
                        <hgroup>
                            <h2>Terms to become affiliate</h2>
                            <p>Here you can find terms how to become partner of our system and earn money instead of points!</p>
                        </hgroup>
                        
                        <div>
                            
                            <article>
                                <hgroup>
                                    <h3>Progress:</h3>
                                    <p>To become able to send partner request, you need to meet following conditions:</p>
                                </hgroup>
                                
                                <div>
                                    <p>You need to have <span class='number'><?=Poker_Variables::get("invitations_affiliate")?></span> real referrals with summary rake not less than <span class='number'><?=Poker_Variables::get("invitations_affiliate_rake")?></span>.</p>
                                    <p>You earn <span class='number'><?=Poker_Variables::get("points_invitation")?></span> points for every real referral, who has summary rake not less than <span class='number'><?=Poker_Variables::get("points_invitation_rake")?></span></p>
                                </div>
                                
                                <div>
                                    <p>Your referral rakes: <span class='number'><?=Poker_Calculations::getReferralRake($user)?></span></p>
                                    <p>Your points: <span class='number'><?=$user->getPointBalance()?></span></p>
                                    <p>Your real referrals: <span class='number'><?=$user->getRealReferralsCount()?></span></p>
                                    <br/>
                                    <p>Your chips balance: <span class='number accBalance'><?=$user->balance?></span></p>
                                   <!--  <p>Your affiliate balance: <span class='number'><?php
                                    
                                        
                                        
                                        echo $user->getAffiliateBalance();
                                    ?></span></p> -->
                                </div>
                                
                                <div>
                                    <p>Referrals with rake more than <?=Poker_Variables::get("invitations_affiliate_rake")?>: <span class='number'><?=$user->getRealAffiliateReferralsCount()?></span> of <span class='number'><?=Poker_Variables::get("invitations_affiliate")?></span>
                                    </p>
                                    
                                    <?php
                                       
                                        if(UserMachine::isAbleToAffiliate($user)){
                                            if(!AffiliateRequests::hasRequest($user)){
                                                echo "<p>
                                                    <input type='button' class='button' id='affiliateRequest' value='Request to become affiliate' />
                                                </p>
                                                <p class='affiliate status'></p>
                                                ";
                                            }else{
                                                $request = AffiliateRequests::getUserRequest($user);
                                                switch($request['status']){
                                                    case AffiliateRequests::STATUS_WAITING:{
                                                        echo "<p class='affiliateRequestStatus'>Your request is waiting to be proceed.</p>";
                                                        break;
                                                    }
                                                    case AffiliateRequests::STATUS_ACCEPTED:{
                                                        echo "<p class='affiliateRequestStatus'><span class='accepted'>You are an affiliate now!</span></p>";
                                                        break;
                                                    }
                                                    case AffiliateRequests::STATUS_DECLINED:{
                                                        echo "<p class='affiliateRequestStatus'><span class='declined'>Sorry, but your request was declined!</span></p>";
                                                        break;
                                                    }
                                                }
                                                
                                            }
                                        }
                                    ?>
                                </div>
                            </article>
                        </div>
                    </fieldset>

                    <fieldset class='show-process'>
                        <hgroup>
                            <h2>Show process</h2>
                        </hgroup>
                        
                        <div>     
                            <article>
                                
                                <div>
                                    <p>Total hand rake for referral players: <span class='number'><?= $totalHandRakeReferral ?></span></p>

                                    <p>Total tournament fee for referral players: <span class='number'><?= $totalTournamentFee ?></span></p>
                                    <p>Total freeroll fee for referral players: <span class='number'><?= $totalFreerollFeeReferal ?></span></p>
                                    <br/>
                                    <p>Your commission rate: <span class='number accBalance'><?=$user->comission?></span></p>
                                    <p>Your affiliate balance: <span class='number'><?= $user->getAffilateBalance()?></span></p>
                                    <a href="#" onClick="openTransferHistory()" style="color: rgb(183, 8,25);" class="view-history-transfer">View transfer history</a>
                                </div>
                            </article>
                        </div>
                        <br/><br/>
                        <hgroup>
                            <h3>Transer Request</h3>
                        </hgroup>
                        <form id="transferAffiliate">
                            <label>
                                <span>Amount:</span>
                                <input type='number' min='1' max='<?= $user->getAffilateBalance()?>' id="affiliate_amount" list="players" required="">
                            </label>
                            <input type="submit" class="button" value="Send">
                            <p id='affiliate-transfer-status' class='status'></p>
                        </form>
                    </fieldset>

                </div>
                
                <div class='column'>
                    <fieldset class='referrals'>
                        <hgroup>
                            <h3>Your referrals</h3>
                            <p>Here are displayed all players that have registered by your invite and bring you money while playing. Total rake count is cached for 2 minutes, so if you are not sure about the accuracy of this field, wait for2 minutes and refresh the page.</p>
                        </hgroup>
                        
                        <div>
                            <table>
                                <thead>
                                    <td>Player name</td>
                                    <td>E-mail</td>
                                    <td>Real name</td>
                                    <td>Total rake</td>
                                    <td></td>
                                </thead>
                                
                                <tbody class='refs'>
                                    <?php
                                        // $refs = $user->getReferrals();
                                        // $sum = 0;
                                        // $sql = new SQLConnection;
                                        // $temp = $sql->getArray("SELECT * FROM poker_player_rake");
                                        // $rakeUser = [];
                                        // if($temp){
                                        //     foreach ($temp as $key => $value) {
                                        //         $rakeUser[$value['player_name']] = $value['total_rake'];
                                        //     }
                                        // }
                                        foreach($refs as $u){
                                            if($u->referral_level != 1){
                                                continue;
                                            }
                                            echo "<tr data-id='{$u->getId()}'>
                                                <td>{$u->playername}
                                                    
                                                </td>
                                                <td>{$u->email}</td>
                                                <td>{$u->realname}</td>
                                                
                                                <td class='income'>";
                                                $uRake = (isset($rakeUser[$u->playername])) ? $rakeUser[$u->playername] : '0';
                                                $uRake = $uRake + $u->tournaments_fee;

                                                if(!$user->level2){
                                                    if($u->referral_level == 1){
                                                        echo "<span class='result'>".$uRake."</span>";
                                                        $sum+=$uRake;
                                                    }
                                                 }else{
                                                   echo "<span class='result'>".($uRake+$u->countAffiliatesRake())." (Level 1+2)</span>";
                                                        $sum+=$uRake+$u->countAffiliatesRake(); 
                                                }
                                                echo " | <a href='#' data-id='{$u->getId()}'>Details</a>";
                                                echo "</td>
                                                    ";
                                                // if ($user->level2) echo "<td class='refs'><a href='#' data-id='{$u->getId()}' class='referralsLink'>Referrals</a></td>";
                                                echo"
                                            </tr>";
                                        }
                                    ?>
                                    
                                </tbody>
                                <?php
                                 if($user->level2){
                                    echo "
                                        <tr>
                                            <td colspan='5'>
                                                <h3>Level 2 affiliates</h3>
                                            </td>
                                        </tr>
                                    "; 
                                     
                                 }?>
                                
                               
                                
                                <tbody class='refs'>
                                    <?php
                                        // $refs = $user->getReferrals();
                                       
                                        // if($user->level2){
                                            foreach($refs as $u){
                                                if($u->referral_level == 1){
                                                    continue;
                                                }
                                                echo "<tr data-id='{$u->getId()}'>
                                                    <td>{$u->playername}
                                                        
                                                    </td>
                                                    <td>{$u->email}</td>
                                                    <td>{$u->realname}</td>
                                                    
                                                    <td class='income'>";
                                                    // echo "<pre>";var_dump($u);
                                                    // if(!$user->level2){
                                                        if($u->referral_level != 1){
                                                            echo " <span class='result'>".$u->countAffiliatesRake()." (Level 2)</span>";
                                                            $sum+=$u->countAffiliatesRake();
                                                        }
                                                       
                                                    // }else{
                                                    //    echo "<span class='result'>".($u->rake+$u->countAffiliatesRake())." (Level 1+2)</span>";
                                                    //         $sum+=$u->rake+$u->countAffiliatesRake(); 
                                                    // }
                                                    echo " | <a href='#' data-id='{$u->getId()}'>Details</a>";
                                                    echo "</td>
                                                        ";
                                                    // if ($user->level2) echo "<td class='refs'><a href='#' data-id='{$u->getId()}' class='referralsLink'>Referrals</a></td>";
                                                    echo"
                                                </tr>";
                                            }
                                        
                                        // }
                                    ?>
                                    <tfoot>
                                        <td colspan='3'>Total rake</td>
                                        <td id='totalrake'><?=$sum." (".$user->chipsToPay()." chips)"?></td>
                                    </tfoot>
                                </tbody>
                            </table>
                            
                            <div id='details'>
                                <div class='wrap'>
                                    <hgroup>
                                        <h3>Referrals of player <span class='name'></span></h3>
                                        <p>Here you can see referral users of your referrals.</p>
                                    </hgroup>
                                    <div class='container'>
                                        
                                    </div>
                                </div>
                            </div>

                            <div id='transfer-history'>
                                <div class='wrap'>
                                    <hgroup>
                                        <h3>Your transfer history</h3>
                                        
                                    </hgroup>
                                    <div class='container'>
                                        
                                    </div>
                                </div>
                            </div>

                            <div id='hand-history'>
                                <div class='wrap'>
                                    <hgroup>
                                        <h3>Hand history <span class='name'></span></h3>
                                        <p></p>
                                    </hgroup>
                                    <div class='container'>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                    
                </div>
            </div>
            
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT']."/views/footer.php";?>
    </body>
</html>