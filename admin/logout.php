<?php
 session_start();
 ?>
 <html>
 <head>
 <title>TOC-MOUL Interface - LogOut</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
 </head>
 <body background="../img/interface/interface-nexus-back.jpg">
 <?php
 $user = $_SESSION['user'];
 if(session_destroy()) {
 echo '<p align="center"><font size="4"><br><br>Bye bye '.$user.'<br>
<br>Successfully<br>Logged out!<br><br>
<a href="login.php">Back to Login</font></a></p>';
 }else{
 echo '<p align="center">When logging off, unfortunately, an error occurred!
 <br /><br />Please close your browser window.';
 }
 ?>
 </body>
 </html>