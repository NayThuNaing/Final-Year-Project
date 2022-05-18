<?php  
session_start();
session_destroy();
echo "<script>window.alert('Logout Successuflly')</script>";
echo "<script>window.location='Stafflogin.php'</script>";
?>