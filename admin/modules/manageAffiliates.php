<?php

require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";

$len =  UserMachine::getUsersCount();

?>
<hgroup>
    <h2>Affiliates management</h2>
    <p>This page will let you observe player list, and manage everything that is connected to your affiliate program.</p>
</hgroup>
<div class='search'>
    <label>
        <span>Search player by name: </span>
        <input type='text' id='searchLine' />
    </label>
</div>
<table id='affiliates' data-amount='<?=$len?>'>
    <thead>
        <td>Player name</td>
        <td>E-mail</td>
        <td>Real name</td>
        <td>Total rake</td>
        <td>Tournament fees</td>
        <td>Free rolls</td>
        <td>Balance</td>
        <td>Affiliate of</td>
        <!--td title='Amount of referrals that play more than N days, where N is set by admin in affiliate variables.'>Timed referrals</td-->
        <td>Actions</td>
    </thead>
    
    <tbody>
        <template id='user'>
        <tr data-id='{{id}}'>
            <td>{{playername}}</td>
            <td>{{email}}</td>
            <td>{{realname}}</td>
            
            <td class='number'>{{rake}}</td>
            <td class='number'>{{fees}}</td>
            <td class='number'>{{freerolls}}</td>
            <td class='number'>{{balance}}</td>
            <td>{{affiliate}}</td>
            
            <td>
                <input type='button' class='settings' data-id='{{id}}'/>
                <input type='button' class='details' data-id='{{id}}' />
                <input type='button' class='message' data-id='{{id}}' />
                <a target="_blank" href="/profile?player={{playername}}">View profile </a>
            </td>
        </tr>
        </template>
    </tbody>
</table>
<ul class='pages affiliates'>
    <li><a href='#'>1</a></li>
    <li><a href='#'>1</a></li>
    <li><a href='#'>1</a></li>
</ul>

<div id='affiliateDetails' class='affiliatePopup'>
    <div class='wrap'>
        <hgroup>
            <h3>Tournaments player <span id='affiliateName'></span> took part into</h3>
            <p>Here are shown all the torunaments this player took part in during his game history.</p>
        </hgroup>
        
        <table>
            <thead>
                <td>Date</td>
                <td>Tournament</td>
                <td>Tournament fee</td>
                <td>Freeroll Fee</td>
            </thead>
            
            <tbody>
                <template id='affiliateDetailTemplate'>
                    <tr data-id='{{id}}'>
                        <td>{{date}}</td>
                        <td><a onClick='viewTournamentResult({{id}})' href="#">{{name}}</a></td>
                        <td>{{fee}}</td>
                        <td>{{feerolls_fee}}</td>
                    </tr>    
                </template>
                
            </tbody>
        </table>
    </div>
</div>

<div id='tournamentResultView' class='affiliatePopup'>
    <div class='wrap'>
        <div class='container'></div>
    </div>
</div>

<div id='affiliateMessage' class='affiliatePopup'>
    <div class='wrap'>
        <hgroup>
            <h2>Send message to player</h2>
            <p>Here you can send message to player via game API.</p>
        </hgroup>
        
        <form>
            <label>
                <textarea id='affiliatemsg' placeholder='Enter your message here'></textarea>    
            </label>
            
            <input type='submit' class='button' value='Send'/>
            <p id='messageStatus' class='status'></p>
        </form>
    </div>
</div>

<div id='affiliateSettings' class='affiliatePopup'>
    <div class='wrap'>
        <div class='cols'>
            <div class='col'>
                <fieldset class='info'>
                    <hgroup>
                        <h3>Personal info</h3>
                        <p>Edit here all the personal information for user.</p>
                    </hgroup>
                    
                    <div>
                        <label>
                            <span>Player name</span>
                            <input type='text' id='playername'/>
                        </label>
                        
                        <label>
                            <span>Real name</span>
                            <input type='text' id='realname'/>
                        </label>
                        
                        <label>
                            <span>Email</span>
                            <input type='text' id='email'/>
                        </label>
                    </div>
                </fieldset>
                
                <fieldset class='comission'>
                    <hgroup>
                        <h3>Affiliate comission</h3>
                        <p>Put here an amount of comission percents, that will affiliate user receive from all his referral players' rake.</p>
                    </hgroup>
                    <div>
                        <label>
                            <span>Rake comission</span>
                            <input type='number' min='0' max='100' step='0.01' id='comission'/>
                        </label>
                        
                    </div>
                </fieldset>
                
                <fieldset class='level2'>
                    <hgroup>
                        <h3>Two-level affiliate</h3>
                        <p>Allow or deny user to view second level of his affiliates</p>
                    </hgroup>
                    <div>
                        <select id='twolevel'>
                            <option value='1'>Allow</option>
                            <option value='0'>Deny</option>
                        </select>
                        <label>
                            <span>Level 2 comission</span>
                            <input type='number' min='0' max='100' step='0.01' id='level2_comission'/>
                        </label>
                        <label>
                            <span>Second link comission</span>
                            <input type='number' min='0' max='100' step='0.01' id='link2_commission'/>
                        </label>
                    </div>
                </fieldset>

              <!--   <fieldset class='level2'>
                    <hgroup>
                        <h3>Second-link affiliate</h3>
                        <p>Allow or deny user to view second level of his affiliates</p>
                    </hgroup>
                    <div>
                        <label>
                            <span>Rake comission</span>
                            <input type='number' min='0' max='100' step='0.01' id='link2_commission'/>
                        </label>
                    </div>
                </fieldset> -->
                
                <div class='buttons'>
                    <p class='status' id='affiliateStatus'> </p>
                    <input type='button' id='saveAffiliate' value='Save' class='button' />
                </div>
                
                <fieldset class='chips' id='chips'>
                    <hgroup>
                        <h3>Player balance</h3>
                        <p>Current player balance is <span class='number' id='chipsBalance'></span></p>
                    </hgroup>
                    <label class='inc'>
                        <span>Add chips to player:</span>
                        <input type='number' id='addChips' value='1' min='0' max='1000000'/>
                    </label>
                    
                    <label class='dec'>
                        <span>Deduct chips from player:</span>
                        <input type='number' id='decChips' value='1' min='0' max='1000000'/>
                    </label>
                    <input type='button' class='button' id='transferChips' value='Add 1 to player balance' />
                    <p id='transferStatus' class='status'></p>
                </fieldset>
                
            </div>
            
            <div class='col'>
                <fieldset class='list'>
                    <hgroup>
                        <h3>Edit referrals list</h3>
                        <p>Add or remove users for this player as referrals</p>
                    </hgroup>
                    
                    <table class='referralList'>
                        <thead>
                            <td>Player name</td>
                            <td>Total rake</td>
                            <td>Actions</td>
                        </thead>
                        
                        <tbody>
                            <template id='referralTemplate'>
                                <tr data-id='{{id}}'>
                                    <td>{{playername}}</td>
                                    <td>{{rake}}</td>
                                    <td>
                                        <input type='button' class='removeReferral' data-id='{{id}}'/>
                                    </td>
                                </tr>
                            </template>
                        
                        </tbody>
                    </table>
                    <input type='button' class='button' id='addReferral' value='Add referral to this user'/>
                    
                    
                    <div id='addReferralForm'>
                        <p>
                            <span>Enter player name here</span>
                            <input type='text' id='affiliateNameSearch'>
                        </p>
                        <table>
                            <thead>
                                <td>Player name</td>
                                <td>Total rake</td>
                                <td></td>
                            </thead>
                            
                            <tbody>
                                <template id='referralAddTemplate'>
                                    <tr data-id='{{id}}' data-referral='{{referral}}'>
                                        <td>{{playername}}</td>
                                        <td class='number'>{{rake}}</td>
                                        <td>
                                            <input type='button' class='submitAddReferral' value='Add' data-id='{{id}}'/>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
        
    </div>
</div>