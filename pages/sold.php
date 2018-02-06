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
    <title>Sold! </title>
  </head>
<body>
<script type="text/javascript" src="sold_script.js"></script>
    
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
  <img src="..\img\safebox.svg" width="10%" style="display: block; margin:auto;">
  <h2 class="display-3" style="text-align: center;">Sold!</h2>
  <hr class="my-4">
    <!--Receiving Data-->
  <?php
    $sql = "SELECT sold_money, sold_date FROM sold WHERE sold_user = '$user_name' ORDER BY sold_date";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    $sold = $row["sold_money"];
    $date = $row["sold_date"];
    }
    }
    else header('location:..\home.php');
    echo "<p class='lead'>You have <span style='color: #09096d; font-weight : bold;'>" . $sold . " D.A</span> in your account at the moment.</p>";
   ?>
  <p>Last time your sold had been changed: <?php echo "<span style='color: #09096d; font-weight : bold;'>" . $date . "</span>" ?></p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="#start" role="button" id="show">View History</a>
  </p>
    <!-- History of Sold    -->
<div class="table-responsive">
    <table class="table table-striped" style="width: 30%; border: 3px solid rgba(85, 94, 98, 0.66);">
        <tr>
            <th>Date</th>
            <th>Sold</th>
        </tr>
        
    <?php
    $sql = "SELECT sold_money, sold_date FROM sold  WHERE sold_user = '$user_name' ORDER BY sold_date DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    echo "<tr>" .
    "<td>" . $row["sold_date"]. "</td><td>" . $row["sold_money"]. "</td></tr>";
    }
    } else {
    echo "0 results";
    }
    $conn->close();
    ?>
    </table>
</div>    

</div>

<!-- End of responsive design-->
</div>
</div>

</body>
</html>