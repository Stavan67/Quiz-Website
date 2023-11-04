<?php
ob_start();
session_start();
include "connection.php";

if (isset($_POST["submit"])) 
{
    $count = 0;
    $res = mysqli_query($link, "select * from registration where username='$_POST[username]'") or die(mysqli_error($link));
    $count = mysqli_num_rows($res);

    if ($count > 0) 
    {
        echo '<script type="text/javascript">alert("This username already exists.");</script>';
    } else 
    {
        mysqli_query($link, "insert into registration values(NULL,'$_POST[firstname]','$_POST[lastname]','$_POST[username]','$_POST[email]','$_POST[password]','$_POST[contact]')") or die(mysqli_error($link));

        $_SESSION['username'] = $_POST['username'];

        header("Location: quiz.html"); 
        exit();
    }        
}
?>


<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Register Now</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body 
        {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
        }
        .name
        {
            text-align: center;
            font-weight: bold;
            font-size: 40px;
            padding-top: 10px;
            padding-bottom: 20px;
            background-color: darkblue;
            color: white;
        }

        .error-page-int
        {
            width: 80%;
            max-width: 500px;
            margin: 50px auto 0;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 50px;
        }

        .custom-login h3 
        {
            text-align: center;
            padding-bottom: 20px;
        }

        .content-error 
        {
            margin-top: 10px;
        }

        .form-group 
        {
            margin-bottom: 20px;
        }

        label 
        {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] 
        {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .btn-success 
        {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-success:hover 
        {
            background-color: #45a049;
        }

        .alert 
        {
            padding: 10px;
            margin-top: 10px;
            display: none;
            border-radius: 3px;
        }

        .alert-success 
        {
            background-color: #4caf50;
            color: #fff;
        }

        .alert-danger 
        {
            background-color: #f44336;
            color: #fff;
        }
    </style>
    <script>
            function validateRegistrationForm() 
            {
                var firstname = document.forms["form1"]["firstname"].value;
                var lastname = document.forms["form1"]["lastname"].value;
                var username = document.forms["form1"]["username"].value;
                var email = document.forms["form1"]["email"].value;
                var password = document.forms["form1"]["password"].value;
                var contact = document.forms["form1"]["contact"].value;

            if (firstname === "" || lastname === "" || username === "" || email === "" || password === "" || contact === "") 
            {
                alert("All fields must be filled out");
                return false;
            }
            var emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            if (!email.match(emailPattern)) 
            {
                alert("Invalid email format. Please use a Gmail address.");
                return false;
            }

            if (contact.length !== 10) 
            {
                alert("Contact number must be exactly 10 digits long.");
                return false;
            }
            }
    </script>
</head>
<body>
    <div class="name">Quiz Registration</div>
	<div class="error-pagewrap">
		<div class="error-page-int">
			<div class="text-center custom-login">
				<h3>Register Now</h3>
			</div>
			<div class="content-error">
				<div class="hpanel">
                    <div class="panel-body">
                        <form action="" name="form1" method="post" onsubmit="return validateRegistrationForm();">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label>First Name</label>
                                    <input type="text" name="firstname" class="form-control">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Last Name</label>
                                    <input type="text" name="lastname" class="form-control">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Contact</label>
                                    <input type="text" name="contact" class="form-control">
                                </div>
                            </div>
                            <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-success loginbtn">Register</button>
                            </div>
                            <div class="alert alert-success" id="success" style="margin-top: 10px; display: none">
                                <strong>Success!</strong> Account  Registration succesfully.
                            </div>
                            <div class="alert alert-danger" id="failure" style="margin-top: 10px; display: none">
                                <strong>Already exist</strong> This username already exist.
                            </div>
                        </form>
                    </div>
                </div>
			</div>
		</div>   
    </div>
</body>
</html>