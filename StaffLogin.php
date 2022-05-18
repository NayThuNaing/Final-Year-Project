<?php 
session_start();
include('connection.php');

if (isset($_POST['btnLogin']))
{
    
    $txtEmail=$_POST['txtEmail'];
    $txtPassword=$_POST['txtPassword'];
    
    //check Email and Password -------
    
    $check="SELECT * FROM Staff WHERE 
            Email='$txtEmail'
            AND Password='$txtPassword' ";
    $ret=mysqli_query($connection,$check) or die(mysqli_error($connection));
    $count=mysqli_num_rows($ret);
    $rows=mysqli_fetch_array($ret);

    if($count < 1) 
    {
        echo "<script>window.alert('ERROR : Email or password incorrect.')</script>";
        echo "<script>window.location='StaffLogin.php'</script>";
    }
    else
    {
        $_SESSION['StaffName']=$rows['StaffName'];
        $_SESSION['StaffID']=$rows['StaffID'];
        $_SESSION['StaffImage']=$rows['StaffImage'];

        echo "<script>window.alert('SUCCESS : You are login as Staff.')</script>";
        echo "<script>window.location='StaffHome.php'</script>";
    }
}
 ?>

 <!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Staff Login</title>
    <!-- Bootstrap CSS -->
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
    }
    </style>
</head>
<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="index.html"><img class="logo-img" src="assets/images/logo.png" alt="logo"></a><span class="splash-description">Please enter user information.</span></div>
            <div class="card-body">
                <form action="Stafflogin.php" method="post">
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
                    <a href="StaffEntry.php" class="footer-link">Create An Account</a></div>
               
            </div>
        </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>

