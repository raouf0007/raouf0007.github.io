<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <link href ="style.css" rel = "stylesheet" type ="text/css">
    <script type="text/javascript" src="Tools/jquery.js"></script>
    <link href="Tools/css/bootstrap.min.css" rel="stylesheet">
    <script src="Tools/js/bootstrap.min.js"></script>
    <title>Welcome To Mizania's Website! </title>
  </head>
<body>
<script type="text/javascript" src="index_script.js"></script>
    
<br>
<!-- Responsive-->
<div class="container">
    <p class="welcome_style">Welcome to the <span style="color: #09096d;">Mizania</span> Website, please sign in.</p>
        <div class="img_container">
            <img src=img/dollar.svg class="img_safe">
        </div>
<div class="row">

    
<!--Sign Up-->
<div class="col-sm-6">
<!--Form-->
    <p class="welcome_style">A new member? <span style="color: #09096d;">Sign Up</span> here!</p>
<div class="form_style">
<form action="home.php" method="post" name="form_sign_up">
    <div class="form-group">
    Your Name:<br>
        <input type="text" name="new_nickname" placeholder="Write your name!" class="form-control">
  <br>
    User Name:<br>
        <input type="text" name="new_user" placeholder="Must be unique " class="form-control">
  <br>
  Password:<br>
  <input type="password" name="new_pswd" placeholder="******" class="form-control">
  <br>
  Repeat Password:<br>
  <input type="password" name="new_pswd_confirm" placeholder="******" class="form-control">
  <br><br>
  <input type="button" value="Submit" class="btn btn-success" onclick="control_sign_up()">
  <input type="reset" class="btn btn-danger">
  </div>
</form> 
</div>
</div>
    
<!--Sign in-->
<div class="col-sm-6">
<!--Form-->
    <p class="welcome_style">Already a member? <span style="color: #09096d;">Sign In</span> here!</p>
<div class="form_style">
<form action="home.php" method="post" name="form_sign_in">
    <div class="form-group">
    User Name:<br>
        <input type="text" name="user" id="user" placeholder="Write your user name!" class="form-control">
  <br>
  Password:<br>
  <input type="password" name="pswd" id="pswd" placeholder="******" class="form-control">
  <br><br>
  <input type="button" value="Submit" class="btn btn-success"  onclick="control()">
  <input type="reset" class="btn btn-danger">
  </div>
</form> 
</div>
<span style="color: #09096d; float: right;">By: Lt. Raouf</span>
</div>

<!--Responsive design-->    
</div></div>

<!--Destroy the session-->
<?php session_destroy(); ?>  
</body>
</html>