<form action='' method='post'>
    <fieldset>
        <h2>Log in as admin:</h2>
        <label>
            <span>Admin login</span>
            <input type='text' name='login' />
        </label>
        
        <label>
            <span>Admin password</span>
            <input type='password' name='password' />
        </label>
        
        <input type='submit' class='button' value='Log In' />
        <?=$status?>
    </fieldset>
</form>