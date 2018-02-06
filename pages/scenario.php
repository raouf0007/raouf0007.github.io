<?php
    session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
<!--    <link href="Tools/css/bootstrap.css" rel="stylesheet">-->
    <script type="text/javascript" src="../Tools/jquery.js"></script>
    <script src="../Tools/popper.js"></script>
    <script src="../Tools/js/bootstrap.min.js"></script>
    <link href="../Tools/css/bootstrap.min.css" rel="stylesheet">
    <title>Scenario Mode! </title>
  </head>
<body>
<script src="scenario_script.js"></script>    

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

<!-- Receiving Data -->
<?php 
    $scenario_salary = 78000;
    $scenario_spend = 28000;
    $scenario_month = 8;
    $scenario_year = 2018;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Add Someone positive
        if(isset($_POST["scenario_salary"])){
            $scenario_salary = $_POST["scenario_salary"];
            $scenario_spend = $_POST["scenario_spend"];
            $scenario_month = $_POST["scenario_month"];
            $scenario_year = $_POST["scenario_year"];
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
    
<!-- Debts Jumbotron-->
<div class="jumbotron">
  <img src="..\img\profits.svg" width="10%" style="display: block; margin:auto;">
  <h2 class="display-3" style="text-align: center;">Scenario Mode!</h2>
  <hr class="my-4">
  <?php 
    $count_tobuy = 0;
    $account = 0;
    $pocket = 0;
    $count = 0;
    /* Calculate the total sum */
    $sql = "SELECT SUM(positive_money) FROM positive_owe WHERE positive_owe_user = '$user_name';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    $count_pos = $row["SUM(positive_money)"];
    }
    } else {
    echo "error summing";
    }
    $sql = "SELECT SUM(negative_money) FROM negative_owe WHERE negative_owe_user = '$user_name';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    $count_neg = $row["SUM(negative_money)"];
    }
    } else {
    echo "error summing";
    }
    $count = $count_pos - $count_neg;
    /* Count the Cost of toBuy list*/
    $sql = "SELECT SUM(tobuy_cost) FROM tobuy WHERE tobuy_user = '$user_name';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    $count_tobuy = $row["SUM(tobuy_cost)"];
    $count_all = $count - $count_tobuy;
    }
    } else {
    echo "error summing";
    }
    /* Getting the Account and Pocket money*/
    $sql = "SELECT positive_person, positive_money FROM positive_owe WHERE positive_owe_user = '$user_name'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row["positive_person"] == 'Account') $account = $row["positive_money"];
        if($row["positive_person"] == 'Pocket') $pocket = $row["positive_money"];
    }
    }
  ?>

<!-- The Left Side-->
<div class="row">
<div class="col-sm-6">
<p class="lead">Now, You have :</p>
    <ul  class="lead">
    <li><span style='color: #09096d; font-weight : bold;'> <?php echo $account; ?></span> D.A in your <span style='color: #09096d;'>Account.</span></li>
    <li><span style='color: #09096d; font-weight : bold;'> <?php echo $pocket; ?></span> D.A in your <span style='color: #09096d;'>Pocket.</span></li>
    <li><span style='color: #0e0e40; font-weight : bold;'> <?php echo $count; ?></span> D.A counting <span style='color: #0e0e40;'>all the debts.</span></li>
    <li><span style='color: #0e0e40; font-weight : bold;'> <?php echo $count_all; ?></span> D.A counting <span style='color: #0e0e40;'>all the debts and considering the "toBuy List".</span></li>
    </ul>
</div>
    
<!-- The Right Side -->

<div class="col-sm-6">
    <form action="scenario.php" method="post">
    <div class="row">
        <div class="col-sm-8"><p class="lead">Enter here your salary :</p></div>
        <div class="col-sm-4"><input class="form-control" type="text" value="<?php echo $scenario_salary; ?>" name="scenario_salary"></div>
    </div>
    <div class="row">
        <div class="col-sm-8"><p class="lead">Enter how much you spend a month :</p></div>
        <div class="col-sm-4"><input class="form-control" type="text" value="<?php echo $scenario_spend; ?>" name="scenario_spend"></div>
    </div>
    <div class="row">
        <div class="col-sm-8"><p class="lead">Enter until which Month you wanna save up :</p></div>
        <div class="col-sm-4">
            <select class="form-control" name="scenario_month">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8" selected>August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
            </select></div>
    </div>
    <div class="row">
        <div class="col-sm-8"><p class="lead">Enter until which Year you wanna save up :</p></div>
        <div class="col-sm-4">
            <select class="form-control" name="scenario_year">
            <option value="2018">2018</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            </select></div>
    </div>
    <div class="row">
        <div class="col-sm-8"></div>
        <div class="col-sm-4"><button class="btn btn-primary" type="submit" >Confirm</button></div>
        <br>
    </div>
</div>
</form>

<!-- Total save up -->
<p class="lead">When <?php echo $scenario_month . "/" . $scenario_year ?> comes, You'll be having :</p>
<?php
    $ecart_month = $scenario_month - date("m");
    if(date("d")<18) $ecart_month++;
    $ecart_year = $scenario_year - date("Y");
    if($ecart_month > 0) $ecart = $ecart_year * 12 + $ecart_month;
    else $ecart = ($ecart_year - 1)*12 + (12+$ecart_month);
    $save_month = $scenario_salary - $scenario_spend;
    $save_all = $save_month * $ecart;
    $all_money = $save_all + $count_all;
?>
<input type="text" readonly value="<?php echo $all_money; ?> D.A" class="form-control" style="text-align: center; color:green; font-weight : bold;">

    
<!-- End Of Jumbotron-->
</div>

<!-- End of responsive design-->
</div>
</div>
</div>
<?php $conn->close(); ?>    
</body>
</html>