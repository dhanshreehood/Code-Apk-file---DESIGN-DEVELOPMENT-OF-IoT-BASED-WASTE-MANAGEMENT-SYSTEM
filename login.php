<?php

$email = $_POST['email'];
$password = $_POST['password'];


$conn = new mysqli('localhost','root','','user_registration');
if($conn->connect_error){
    die('Connection failed : '.$conn->connect_error);
}
else{
        $log = false;
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        if($email !="" && $password !=""){
                $sql = "select * from registration where email ='".$email."' and password ='".$password."'";
                $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        $data = $result->fetch_assoc();
                        $log = true;
                        session_start();
                        $_SESSION['email'] = $data['email'];
                        $_SESSION['name'] = $data['firstname']." ".$data['lastname'];
                        $conn->close();
                        header("Location: ../dashboard.php");
                    }

            
        }
        if(!$log)
        {
            session_Start();
            $_SESSION['err-msg'] = "Invalid email and password";
            header("Location: ../index.php");
        }
        
        
    

    
    
}
?>