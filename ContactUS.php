<?php 

include('connection.php');
if (isset($_POST['btnSave']))
{
  $txtCustomerName=$_POST['txtCustomerName'];
  $txtEmail=$_POST['txtEmail'];
  $txtDescription=$_POST['txtDescription'];

     $Insert="INSERT INTO `CustomerFeedback`(`CustomerName`, `Email`, `Description`) VALUES 
         ('$txtCustomerName','$txtEmail','$txtDescription') ";
    $ret=mysqli_query($connection,$Insert);

    if($ret) //True
    {
      echo "<script>window.alert('SUCCESS : Thanks you for your Feedback.')</script>";
      echo "<script>window.location='ProductDetail.php'</script>";
    }
    else
    {
      echo "<p>Error : Something went wrong in Feedback" . mysqli_error($connection) . "</p>";
    }


}

 ?>
<!DOCTYPE html> 
<html>

<head>
  <title>Contact US</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
</head>

<body>
  <form action="ContactUS.php" method="POST">
  <div id="main">

    <header>
	  <div id="strapline">
	    <div id="welcome_slogan">
	      <h3>Water Bottle <span>Selling</span></h3>
	    </div><!--close welcome_slogan-->
      </div><!--close strapline-->	  
	  <nav>
	    <div id="menubar">
          <ul id="nav">
            <li><a href="ProductDisplay.php">Home</a></li>
            <li><a href="CustomerLogin.php">Login </a></li>
            <li><a href="Checkout.php">My Vounchers</a></li>
            <li><a href="ShoppingCart.php">My Orders</a></li>
            <li class="current"><a href="ContactUs.php">Contact Us</a></li>
          </ul>
        </div><!--close menubar-->	
      </nav>
    </header>
    
	<div id="site_content">

	  <div class="sidebar_container">       
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>New Website</h2>
            <p>Welcome to our new website. Please have a look around, any feedback is much appreciated.</p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->     		
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>Latest Update</h2>
            <h3>March 2020</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque cursus tempor enim.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>February 2020</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque cursus tempor enim.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->  		
        <div class="sidebar">
          <div class="sidebar_item">
            <h2>Contact</h2>
            
            <p>Phone: +95 (0)9772803152</p>
            <p>Email: <a href="mailto:info@youremail.co.uk">info@moonsunmail.co.uk</a></p>
            <h2>Operating Hours</h2>
            <p>Monday - Friday: 8am - 5:00pm
              Closed on Public Holidays</p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
       </div><!--close sidebar_container-->	
	   
      <div class="slideshow">
	    <ul class="slideshow">
          <li class="show"><img width="680" height="250" src="images/home_1.jpg" alt="&quot;Enter your caption here&quot;" /></li>
          <li><img width="680" height="250" src="images/home_2.jpg" alt="&quot;Enter your caption here&quot;" /></li>
        </ul> 
	  </div>
	
	  <div id="content">
        <div class="content_item">
		  <div class="form_settings">
            <h2>Contact Us</h2>
            <p style="padding-bottom: 15px;">A contact form requires some method of emailing the contents of the form to an email address. The most common way to do this is to use some kind of server script (PHP for example). I would be happy to send you the PHP code for the contact form for your chosen template, I charge &pound;20.00GBP for this. Simply <a>contact me</a> for more details.</p>           
			<p><span>Name</span><input class="contact" type="text" name="txtCustomerName" value="" /></p>
            <p><span>Email Address</span><input class="contact" type="text" name="txtEmail" value="" /></p>
			<p><span>Message</span><textarea class="contact textarea" rows="8" cols="50" name="txtDescription"></textarea></p>
            <p style="padding: 10px 0 10px 0;">Please enter the answer to this simple maths question (to prevent spam)</p>
			<p><span>Maths Question: 9 + 3 = ?</span><input type="text" name="user_answer" class="contact" /><input type="hidden" name="answer" value="4d76fe9775" /></p>
            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="btnSave" value="Send" /></p>
          </div><!--close form_settings-->
		</div><!--close content_item-->
      </div><!--close content-->   
	</div><!--close site_content-->  	
    <footer>
	  <a href="ProductDisplay.php">Home</a> | <a href="CustomerLogin.php">Login</a> | <a href="Checkout.php">My Vouchers</a> | <a href="ShoppingCart.php">My Orders</a> | <a href="ContactUS.php">Contact US</a><br/><br/>
	  <a href="http://fotogrph.com">Images</a> |  <a href="http://www.heartinternet.co.uk/web-hosting/">Web Hosting</a>  | Water bottles seller<a href="http://www.freehtml5templates.co.uk">Moon and Sun</a>
    </footer>  
  </div><!--close main-->

  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/image_slide.js"></script>	
  </form>
</body>
</html>
