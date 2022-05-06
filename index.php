<?php
    if(isset($_SESSION['email'])) {
        // echo $_SESSION['email'];
        header("Location: dashboard.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Design & Development of IoT Based Waste Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="full-page">
        <div class="navbar">
            <div>
                <a href='index.html'></a>
            </div>
            <p>Design & Development of IoT Based Waste Management System</p>
            <nav>
                <ul id='MenuItems'>
                    <li><button class='loginbtn'onclick="document.getElementById('login-form').style.display='block'"style="width:auto;">Login</button></li>
                </ul>
            </nav>          
        </div>
        <div id='login-form' class='login-page'>
            <div class="form-box">
                <div class='button-box'>
                    <div id='btn'></div>
                    <button type='button'onclick='login()'class='toggle-btn'>Log In</button>
                    <button type='button'onclick='register()'class='toggle-btn'>Register</button>
                </div>
                <!----creating the Login form---->
                <form id='login' class='input-group-login' action="php/login.php" method="POST">
                    <input type='text' name= "email" class='input-field'placeholder='Email Id'required>
                    <input type='password' name= "password"  class='input-field'placeholder='Enter Password'required>
                    <button type='submit'id="submitbtnlogin" class='submit-btn'>Log in</button>
                </form>
                
                <!----creating the registration form---->
                <form method="POST" action="php/register.php"  id='register' class='input-group-register' >
                    <input type='text' name= "firstname" id="firstname" class='input-field' placeholder='First Name' required>
                    <input type='text' name= "lastname" id="lastname" class='input-field' placeholder='Last Name' required>
                    <input type='email' name= "email" id="Email" class='input-field' placeholder='Email Id' required>
                    <input type='password' name= "password" id="Password" class='input-field' placeholder='Enter Password' required>
                    <button type='submit' name = "submit" class='submit-btn'>Register</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        <?php
            session_start();
            if($_SESSION['err-msg'])  ?>
                Swal.fire({
                    icon: 'error',
                    text: 'Invalid Credentials',
                    showCancelButton: false,
                    showCloseButton: false,
                    showConfirmButton: false,
                    timer: 1500
                });
                <?php    unset($_SESSION['err-msg']);
             
        ?>
        </script>
        <script>
        var x=document.getElementById('login');
        var y=document.getElementById('register');
        var z=document.getElementById('btn');
        function register()
        {
            x.style.left='-400px';
            y.style.left='50px';
            z.style.left='110px';
        }
        function login()
        {
            x.style.left='50px';
            y.style.left='450px';
            z.style.left='0px';
        }
    </script>
    <script>
        var modal = document.getElementById('login-form');
            window.onclick= function(event)
            {
                if(event.target == modal)
                {
                    modal.style.display="none";
                }
            }
    </script>
    
</body>        
</html>

