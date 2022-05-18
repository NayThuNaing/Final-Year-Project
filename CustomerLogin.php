<?php 
session_start();
include('connection.php');

if (isset($_POST['btnLogin']))
{
    
    $txtEmail=$_POST['txtEmail'];
    $txtPassword=$_POST['txtPassword'];
    
    //check Email and Password -------
    
    $check="SELECT * FROM Customer WHERE 
            Email='$txtEmail'
            AND Password='$txtPassword' ";
    $ret=mysqli_query($connection,$check) or die(mysqli_error($connection));
    $count=mysqli_num_rows($ret);
    $rows=mysqli_fetch_array($ret);

    if($count < 1) 
    {
        echo "<script>window.alert('ERROR : Email or password incorrect.')</script>";
        echo "<script>window.location='CustomerLogin.php'</script>";
    }
    else
    {
        $_SESSION['CustomerName']=$rows['CustomerName'];
        $_SESSION['CustomerID']=$rows['CustomerID'];
        $_SESSION['Image']=$rows['Image'];

        echo "<script>window.alert('SUCCESS : You are login as Customer.')</script>";
        echo "<script>window.location='ProductDisplay.php'</script>";
    }
}
 ?>
<!--
 <!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags --><!--
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Customer Login</title>
    <!-- Bootstrap CSS --><!--
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;  
        background:url(../BackgroudImage/background.jpg);
        background-size:cover;

    }
    </style>
</head>
<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== 
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="index.html"><img class="logo-img" src="assets/images/logo.png" alt="logo"></a><span class="splash-description">Please enter user information.</span></div>
            <div class="card-body">
                <form action="CustomerLogin.php" method="post" >
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="Email" name="txtEmail" placeholder="example@gmail.com" required >
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="password" name="txtPassword" placeholder="password" required >
                    </div>
                   
                    <button type="submit" name="btnLogin" value="Login" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="CustomerEntry.php" class="footer-link">Create An Account</a></div>
               
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript 
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>

-->

<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Water Template</title>
	<link rel="stylesheet" type="text/css" href="css/Bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>

	<div>
		<img class="water img-responsive" src="img/login.png">
		<div class="container">
			
			<div class="login-container">
            <form action="CustomerLogin.php" method="post" >
					<img class="login2 img-responsive" src="img/login2.png">
					<h2>Welcome</h2>
					<div class="input-div">
						<div class="i">
							<i class="fas fa-user one" ></i>
						</div>
						<div>
							<h5>User Name</h5>
							<input class="input" type="text" name="txtEmail" placeholder="Enter User Name or Email" required/>
							</div>
						</div>
						<div class="input-div">
							<div class="i">
								<i class="fas fa-lock two"></i>
							</div>
							<div>
							<h5>Password</h5>
							<input type="password" class="input" name="txtPassword" placeholder="Enter your Password" required/ >
						</div></div>
						<a href="CustomerEntry.php">Create An Account? </a>
						<input type="submit" class="btn btn-default" value="login" name="btnLogin">
						
					
				</form>
			</div>
		</div>
		
	</div>
		



	<script src="js/jquery-1.12.4.min.js"></script>
	<script src="js/login.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
