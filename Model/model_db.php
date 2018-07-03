<?php

class MyException extends Exception{}

require_once('.\setup\connectvars.php');

class Database{

    private $username = DB_USER;
    private $password = DB_PASSWORD;
    private $host = DB_HOST;
    private $dbname = DB_NAME;    

    private $dbc;
 //user_name	password	email	isVerified	registratoinDate	userId	verificationCode
   
    public $conn;
   
function __construct()
    {
        

    try{
    
    $this->dbc = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME ,DB_USER,DB_PASSWORD);
    // connect
    $this->dbc -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
           
       // $error_message = $e->getMessage();
       // require('.\errors\database_error.php');
       $_SESSION['Errors'] = "<br/>".$e->getMessage();
       header("Location: index.php?action=error");  
        exit();

    }
}

function __destruct(){
    $this->username = null;
    $this->password = null;
    $this->host = null;
    $this->dbc = null;
    $this->dbname = null;
}


function signUp($user_name, $password, $email){
        
    try{
    
    $stmt = $this->dbc->prepare("SELECT * FROM ".$this->dbname.".users WHERE user_name = :user_name");
    $stmt->bindParam(":user_name", $user_name);
    $stmt->execute();
    
    if ($stmt->rowCount()>=1)
        {
            //$error_message = "Sorry, the username ".$user_name. " is already registered";
            //require('.\errors\database_error.php');
            $_SESSION['Errors'] = "<br/>"."Sorry, the username ".$user_name. " is already registered";
            header("Location: index.php?action=error");             
            exit();
        }
    $stmt->closeCursor();
        
    //echo '2';
    $stmt = $this->dbc->prepare("SELECT * FROM ".$this->dbname.".users WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    if ($stmt->rowCount()>=1)
        {
        //$error_message = "Sorry, the email ".$email. " is already in use";
        //require('.\errors\database_error.php');
        $_SESSION['Errors'] = "<br/>"."Sorry, the email ".$email. " is already in use";
        header("Location: index.php?action=error");
        exit();
        }       
    $stmt->closeCursor();
        
    $stmt = $this->dbc->prepare("insert into ".$this->dbname.".users (user_name,password,email,registratoinDate) VALUES (:user_name,:password,:email,NOW())");
    $stmt->bindParam(":user_name", $user_name);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        {
        //$error_message = "Sorry, the record cannot be inserted. Please, contact someone ASAP.";
        //require('.\errors\database_error.php');
        $_SESSION['Errors'] = "<br/>"."Sorry, the record cannot be inserted.";
        header("Location: index.php?action=error");
        exit();
        }  
    else
        {
        return true;
        }
    $stmt->closeCursor(); 
    } 
    catch(PDOException $e)
    {
        //$error_message = $e->getMessage();
        //require('.\errors\database_error.php');
        $_SESSION['Errors'] = "<br/>".$e->getMessage();
        header("Location: index.php?action=error");
        exit();
    }
    
}


function signIn($user_name, $password){
    
    $stmt = $this->getUser($user_name); 
    $row = $stmt->fetch();
   
    if (password_verify($password,$row['password']) == true)
    {
        return true;
    }
    else
    {
        //$error_message = "<br/>Sorry, the password you entered is incorrect";
        //require('.\errors\database_error.php');
        $_SESSION['Errors'] = "<br/>"."Sorry, the password you entered is incorrect";
        header("Location: index.php?action=error");
        exit();
    }   

}    
    
/*private function getUserEmail($user_name, $email){

    
    $stmt = $this->dbc->prepare("SELECT * FROM ".$this->dbname.".users WHERE user_name = :user_name and  email = :email");
    $stmt->bindParam(":user_name", $user_name);
    $stmt->bindParam(":email", $email);        
    $stmt->execute();
    if ($stmt->rowCount()==0)
        {
        $stmt->closeCursor();
        $error_message = "Pair ".$user_name." ".$email. " cannot be found in the database";
        require('.\errors\database_error.php');
        exit();
        }
    else if ($stmt->rowCount()>=2)
    {
        $stmt->closeCursor();
        $error_message = "Pair ".$user_name." ".$email. " returns more than one record";
        require('.\errors\database_error.php');
        exit();
    }
     else {
         return $stmt;
     }
}
*/
public function getUser($user_name){

    
    $stmt = $this->dbc->prepare("SELECT * FROM ".$this->dbname.".users WHERE user_name = :user_name");
    $stmt->bindParam(":user_name", $user_name);
    $stmt->execute();
    if ($stmt->rowCount()==0)
        {
        $stmt->closeCursor();
        //$error_message = "Error: user ".$user_name." can not be found in the database";
        //require('.\errors\database_error.php');
        $_SESSION['Errors'] = "<br/>". "Error: user ".$user_name." can not be found in the database";
        header("Location: index.php?action=error");        
        exit();
        }
    else if ($stmt->rowCount()>=2)
    {
        $stmt->closeCursor();
       // $error_message = "Error: there are more then one record corresponds to username ".$user_name.".";
       // require('.\errors\database_error.php');
        $_SESSION['Errors'] = "<br/>". "Error: there are more then one record corresponds to username ".$user_name.".";
        header("Location: index.php?action=error");   
        exit();
    }
     else {
         return $stmt;
     }
}    




function delete_book_by_id($book_id){
  
    if (is_numeric($book_id)) {
    $sql = "DELETE FROM books_info WHERE book_id = :book_id";

    $cmd = $this->dbc->prepare($sql);
    $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $cmd->execute();
    // disconnect
    //$conn = null;
    }
}

function get_all_books() {

    $sql = "SELECT * FROM books_info ORDER BY book_id";

    // run the query and store the results into memory
    $cmd = $this->dbc->prepare($sql);
    $cmd -> execute();
    $books = $cmd->fetchAll();
    return $books;
}

function get_book_by_id($book_id) {

    $sql = "SELECT * FROM books_info where book_id =:book_id";

    // run the query and store the results into memory
    $cmd = $this->dbc->prepare($sql);
    $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $cmd -> execute();
    $books = $cmd->fetchAll();
    return $books;
}


function add_new_book($book_id,$title,$book_genre,$book_review,$name,$email,$url,$image)
{
if (empty($book_id))//new record
    {
    $sql = 'INSERT INTO books_info (`book_title`, `book_genre`, `book_shortreview`, `user_name`, `user_email`, `book_url`, `book_image`) values '.
    '(:book_title, :book_genre, :book_shortreview, :user_name, :user_email, :book_url, :book_image)';
    $cmd = $this->dbc->prepare($sql);
    }

else //updating old record
    {
    $sql = 'UPDATE books_info SET `book_title`=:book_title, `book_genre`=:book_genre, `book_shortreview`=:book_shortreview, `user_name`=:user_name, `user_email`=:user_email, `book_url`=:book_url, `book_image`=:book_image WHERE book_id=:book_id';
    $cmd = $this->dbc->prepare($sql);
    $cmd->bindParam(':book_id',$book_id);				
    }	

    $cmd->bindParam(':book_title',$title);
    $cmd->bindParam(':book_genre',$book_genre);
    $cmd->bindParam(':book_shortreview',$book_review)	;
    $cmd->bindParam(':user_name',$name);
    $cmd->bindParam(':user_email',$email);
    $cmd->bindParam(':book_url',$url);
    $cmd->bindParam(':book_image',$image);		

    $cmd->execute();
}

function disconnect(){

    $this->dbc = null;

}

}
?>