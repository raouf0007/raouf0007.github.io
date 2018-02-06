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
    <title>Daily's Budget </title>
  </head>
<body>
<script type="text/javascript" src="daily_script.js"></script>
    
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

<!-- Receiving the info && Treating Data -->
<?php
  $confirmed = '';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Add Someone positive
        if(isset($_POST["daily_hidden"])){
        $daily_to_add = $_POST["daily_hidden"] - $_POST["daily_spent"] + 900;
        $sql = "INSERT INTO daily (daily_date, daily_money, daily_user) VALUES ('" . date('Y/m/d') . "', " . $daily_to_add . ", '$user_name')";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "Budget has been Updated successfully!!";
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }
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

<!-- Daily Jumbotron-->
<div class="jumbotron">
  <img src="..\img\daily.svg" width="10%" style="display: block; margin:auto;">
  <h2 class="display-3" style="text-align: center;">Daily's Budget!</h2>
  <hr class="my-4">
    <!--Receiving Data-->
  <?php
    $sql = "SELECT daily_money, daily_date FROM daily WHERE daily_user = '$user_name' ORDER BY daily_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    $daily = $row["daily_money"];
    $date = $row["daily_date"];
    }
    }
    else header('location:..\home.php');
    echo "<p class='lead'>You have <span style='color: #09096d; font-weight : bold;'>" . $daily . " D.A</span> in your Daily's Budget at the moment.</p>";
   ?>
    
  <!--Form-->
    <form method="post" action="daily.php">
    <div class="row">
    <div class="col-sm-3">
    <input name="daily_hidden" type="hidden" value="<?php echo $daily; ?>">
    <input type="text" name="daily_spent" placeholder="How much money spent today" class="form-control">  
    </div>
    <div class="col-sm-3">
        <button type="submit" class="btn btn-info">Add New Budget</button>
   </div>
   </div>
   </form>
   <p style="color:blue;"><?php echo $confirmed; ?></p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="#start" role="button" id="show">View History</a>
  </p>
    <!-- History of Daily    -->
<div class="table-responsive">
    <table class="table table-striped" style="width: 30%; border: 3px solid rgba(85, 94, 98, 0.66);">
        <tr>
            <th>Date</th>
            <th>Budget</th>
        </tr>
    <?php
    $sql = "SELECT daily_money, daily_date FROM daily  WHERE daily_user = '$user_name' ORDER BY daily_id DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    /*Show the rows*/
    echo "<tr>" .
    "<td>" . $row["daily_date"]. "</td><td>" . $row["daily_money"]. "</td></tr>";
    }
    /*Show the sum*/
    $sql = "SELECT SUM(daily_money) FROM daily WHERE daily_user = '$user_name'";      
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) {
    echo "<tr><th>Total</th><th>" . $row["SUM(daily_money)"]. "</th><tr>";
    }
    } else {
    echo "0 results";
    }
    } else {
    echo "0 results";
    }
    $conn->close();
    ?>
    </table>
</div>
<p style="float: right;"><?php echo "<span style='color: #09096d; font-weight : bold;'>" . $date . "</span>" ?></p>

</div>

<!-- End of responsive design-->
</div>
</div>

</body>
</html>