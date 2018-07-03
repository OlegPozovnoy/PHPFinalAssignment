<?php

$errstring = '';
require_once "model_db.php";

class User {
    public $db;
    
    function __construct()
    {
        $this->db = new Database();
    }
    

    public function signIn(){

        $errstring = '';

    try{
            
            
            $username = '';
            $password = '';

            if (isset($_POST['user_id'])== true and isset($_POST['password'])== true)
                {
                //echo "+1";
                //$username = filter_input(INPUT_POST,'user_id');
                //$password = filter_input(INPUT_POST,'password');
                $username =filter_var($_POST['user_id']);;
                $password =filter_var($_POST['password']);;
                }       
            
            if (isset($_SERVER['PHP_AUTH_USER']) == true && isset($_SERVER['PHP_AUTH_PW']) == true && strlen($username)==0 && strlen($password)==0)
                {
                    //echo "+2";
                    //echo '<pre> Server' . print_r($_SERVER, TRUE) . '</pre>';
                    $username =filter_var($_SERVER['PHP_AUTH_USER']);;
                    $password =filter_var($_SERVER['PHP_AUTH_PW']);;
                }


        //check data correctness
            if(empty($username))
                {
                //echo "login failed2";
                $errstring .="<br/>username is empty";
                }
            if(strlen($password)==0 || empty($password))
                {
                    $errstring .="<br/>password is empty";   
                }
        // if there were any errors - leave
            if (strlen($errstring)> 0)
            {
                $_SESSION['Errors'] = $errstring;
                $errstring = '';
                $this->redirect('index.php?action=error');  
                return false;
            }
        
            //echo '<pre> SessionVars' . print_r($_SESSION, TRUE) . '</pre>';
            //echo '<pre> PostVars' . print_r($_POST, TRUE) . '</pre>';
            //echo '<pre> GETVars' . print_r($_GET, TRUE) . '</pre>';
            //echo '<pre> Server' . print_r($_SERVER, TRUE) . '</pre>';
            //echo "singin UserName and password:".$username."*".$password."*".strlen($username).'*'.strlen($password).'*';

                //exit();
     
            if ($this->db->signIn($username, $password)==true)// login is successfull
            {
                //echo ('login is super '.$username);
                $stmt = $this->db->getUser($username);
                //echo ('login is super');
                $_SESSION['user_id'] = $username;

                $record = $stmt->fetch();
                $_SESSION['email'] = $record['email'];
                $_SESSION['registrationDate'] = $record['registratoinDate'];

                //unset($_SERVER['PHP_AUTH_USER']);
                //unset($_SERVER['PHP_AUTH_PW']);
                //echo '<pre> SessionVars' . print_r($_SESSION, TRUE) . '</pre>';
                //echo '<pre> PostVars' . print_r($_POST, TRUE) . '</pre>';
                //echo '<pre> GETVars' . print_r($_GET, TRUE) . '</pre>';
                //echo '<pre> Server' . print_r($_SERVER, TRUE) . '</pre>';
                //exit();
                $this->redirect('index.php'); 
                return true;
            }
            else //login unsuccessful
            {
                //echo "login failed6";
                $errstring.="<br/>Login failed";
                $_SESSION['Errors'] = $errstring;
                $errstring = '';
                $this->redirect('index.php?action=error');  
                return false;         
            }
        
    }
    catch(Exception $e)
    {
        $_SESSION['Errors'] =  $e->getMessage();
        $errstring = '';
        $this->redirect('index.php?action=error');  
       // return false;   
    }    
    }
    
    
    public function signUp(){
        $errstring = '';
        
    $username = filter_input(INPUT_POST,'user_id');
    $email = filter_input(INPUT_POST,'email');

    $password = filter_input(INPUT_POST,'password');
    $password2 =filter_input(INPUT_POST,'password2');

        //check data correctness
    if(empty($username))
        {
            $errstring .="<br/>username is empty";
        }
    if(strlen(filter_input(INPUT_POST,'email'))==0 || empty(filter_input(INPUT_POST,'email')))
        {
            $errstring .="<br/>email is empty";  
        }
    if(strlen(filter_input(INPUT_POST,'password'))==0 || empty(filter_input(INPUT_POST,'password')))
        {
            $errstring .="<br/>password is empty";  
        }
    if(!filter_var(filter_input(INPUT_POST,'email'), FILTER_VALIDATE_EMAIL)){	// Im tired so I'll just steal the next 2: 
        $errstring .='<br/>Please enter a valid email address !';}
    
    if(strlen(filter_input(INPUT_POST,'password')) < 6){
        $errstring .= "Password must be at least 6 characters";	}

    if (strcmp(filter_input(INPUT_POST,'password') , filter_input(INPUT_POST,'password2'))<>0)    
        {
            $errstring .="<br/>Passsword and password confirmation don't match";  
        }

    if (strlen($errstring)> 0)
        {
            $_SESSION['Errors'] = $errstring;
            $errstring = '';
            $this->redirect('index.php?action=error'); 
            return false;
        }            

    
    try {
        $password = password_hash($password, PASSWORD_BCRYPT);

        $this->db->signUp($username,$password, $email);
        
       // $_SESSION['Errors'] = "Your credientials has been recorded, please process to the main page and log in";
        $title = 'Sign up';
        $header = 'Thank you for joining us' ;
        require_once ('.\view\header.php');
        echo '<p>'."Your credientials has been recorded, please process to the main page and log in".'</p>'; 
        //require_once('.\view\error_page.php');
        require_once ('.\view\footer.php');
        //unset($_SESSION['Error']);
        exit();
        //$errstring = '';
        //$this->redirect('index.php?action=error'); 
        return true;
        }
    catch (Exception $e)
        {
        $errstring.=$e->getMessage();
        $_SESSION['Errors'] = $errstring;
        $errstring = '';
        $this->redirect('index.php?action=error'); 
        return false;         
        }
    }
                
    public function logout(){

    session_unset();
    session_destroy();
//    unset($_SERVER['PHP_AUTH_USER']);
 //   unset($_SERVER['PHP_AUTH_PW']);
    header('location:index.php');       
    }
    
    public function is_loggedin()
    {
	    if(isset($_SESSION['user_id']))
	    {
		return true;
	    }
    }
	
	public function redirect($url)
	{
		header("Location: ".$url);
	}
	 
    //put your code here
}
