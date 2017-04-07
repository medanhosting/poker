<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
?>
<article id='variables'> 
<hgroup>
    <h2>Affiliate variables</h2>
    <p>Set here all the parametres which manage your affiliate system.</p>
</hgroup>

<div class='cols' >
    
    <div class='col'>
        <fieldset class='points-invitation'>
            <hgroup>
                <h3>Points per invitation</h3>
                <p>Set here how many points to give for each invitation where referred player reaches rake X</p>
            </hgroup>
            
            <div class='formula'>
                <span> Give </span>
                <input type='number' id='points_invitation' value='<?=Poker_Variables::get("points_invitation")?>'/>
                <span> points for each invited player with rake = </span>
                <input type='number' min='0' step='0.01' id='points_invitation_rake' value='<?=Poker_Variables::get("points_invitation_rake")?>'/>
            </div> 
        </fieldset>
        
        <fieldset>
            <hgroup>
                <h3>2-level affiliate commission</h3>
                <p>Set here default value of commission for second level affiliates:</p>
            </hgroup>
            
            <div class='formula'>
                <span>Commission is </span><input type='number' min='0' max='1' step='0.005' id='second_level_commission' value='<?=Poker_Variables::get("second_level_commission")?>' />
            </div>
        </fieldset>
        <!--<fieldset class='referral-mintime'>-->
        <!--    <hgroup>-->
        <!--        <h3>Minimal playing time</h3>-->
        <!--        <p>Set here how much time should player be in game in order to be counted as a referral for affiliate.</p>-->
        <!--    </hgroup>-->
            
        <!--    <div class='formula'>-->
        <!--        <span> Minimal time is </span>-->
        <!--        <input type='number' id='referral_mintime' min='1' value='<?=Poker_Variables::get("referral_mintime")?>'/>-->
        <!--        <span> days. </span>-->
                
        <!--    </div> -->
        <!--</fieldset>-->
        
        <fieldset class='urls'>
            <label>
                <span>URL for game iframe on this site</span>
                <input type='text' id='url_game_frame' value='<?=Poker_Variables::get("url_game_frame")?>'/>
            </label>
            
            <label>
                <span>Domain name for referral URLs</span>
                <input type='text' id='domain_referrals' value='<?=Poker_Variables::get("domain_referrals")?>'/>
            </label>
        </fieldset>
    </div>
    
    <div class='col'>
        <fieldset class='invitations-affiliate'>
            <hgroup>
                <h3>Invitations to become an affiliate</h3>
                <p>Set here how many players with rake = X should user invite to become an affiliate</p>
            </hgroup>
            
            <div class='formula'>
                <span> Invite </span>
                <input type='number' id='invitations_affiliate' value='<?=Poker_Variables::get("invitations_affiliate")?>'/>
                <span> players with rake =  </span>
                <input type='number' min='0' step='0.01' id='invitations_affiliate_rake' value='<?=Poker_Variables::get("invitations_affiliate_rake")?>'/>
            </div> 
        </fieldset>
        
        <fieldset class='points-formula'>
            <hgroup>
                <h3>Points formula</h3>
                <p>Set here how many points will user get depending on his rake and</p>
            </hgroup>
            
            <div class='formula'>
                <span> Get a point per each</span>
                <input type='number' id='points_formula_rake' value='<?=Poker_Variables::get("points_formula_rake")?>'/>
                <span> units of rake. </span>
                <!--input type='number' min='0' step='0.01' id='points_formula_rake' value='10'/-->
            </div> 
        </fieldset>
        
        
    </div>
</div>

</article>