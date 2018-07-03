<form id="signinform" method = "post" action = "index.php">
        <fieldset>

            <label for="user_id">Name: </label>
            <input type = "text" name="user_id" id="user_id" maxlength="30"> </input>

            <label for="password"> Password: </label>
            <input type = "password" name = "password" maxlength="20"></innput>

            <input type="hidden" name="action" id="action" value="signin"/>
            <input type="submit" value="Sign in" name="submit"></input>

        </fieldset>

    </form>