<?php
    session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="../Tools/jquery.js"></script>
    <script src="../Tools/popper.js"></script>
    <script src="../Tools/js/bootstrap.min.js"></script>
    <link href="../Tools/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin DushBoard! </title>
  </head>
<body>
<script type="text/javascript" src="admin_script.js"></script>
    
<!-- Responsive-->
<div class="row">
<div class="col-sm-12">

<!--Connect the DB -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mizania";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "<br><p>Connected successfully</p>";
?>
    
<!-- Start the session   -->
    <?php
    if(!isset($_SESSION["user"])) header('location:..\index.php');
    else $user_name = $_SESSION["user"];
?>

<!-- Fuck a user-->
<?php
$confirmed = "";
if(isset($_POST["user_to_fuck"])){
    $user_to_fuck = $_POST["user_to_fuck"];
    $sql1 = "DELETE FROM user WHERE user_name = '$user_to_fuck' ";
    $sql2 = "DELETE FROM positive_owe WHERE positive_owe_user = '$user_to_fuck' ";
    $sql3 = "DELETE FROM sold WHERE sold_user = '$user_to_fuck' ";
    $sql4 = "DELETE FROM negative_owe WHERE negative_owe_user = '$user_to_fuck' ";
    $sql5 = "DELETE FROM tobuy WHERE tobuy_user = '$user_to_fuck' ";
    $sql6 = "DELETE FROM daily WHERE daily_user = '$user_to_fuck' ";
    if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE && $conn->query($sql4) === TRUE && $conn->query($sql5) === TRUE && $conn->query($sql6) === TRUE ) {
    $confirmed = $user_to_fuck . "has been fucked succefully";
    } 
    else echo "Error deleting record: " . $conn->error;
}
?>
    
<!-- Navigation Bar-->
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Mizania</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="cursor:pointer;" id="about_us">About US</a>
      </li>
<!--  Drop down list    -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Sections
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="sold.php">Sold</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="scenario.php">Scenario Mode</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="owe.php">Debts</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="tobuy.php">ToBuy List</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="daily.php">Daily's Budget</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href='../index.php'>LogOut</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" id="#search">Search</button>
    </form>
  </div>
</nav>

<!-- Sold Jumbotron-->
<div class="jumbotron">
  <img src="..\img\admin.svg" width="15%" style="display: block; margin:auto;">
  <h1 class="display-3" style="text-align: center;">Admin DushBoard</h1>
    <!--Receiving Data-->
  <hr class="my-4">
  <p class="lead" style="text-align: center;">
    <a class="btn btn-primary btn-lg" href="#" role="button" id="show" >Start Fucking</a>
  </p>
    <!--Fucking    -->
    <div class="fuck">
           <p style="color:blue;"><?php echo $confirmed; ?></p>
           <p>Fuck them all!</p>
    <div class="row">
    <div class="col-sm-3">
    <form action="admin.php" method="post">
        <select class="form-control" name="user_to_fuck">
        <?php 
                //Write the names of users here7
                $sql = "SELECT user_name FROM user";      
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {          //If not empty
                // output data of each row
                while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
                echo "<option value ='" . $row['user_name'] . "'>" . $row["user_name"] . "</option>";
                }
                } else {
                echo "0 results";
                }
        ?>
        </select>
        </div>
   <div class="col-sm-3">
                <button type="submit" class="btn btn-info">Fuck</button>
   </div>
   </div>
   </div>
   </form>
<!-- End of Jumbotron-->
</div>

<!-- End of responsive design-->
</div>
</div>

</body>
</html>