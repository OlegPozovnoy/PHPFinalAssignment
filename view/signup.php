<p>Please, enter your cridentials here:</p>
<form id="signupform" method = "post" action = "index.php">
        <fieldset>

            <label for="user_id">Name: </label>
            <input type = "text" name="user_id" id="user_id" maxlength="30"> </input>
            <br/>
            <label for="email">Email: </label>
            <input type = "email" name="email" id="email" maxlength="30"> </input>
            <br/>
            <label for="password"> Password(6+ characters): </label>
            <input type = "password" name = "password"  maxlength="20"></innput>
            <br/>
            <label for="password2"> Confirm password: </label>
            <input type = "password" name = "password2"  maxlength="20"></innput>
            <br/>
            <input type="hidden" name="action" id="action" value="signup"/>
            <input type="submit" value="Sign up" name="submit"></input>

        </fieldset>

    </form>