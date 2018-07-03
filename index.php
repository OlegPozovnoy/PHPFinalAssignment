<?php 

session_start();

require_once('.\Model\user.php');
require_once('.\setup\appvars.php');

//echo '<pre> SessionVars' . print_r($_SESSION, TRUE) . '</pre>';
//echo '<pre> PostVars' . print_r($_POST, TRUE) . '</pre>';
//echo '<pre> GETVars' . print_r($_GET, TRUE) . '</pre>';
//echo '<pre> Server' . print_r($_SERVER, TRUE) . '</pre>';

$login = new User();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'main_page';
    }
}

$isLoggedIn = $login->is_loggedin() ;

if($isLoggedIn == false && ($action <> 'main_page' && $action <> 'signup' && $action<>'signin' && $action<>'error'))//GTFO
{
        $login->redirect('index.php');
}

if ($action<>'error')
	unset($_SERVER['Errors']);

if ($action=='signup')
{
		
	$title = 'Sign up';
	$header = 'Sign up' ;
	require_once ('.\view\header.php');
	//$_POST['action'] = '';
	require_once ('.\view\signup.php');
	require_once ('.\view\footer.php');		
	
	if (strlen(filter_input(INPUT_POST, 'user_id'))>0 && isset($_SESSION['user_id']) == false)
		{
			$login->signUp();
		}
	
}

else if ($action=='signin')
    {
        $_POST['action'] = '';

            if ($login->signIn()==true)
            {
            $login->redirect('index.php');
            }
            else
            {
               // echo '<pre> SessionVars' . print_r($_SESSION, TRUE) . '</pre>';
               // echo '<pre> PostVars' . print_r($_POST, TRUE) . '</pre>';
               // echo '<pre> GETVars' . print_r($_GET, TRUE) . '</pre>';
               // echo '<pre> Server' . print_r($_SERVER, TRUE) . '</pre>';
                exit();

            }
    }


else if ($action == 'main_page'){
	$title = 'Book Shop';
	$header = '<cite>Books - the best old fashioned way to furnish your room</cite>' ;
	require_once ('.\view\header.php');
	$books = $login->db->get_all_books();
	require_once ('.\view\main_page.php');
	require_once ('.\view\footer.php');
}

else if ($action == 'logout')
{
	session_unset();
	session_destroy();  
	$login->redirect('index.php');
}

else if ($action == 'save_book')
{
	$book_id= filter_input(INPUT_POST, 'book_id');	
	$book_title= filter_input(INPUT_POST, 'title');
	$book_genre= filter_input(INPUT_POST, 'book_genre');
	$book_review= filter_input(INPUT_POST, 'book_review');
	$name= filter_input(INPUT_POST, 'name');
	$email= filter_input(INPUT_POST, 'email');
	$url= filter_input(INPUT_POST, 'url');
    $image = $_FILES['img']['name'];
	$image_type = $_FILES['img']['type'];
    $image_size = $_FILES['img']['size']; 

	$err_string = '';
	if (empty($book_title) == true)
		$err_string.='Book title is mandatory.<br/>';
	if (empty($name) == true)
		$err_string.='Anonymous reviews are forbidden, please, enter your name.<br/>';	
	if (empty($image)==false && !(($image_type == 'image/gif') || ($image_type == 'image/jpeg') || ($image_type == 'image/pjpeg') || ($image_type == 'image/png')))
		$err_string.='Only JPEG PJPEG GIF PNG images are accepted.<br/>';	
	if (empty($image)==false && (($image_size <= 0) || ($image_size > GW_MAXFILESIZE)))
		$err_string.='The image is empty or the size exceeds maximum allowed '.GW_MAXFILESIZE/1024 .' KB<br/>';	
		
	$title = 'Book Shop';
	$header = 'Save Book' ;
	require_once ('.\view\header.php');	
	
	if (strlen($err_string)<=1){
		try
		{				
			
		if (empty($image)==false) 
		{
			$target = GW_UPLOADPATH.$image;
	
			if (move_uploaded_file( $_FILES['img']['tmp_name'], $target) == false)
			{
				echo "<p>WARNING!!! Can't upload books image, your data will be saved without it. </p><br/>";
				$image=null;
			}
		}
				
		$login->db->add_new_book($book_id,$book_title,$book_genre,$book_review,$name,$email,$url,$image);
		echo '<p>Changes saved</p>';
		}catch(PDOException  $e){
				
				$_SESSION['Errors'] =  $e->getMessage();
				header("Location: index.php?action=error");  
				}
		}
		else
		{ 		
			$_SESSION['Errors'] =  $err_string;
            header("Location: index.php?action=error");  
		}
		require_once ('.\view\footer.php');
}

else if ($action == 'delete_book')
{
	$book_id = filter_input(INPUT_GET, 'book_id');
	if (is_numeric($book_id)) {
		$login->db->delete_book_by_id($book_id);
		// redirect back to edit.php
		header('location: edit.php');
	}
	header("Location: .?action=edit_book");
}

else if ($action == 'add_book')
{

	$book_id =filter_input(INPUT_GET, 'book_id');

	if ((!empty($book_id)) && (is_numeric($book_id)))
		$header = 'Edit Book '.$book_id; 
	else
		$header = 'Add book';

	$title = 'Book Shop';

	require_once ('.\view\header.php');
	
	$book_title=null;
	$book_genre=null;
	$book_shortreview=null;
	$user_name=null;
	$user_email=null;
	$book_url=null;
	$book_image=null;

	if ((!empty($book_id)) && (is_numeric($book_id))) {

		$books = $login->db->get_book_by_id($book_id);

		foreach ($books as $book) {
			$book_title=$book['book_title'];
			$book_genre=$book['book_genre'];
			$book_shortreview=$book['book_shortreview'];
			$user_name=$book['user_name'];
			$user_email=$book['user_email'];
			$book_url=$book['book_url'];
			$book_image=$book['book_image'];
		}
	}
	require_once('.\view\add_page.php');
	require_once ('.\view\footer.php');
}
else if ($action == 'edit_book')
{
	$title = 'Book Listings';
	$header = 'Edit database' ;
	require_once ('.\view\header.php');
	$books = $login->db->get_all_books();
	require_once('.\view\edit_page.php');
	require_once ('.\view\footer.php');
}
else if ($action == 'error')
{
	$title = 'Error';
	$header = 'Error' ;
	require_once ('.\view\header.php');
	require_once('.\view\error_page.php');
	require_once ('.\view\footer.php');
	unset($_SESSION['Error']);
}
//disconnect();

?>




