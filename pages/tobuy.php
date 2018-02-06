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
    <title>ToBuy List! </title>
  </head>
<body>
<script type="text/javascript" src="tobuy_script.js"></script>
    
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
    $confirmed = "";
    $added = '';
    $count_cost = 0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Add an item
        if(isset($_POST["tobuy_item"])){
        $tobuy_item = $_POST["tobuy_item"];
        /* Upper */ $tobuy_item = ucfirst($tobuy_item);
        $tobuy_cost = $_POST["tobuy_cost"];
        $sql = "INSERT INTO tobuy (tobuy_item, tobuy_cost, tobuy_user) VALUES ('$tobuy_item', " . $tobuy_cost . ", '$user_name')";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "An Item has been added successfully!!";
        $added = $tobuy_item;
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }
        
        //Delete an item
        if(isset($_POST["tobuy_delete"])){
        $tobuy_delete = $_POST["tobuy_delete"];
        $sql = "DELETE FROM tobuy WHERE tobuy_item='$tobuy_delete' AND tobuy_user = '$user_name'";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "An item has been deleted successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
                }
        }
        
        //Delete ALL
        if(isset($_POST["tobuy_delete_all"])){
        $sql = "DELETE FROM tobuy WHERE tobuy_user = '$user_name'";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "The table has been emptied successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
                }
        }
        
        //Edit an item
        if(isset($_POST["tobuy_edit"])){
        $tobuy_item = $_POST["tobuy_edit"];
        /* Upper */ $tobuy_item = ucfirst($tobuy_item);
        $tobuy_cost = $_POST["tobuy_edit_cost"];
        $sql = "UPDATE tobuy SET tobuy_cost = " . $tobuy_cost . " WHERE tobuy_item = '$tobuy_item' AND tobuy_user = '$user_name'";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "The Price has been updated successfully";
        $added = $tobuy_item;
        } else {
        echo "Error deleting record: " . $conn->error;
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
    
<!-- Jumbotron-->
<div class="jumbotron">    
  <img src='..\img\wallet.svg' width='15%' style="display: block; margin:auto;">
  <h1 class="display-3" style="text-align: center;">To Buy List!</h1>
  <?php
    //Money in your pocket
    $sql = "SELECT positive_money FROM positive_owe WHERE positive_person = 'pocket' AND positive_owe_user = '$user_name'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    $pocket = $row["positive_money"];
    }
    }
    //Money in your Account
    $sql = "SELECT positive_money FROM positive_owe WHERE positive_person = 'account' AND positive_owe_user = '$user_name'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    $account = $row["positive_money"];
    }
    }
    echo "<p class='lead'>You have <span style='color: #09096d; font-weight : bold;'>" . $pocket . " D.A</span> in your pocket at the moment.</p><p class='lead'>And <span style='color: #09096d; font-weight : bold;'>" . $account . " D.A</span> in your Account.</p>";
   ?>
    <p style="color:blue;"><?php echo $confirmed; ?></p>
  <hr class="my-4">
  <p>This is the list of things you're going to buy, if you need anything else, just add it here!</p>

<!-- Table of things to buy    -->
<div class="row">
    <div class="col-sm-6">      
<div class="table-responsive">
    <!-- Buttons and Shit   -->
    <button class="btn btn-success" id="tobuy_add_show">Add an Item!</button>
        <form action="tobuy.php" method="post" name="form_tobuy_delete_all" style="display: inline;"><input type="hidden" name="tobuy_delete_all" value="">
      <button class="btn btn-success" id="tobuy_delete_all" style="float: right;">Delete ALL</button></form>
        <br>
        <form method="post" action="tobuy.php" name="form_tobuy_add">
        <div class="row" id="tobuy_add_form">
            <div class="col-sm-4">
                <input type="text" name="tobuy_item" placeholder="Name of the item" class="form-control"></div>
            <div class="col-sm-4">
                <input type="text" name="tobuy_cost" placeholder="How much?" class="form-control"></div>
            <div class="col-sm-4">
                <button class="btn btn-success" id="tobuy_add_confirm" style="float: right;">Add to the List</button></div>
        </div>
        </form>
    
    <!-- Table Of ToBuy List-->
    <table class="table table-striped" style="border: 3px solid rgba(85, 94, 98, 0.66);">
        <tr>
            <th>Item</th>
            <th>Cost</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        
        
    <?php
    $sql = "SELECT tobuy_item, tobuy_cost FROM tobuy WHERE tobuy_user = '$user_name' ORDER BY tobuy_cost DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    echo "<tr ";
    if($row["tobuy_item"] == $added) echo "style = 'font-weight : bold;'";
    echo "><td>" . $row["tobuy_item"]. "</td>
    <td>" . $row["tobuy_cost"]. "</td>
    <td><form action='tobuy.php' method='post' name='form_tobuy_delete'><input type='hidden' name='tobuy_delete' value='" . $row["tobuy_item"] . "' ><button id='tobuy_delete' class='btn btn-sm btn-success'>X</button></form></td>
    <td><span class='tobuy_edit_form'><form action='tobuy.php' method='post' name='form_tobuy_edit'><input type='hidden' name='tobuy_edit' value='" . $row["tobuy_item"] . "'><input type='text' name='tobuy_edit_cost' placeholder='New Price?'>
    <button class='btn btn-sm btn-success' id='tobuy_edit'>OK</button></form></span>
    <button class='btn btn-sm btn-danger'>O</button></td>
    </tr>";
    }
    /* Calculate the sum */
    $sql = "SELECT SUM(tobuy_cost) FROM tobuy WHERE tobuy_user = '$user_name';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {          //If not empty
    // output data of each row
    while($row = $result->fetch_assoc()) { //Put everything in the table $row; every loop; checks a new line
    $count_cost = $row["SUM(tobuy_cost)"];
    }
    } else {
    echo "error summing";
    }
    echo '
    <tr style="color: rgb(4, 160, 76);">
            <th>Total</th>
            <th>+' . $count_cost . '</th>
            <th></th>
            <th></th>
        </tr>
    ';    
    } else {
    echo "0 results";
    }
    $conn->close();
    ?>
    </table>
</div>
<!-- Responsive sm-6-Table-->
</div>        
</div>    

    <?php
    $account_final = $account - $count_cost;
        echo "<p class='lead'>You will have <span style='color: #09096d; font-weight : bold;'>" . $account_final . " D.A</span> in your account after you buy all these cool things.</p>";
    ?>
<!-- End of jumbotrone-->    
</div>

<!-- End of responsive design-->
</div>
</div>

</body>
</html>