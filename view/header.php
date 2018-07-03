<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <title><?php echo $title ?></title>
    
	<!-- Latest compiled and minified CSS -->

    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <!-- Latest compiled and minified JavaScript -->
    <link rel="stylesheet" type="text/css" href="./styles/normalize.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<?php global $action; if ($action=='main_page') echo '<link rel="stylesheet" type="text/css" href="./styles/index.css?v={random number/string}">'; ?>
	<?php global $action; if ($action<>'main_page'/*$action=='edit_book'||$action=='add_book' || $action=='signup'*/) echo '<link rel="stylesheet" type="text/css" href="./styles/edit.css?v={random number/string}">'; ?>



</head>
<body>
<header><h1><?php echo $header ?></h1></header>
<?php 

$isLoggedIn = $login->is_loggedin(); 
echo '<nav><ul>';
if ($action <> 'main_page') {echo '<li><a  class="mynav" href="index.php?action=main_page">To The Main Page</a></li>'; }
if ($action <> 'edit_book' && $isLoggedIn == true) {echo '<li><a  class="mynav" href="index.php?action=edit_book">Edit Data(Add/Update/Delete)</a></li>';}
if ($action <> 'add_book' && $isLoggedIn == true) {echo '<li><a  class="mynav" href="index.php?action=add_book">Add A New Book</a></li>';}
if ($action <> 'signup' && $isLoggedIn == false ) {echo '<li><a  class="mynav" href="index.php?action=signup">Sign up</a></li>';}
if ($isLoggedIn == true ) {echo '<li><a  class="mynav" href="index.php?action=logout">Logout</a></li>';}
echo '</ul></nav>';

if($isLoggedIn == false){ require_once ('.\view\signin.php');}

?>

