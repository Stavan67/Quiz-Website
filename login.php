<?php
ob_start();
session_start();
include "connection.php";
 
if (isset($_POST["login"])) 
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) 
    {
        echo '<div class="alert alert-danger">Both fields must be filled out</div>';
    } 
    else 
    {
        $res = mysqli_query($link, "select * from registration where username='$username' && password='$password'");
        $count = mysqli_num_rows($res);

        if ($count == 0) 
        {
            echo '<div class="alert alert-danger">Invalid Username or Password</div>';
        } 
        else 
        {
            $_SESSION['username'] = $username;
            header("Location: quiz.html");
        }
    }
}
?>


<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>
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
        }

        .content-error 
        {
            margin-top: 20px;
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

        .btn 
        {
            display: block;
            width: 60px;
            padding: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-success 
        {
            background-color: #4caf50;
            color: #fff;
        }

        .btn-success:hover 
        {
            background-color: #45a049;
        }

        .btn-default 
        {
            background-color: #ccc;
            color: #000;
            width: 60px;
        }

        .btn-default:hover 
        {
            background-color: #bbb;
        }

        .alert 
        {
            padding: 10px;
            margin-top: 10px;
            display: none;
            border-radius: 3px;
            background-color: #f44336;
            color: #fff;
        }
    </style>
</head>

<body>
<div class="name">Quiz Login</div>
	<div class="error-pagewrap">
		<div class="error-page-int">
			<div class="text-center m-b-md custom-login">
				<h3>LOGIN</h3>
			</div>
			<div class="content-error">
				<div class="hpanel">
                    <div class="panel-body">
                        <form action="" name="form1" method="post">
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="e.g. Steve67" title="Please enter you username" required="" value="" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                            </div>
                            <button type="submit" name="login" class="btn btn-success btn-block loginbtn">Login</button>
                            <a class="btn btn-default btn-block" href="register.php">Register</a>
                            <div class="alert alert-danger" id="failure" style="margin-top: 10px; <?php if ($count == 0) echo 'display: block;'; else echo 'display: none;'; ?>">
                                <strong>Does not match!</strong> Invalid Username or Password
                            </div>
                        </form>
                    </div>
                </div>
			</div>
		</div>   
    </div>
</body>
</html>