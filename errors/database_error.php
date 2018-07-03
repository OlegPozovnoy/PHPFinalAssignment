<?php 
//session_start();
require_once('.\Model\user.php');
$login = new User();
$title = 'Error';
$header = 'Error' ;
$action = 'error';
$isLoggedIn = $login->is_loggedin() ;
require_once ('..\view\header.php'); ?>

    <p class="first_paragraph">Unexpected error occured.</p>
    <!--<p>Good luck fixing that, buddy. I'm out.</p>-->
    <p class="last_paragraph">Error message: <?php echo $error_message; ?></p>

<?php require_once  ('..\view\footer.php'); ?>