<?php

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];


$conn = mysqli_connect('localhost','root','','user_registration');
if($conn->connect_error){
    die('Connection failed : '.$conn->connect_error);
}
else{
    $stmt = $conn->prepare("insert into registration(firstname,lastname,email,password)values(?,?,?,?)");
    $stmt->bind_param("ssss",$firstname,$lastname,$email,$password);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $firstname." ".$lastname;
    header("Location: ../dashboard.php");
}
?>