<footer>
            <div class='top'>
                <article>
                    <h3>About us</h3>
                    <p>we are expert regarding online Gambling industry we are not just a poker site but we are a poker network providing white label poker site for interested this mean you can own a poker site running our games under your Brand or Domain name and we can manage your poker tournament event up to 1000 player in one tournament for more info contact usEmail:prodealer2@gmail.com </p>
                </article>
            </div>
            <div class='bottom'>
                <p>2016 &copy; Online Poker. All rights reserved.</p>
            </div>
        </footer>
        
        <div id='popup'>
            
            <form id='login_form' method='POST' action='/auth/auth.php'>
                <h2> Log In</h2>
                <fieldset>
                    <label>
                        <span>Your player name</span>
                        <input type='text' name='playername' id='playername' required />
                    </label>
                    
                    <label>
                        <span>Password</span>
                        <input type='password' name='password' id='password' required/>
                    </label> 
                    <label>
                        <input type='checkbox' name='remember' />
                        <span>Remember me</span>
                    </label>
                    
                    <input type='submit' id='login_btn' value='Log In' />
                    <input type='button' id='closeForm' value='Cancel' />
                    <p class='status'></p>
                </fieldset>
            </form>
            
            <form id='register_form' method='post' action='/auth/register.php'>
                <h2>Register</h2>
                <fieldset class='title'>
                    <div>
                        <label>
                            <span>Player Name</span>
                            <input type='text' required name='playername' />
                        </label>
                        
                        <label>
                            <span>E-mail</span>
                            <input type='email' required name='email' />
                        </label>
                    </div>
                    <ul class='details'>
                        <li>Player name is login name that will appear with your avatar on the poker table. The name must be from 3 to 12 characters and can only include letters, numbers, dashes, and underscores.</li>
                        <li>Email address (80 characters max) is used for account validation and password recovery. It is not displayed to other players.</li>
                    </ul>
                    
                </fieldset>
                
                <fieldset class='cols'>
                    <div>
                        
                        <label>
                            <span>Password</span>
                            <input type='password' required name='password'/>
                        </label>
                        
                        <label>
                            <span>Real name</span>
                            <input type='text' name='realname' />
                        </label>
                        
                        <label>
                            <span>Affiliate code</span>
                            <input type='text' name='affiliatecode' value='<?=$_COOKIE['ref']?>'/>
                        </label>
                        
                        <input type='hidden' value='<?=$_COOKIE['rlevel']*1+1?>' name='level' />
                    </div>
                    
                    <div>
                        <label>
                            <span>Confirm password</span>
                            <input type='password' required name='confirmpassword'/>
                        </label>
                        
                        <label>
                            <span>Location</span>
                            <input type='text' name='location' />
                        </label>
                        
                        <p>
                            <span class='heading'>Gender</span>
                            <label class='inline'>
                                <input type='radio' name='sex' value='m' checked>
                                <span>Male</span>
                            </label>
                            <label class='inline'>
                                <input type='radio' name='sex' value='f'/>
                                <span>Female</span>
                            </label>
                        </p>
                    </div>
                    
                    <p class='buttons'>
                        <input type='submit' id='register_btn' value='Register' />
                        <input type='button' id='closeForm' value='Cancel' />
                    </p>
                    <p class='status'></p>
                </fieldset>
            </form>
        </div>