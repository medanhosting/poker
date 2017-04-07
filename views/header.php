<header>
            <a href='/'>
                <img src='/img/logo.png' />
            </a>
            <nav class='menu'>
                <ul>
                    <li><a class='game' href='/game'>Game</a></li>
                    <li><a class='events' href='/events'>Events</a></li>
                    <li><a class='contacts' href='/Contact'>Contacts</a></li>
                    
                    
                </ul>
            </nav>
            
            <nav class='login'>
                <ul>
                    <li><a class='freeroll game' href='#freeroll'>Freeroll</a></li>
                    
                    <?php
                        $sql = new SQLConnection;
                        $temp = $sql->getArray("SELECT * FROM cata_settings_vars WHERE `key`='show_entry_fee'");
                        $check = 0;
                        if($temp){
                            $check = $temp[0]['value'];
                        }

                        if(UserMachine::getCurrentUser()!=null){
                            $user = UserMachine::getCurrentUser();
                            $account = Poker_Accounts::Get(["Player"=>$user->playername]);
                            $sql->query('UPDATE poker_users SET balance = '.$account['Balance'].' WHERE name="'.$user->playername.'"');
                            // echo '<li>UPDATE poker_users SET balance = '.$account['Balance'].' WHERE name="'.$user->playername.'"</li>';
                            echo "
                                
                                <!--li><a class='cashin' id='cashinLink' href='#cashin'>Cash out</a></li>
                                <li><a class='cashin deposit' id='depositLink' href='#deposit'>Deposit</a></li-->
                                <li><a href='#partnership' class='partner'>Become partner</a></li>
                                <li><a href='/profile' id='profile'>".$user->playername."</a></li>
                                
                                
                                <li class='b'><span class='balance'>{$account['Balance']}</span> 
                                    <i class='link'>Cashier</i>
                                    <div>
                                        <a class='cashin' id='cashinLink' href='#cashin'>Cash out</a>
                                        <a class='cashin deposit' id='depositLink' href='#deposit'>Deposit</a>
                                        <a class='cashin deposit' id='historyLink' href='#history' data-name='".$user->playername."'>History</a>
                                    </div>
                                </li>
                                
                                
                                <li><a href='/auth/logout.php' class='logout'>Exit</a></li>
                            ";
                        }else{
                            echo " 
                                <li><a href='#' id='login'>Login</a></li>
                                <li><a href='#' id='register'>Register</a></li>";
                        }
                    ?>
                </ul>
                
                <div id='requestDeposit' class='popup'>
                    <div class='wrap'>
                        <hgroup>
                            <h3>Your balance: <span class='number' id='balanceAmountDep'><?=$user->balance?></span> chips</h3>
                            <p>You can request a chips deposit from administrator</p>
                        </hgroup>
                        <div>
                            <label>
                                <span>Chips to request</span>
                                <input type='number' min='1' max='1000000' id='depositAmount' value='1'/>
                            </label>
                            <input type='button' class='button' value='Request deposit' id='deposit'/>
                            <p id='depositStatus' class='status'></p>
                        </div>
                    </div>
                </div>
                
                <div id='balance' class='popup'>
                    <div class='wrap'>
                        <hgroup>
                            <h3>Your balance: <span class='number' id='balanceAmount'><?=$user->balance?></span> chips</h3>
                            <p>At any time you can request cash out your chips balance to real money.</p>
                        </hgroup>
                        <div>
                            <label>
                                <span>Chips to transfer</span>
                                <input type='number' min='1' max='<?=$user->balance?>' id='chips' value='<?=$user->balance?>'/>
                            </label>
                            <label>
                                <span>Cash out method</span>
                                <select id='chips_method'>
                                    <?php
                                        foreach(Poker_Transactions::$methods as $m){
                                            echo "<option value='{$m['method']}'>{$m['method']}</option>";
                                        }
                                    ?>
                                </select>
                            </label>
                            <input type='button' class='button' value='Request cash out' id='cashin'/>
                            <p id='balanceStatus' class='status'></p>
                        </div>
                    </div>
                </div>

                <div class='popup' id='transfersHistory'>
                    <div class='wrap'>
                        <hgroup>
                            <h2>Transfers history</h2>
                            
                        </hgroup>    
                        <nav>
                            <ul>
                                <li><a href='#' id='incomesTab' class='active'>Incomes</a></li>
                                <li><a href='#' id='outcomesTab'>Outcomes</a></li>
                            </ul>
                        </nav>
                        <div class='spinner_big'></div>
                        <table id='historyIncome'>
                            <thead>
                                <td>Date</td>
                                <td>Amount</td>
                                <td>From</td>
                            </thead>
                            
                            <tbody>
                                <template id='transferTemplate'>
                                    <tr>
                                        <td>{{date}}</td>
                                        <td><span class='number'>{{amount}}</span></td>
                                        <td>{{subject}}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        
                        <table id='historyOutcome'>
                            <thead>
                                <td>Date</td>
                                <td>Amount</td>
                                <td>To</td>
                            </thead>
                            
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    
                    
                </div>
                
                
                <div id='freeroll' class='popup'>
                    <div id='wrap'>
                        <hgroup>
                            <h2>Available tournaments</h2>
                            <p>Here are displayed available tournaments for you to take part in.</p>
                        </hgroup>
                        
                        <pre></pre>
                        
                        
                        <table>
                            <thead>
                                <td>Tournament</td>
                                <td>Free seats</td>
                                <td>Total seats</td>
                            <?php if($check): ?>
                                <td>Entry fee</td>
                            <?php endif?>
                                <td>Actions</td>
                            </thead>
                            
                            <tbody id='tournamentsPart'>
                                <template id='tournamentsTemplate'>
                                    <tr data-name='{{name}}'>
                                        <td>{{name}}</td>
                                        <td>{{freeseats}}</td>
                                        <td>{{seats}}</td>
                                    <?php if($check): ?>
                                        <td><span class='number'>{{entryfee}}</span></td>
                                    <?php endif?>
                                        <td data-accepted='{{accepted}}'>
                                            <p class='register'>
                                                 <input type='button' class='button register' value='Register'/>     
                                            </p>
                                            <p class='unregister'>
                                                <input type='button' class='button unregister' value='Unregister'/>
                                            </p>
                                            <p class='unauthorized'>
                                                <span class='err'>Log in to take part!</span>
                                            </p>
                                            <p class='nenough'>
                                                <span class='err'>Not enough points to take part!</span>
                                            </p>
                                        </td>
                                    </tr>
                                </template>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </nav>
        </header>

<?php
    if($user){
        echo "<article class='partnership' id='partnership'>
            <fieldset class='frameRequest'>
                <hgroup>
                    <h3>Game code for your website</h3>
                    <p>Get HTML code to insert on your website to load our prescious game on your website under yur domain. Involve more players and get more money!</p>
                </hgroup>
                
                <div class='text'>";
                    

        $fq = FrameRequests::getUserRequest($user);
        if($fq==null){
            echo "<input type='button' id='frameRequest' class='button' value='Request code'>";
        }else{
            
            switch($fq['status']){
                case FrameRequests::STATUS_WAITING:{
                    echo "<p>Your request is waiting to be proceed.</p>";
                    break;
                }
                case FrameRequests::STATUS_DECLINED:{
                    echo "<p> <span class='declined'>Declined.</span>  Sorry, but your request was declined by the administrator.</p>";
                    break;
                }
                case FrameRequests::STATUS_ACCEPTED:{
                    echo "<textarea class='code' readonly='readonly'><iframe src='".Poker_Variables::get("domain_referrals")."/game/?ref=".UserMachine::getAffiliateCode($user->getId())."' class='online-poker-game' width='100%' height='100%'></iframe></textarea>
                    <div class='label textarea'><input type='button' class='button copy' value='  Copy  '  /></div>";
                    break;
                }
            }
        }
                    
                    
        echo "           <p class='status'></p>
                </div>
            </fieldset>
            
            <fieldset class='reflink'>
                <hgroup>
                    <h3>Your affiliate link</h3>
                    <p>Take that link and share it in socials, to your friends and fellows. Everyone who will register by your link, will bring you additional money during his game!</p>
                </hgroup>
                
                <div class='label text'>
                    <input type='text' id='reflink' value='".Poker_Variables::get("domain_referrals")."?ref=".UserMachine::getAffiliateCode($user->getId())."'/>
                </div>
                <div class='label'>
                    <input type='button' class='button copy' value='  Copy  ' />
                    <div class='share42init' data-title='Start earning money with ".Poker_Variables::get("domain_referrals")."!' data-url='".Poker_Variables::get("domain_referrals")."?ref=".UserMachine::getAffiliateCode($user->getId())."'></div>
                    <script type='text/javascript' src='/views/share/share42.js'></script>
                </div>
            </fieldset>
            
            
        ";
        //if($user->level2==1){
            echo "
            <fieldset class='reflink'>
                <hgroup>
                    <h3>Your 2-level affiliate link</h3>
                    <p>Share that link in socials or just send it to your friend. You won't get money from player who registers by that link, but will earn money from every user they'll bring into system</p>
                </hgroup>
                
                <div class='label text'>
                    <input type='text' id='reflink' value='".Poker_Variables::get("domain_referrals")."?ref=".UserMachine::getAffiliateCode($user->getId(),2)."'/>
                </div>
                <div class='label '>
                    <input type='button' class='button copy' value='  Copy  ' />
                    <div class='share42init' data-title='Start earning money with ".Poker_Variables::get("domain_referrals")." and subaffiliates!' data-url='".Poker_Variables::get("domain_referrals")."?ref=".UserMachine::getAffiliateCode($user->getId(),2)."'></div>
                    <script type='text/javascript' src='/views/share/share42.js'></script>
                </div>
            </fieldset>
        
        ";
       // }
        echo "</article>";
    }
?>
    