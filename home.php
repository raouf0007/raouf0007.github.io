<?php
    session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
<!--    <link href="Tools/css/bootstrap.css" rel="stylesheet">-->
    <link href ="style_action.css" rel = "stylesheet" type ="text/css">
    <script type="text/javascript" src="Tools/jquery.js"></script>
    <script src="Tools/popper.js"></script>
    <script src="Tools/js/bootstrap.min.js"></script>
    <link href="Tools/css/bootstrap.min.css" rel="stylesheet">
    <title>Welcome again! </title>
  </head>
<body>
<script type="text/javascript" src="home_script.js"></script>
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
        
<!-- Receiving the info && SESSION   -->
     <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Sign Up
    if(isset($_POST["new_user"])){
    $user_name = $_POST['new_user'];
    $user_password = $_POST['new_pswd'];
    $user_nickname = $_POST['new_nickname'];
    //Upper Case
    $user_nickname = ucfirst($user_nickname);
      $sql = "INSERT INTO user (user_name, user_password, user_nickname) VALUES ( '$user_name' , '$user_password', '$user_nickname' )";      
    if ($conn->query($sql) === FALSE) 
    echo "Error: " . $sql . "<br>" . $conn->error;
    //Add Pocket and Account
    $sql = "INSERT INTO positive_owe (positive_person, positive_money, positive_owe_user) VALUES ('Account', " . 0 . ", '$user_name'), ('Pocket', " . 0 . ", '$user_name')";
    if ($conn->query($sql) === FALSE) echo "Error: " . $sql . "<br>" . $conn->error;
    //Add toBUY
    $sql = "INSERT INTO tobuy (tobuy_item, tobuy_cost, tobuy_user) VALUES ('Lunch to Lt. Raouf', " . 1000 . ", '$user_name')";
    if ($conn->query($sql) === FALSE) echo "Error: " . $sql . "<br>" . $conn->error;
    //Add Daily's Budget
    $sql = "INSERT INTO daily (daily_date, daily_money, daily_user) VALUES ('" . date('Y/m/d') . "', " . 800 . ", '$user_name')";
    if ($conn->query($sql) === FALSE) echo "Error: " . $sql . "<br>" . $conn->error;
    //Sign In After it
    $sql = "SELECT user_password FROM user WHERE user_name = '$user_name' "; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    if($user_password != $row["user_password"]) header('location:index.php');
    else $_SESSION["user"] = $user_name;
    }
    }
    else header('location:index.php');
    }
        
    //Sign In
    if(isset($_POST["user"])){
    $user_name = $_POST['user'];
    $user_password = $_POST['pswd'];
    $sql = "SELECT user_password, user_nickname FROM user WHERE user_name = '$user_name' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    if($user_password != $row["user_password"])
        header('location:index.php');
    else {$_SESSION["user"] = $user_name;
          $user_nickname = $row["user_nickname"];
          //Upper Case
          $user_nickname = ucfirst($user_nickname);
         }
    }
    }
    else header('location:index.php');
    }
        
    }
    if(!isset($_SESSION["user"])) header('location:index.php');
    //IN CASE YOU ACCESS THE HOME from scenario
    else {
        $user_name = $_SESSION["user"];
        $sql = "SELECT user_nickname FROM user WHERE user_name = '$user_name' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {          //If not empty
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $user_nickname = $row["user_nickname"];
          //Upper Case
          $user_nickname = ucfirst($user_nickname);
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
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
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
          <a class="dropdown-item" href="pages/sold.php">Sold</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="pages/scenario.php">Scenario Mode</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="pages/owe.php">Debts</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="pages/tobuy.php">ToBuy List</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="daily.php">Daily's Budget</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href='index.php'>LogOut</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" id="#search">Search</button>
    </form>
  </div>
</nav>
    
<!--Welcome Jumbotron-->
<div class="jumbotron">
  <h1 class="display-3">Hello, Mr: <?php echo $user_nickname; ?>!</h1>
  <p class="lead">Welcome to the Mizania Website, where you can manage how you spent your money and how to save up in a more successful and efficient way.</p>
  <hr class="my-4">
  <p>We use many algorithms and databases to make sure you make the best decisions concering saving up your money, there are many sections shown below, every section will guide you to do something specific with your money, either how much money do you have in your safe, or how much will you be making in the next 6 months, and many more sections, it's all up to you!</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="#start" role="button">Let's start!</a>
  </p>
</div>
    <p id="start"><br><br></p>
    
<!-- Porn style   -->
<section class="container">
  <div class="row"> <!-- Define what do you put in this row that contains 12 Grid columns -->
    
    <?php
    $user_name = $_SESSION["user"];
    $sql = "SELECT sold_money, sold_date FROM sold WHERE sold_user = '$user_name'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    //Show the sold
    ?>
    <figure class="col-sm-4"> <!-- Define what you put in every block, three images per row -->
    <span id="img_title">Sold</span>
    <div class = "img_container">
        <a href="pages/sold.php" target="_blank"><img src = 'img/safebox.svg' class="img_safe"></a>
    </div>
    </figure>
    <?php
    }
    ?>
    
    <figure class="col-sm-4">
    <span id="img_title">Scenario Mode</span>
    <div class = "img_container">
        <a href="pages/scenario.php"><img src = 'img/profits.svg' class="img_safe"></a>
    </div>
    </figure>
    <figure class="col-sm-4">
    <span id="img_title">To Buy List</span>
    <div class = "img_container">
        <a href="pages/tobuy.php"><img src = 'img/wallet.svg' class="img_safe"></a>
    </div>
    </figure>
    <figure class="col-sm-4">
    <span id="img_title">Who Owe you? You Owe Whom?</span>
    <div class = "img_container">
        <a href="pages/owe.php"><img src = 'img/balance.svg' class="img_safe"></a>
    </div>
    </figure>
    <figure class="col-sm-4">
    <span id="img_title">Daily's Money</span>
    <div class = "img_container">
        <a href="pages/daily.php"><img src = 'img/daily.svg' class="img_safe"></a>
    </div>
    </figure>
    
    <?php if($user_name == "raouf") { ?>
    <figure class="col-sm-4">
    <span id="img_title">Admin DushBoard</span>
    <div class = "img_container">
        <a href="pages/admin.php"><img src = 'img/admin.svg' class="img_safe"></a>
    </div>
    </figure>
    <?php } $conn->close(); ?>
  </div>
</section>  
    
<!-- Modal -->
    
<!-- Footer    -->

</div>
</div>
    
</body>
</html>