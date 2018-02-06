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
    <title>Calibrate your debts! </title>
  </head>
<body>
<script type="text/javascript" src="owe_script.js"></script>
    
<!-- Responsive-->
<div class="row">
<div class="col-sm-12">
    
<!-- Start the session   -->    
    
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
    $positive_person = "";
    $positive_money = 0;
    $positive_delete = "";
    $negative_person = "";
    $negative_money = 0;
    $negative_delete = "";
    $confirmed = "";
    $added = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Add Someone positive
        if(isset($_POST["positive_person"])){
        $positive_person = $_POST["positive_person"];
        /* Upper */ $positive_person = ucfirst($positive_person);
        $positive_money = $_POST["positive_money"];
        $sql = "INSERT INTO positive_owe (positive_person, positive_money, positive_owe_user) VALUES ('$positive_person', " . $positive_money . ", '$user_name')";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "SomeOne has been added successfully!!";
        $added = $positive_person;
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }
        //Add Someone negative
        if(isset($_POST["negative_person"])){
        $negative_person = $_POST["negative_person"];
        /* Upper */ $negative_person = ucfirst($negative_person);
        $negative_money = $_POST["negative_money"];
        $sql = "INSERT INTO negative_owe (negative_person, negative_money, negative_owe_user) VALUES ('$negative_person', " . $negative_money . ", '$user_name')";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "SomeOne has been added successfully!!";
        $added = $negative_person;
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }
        //Delete Someone positive
        if(isset($_POST["positive_delete"])){
        $positive_delete = $_POST["positive_delete"];
        if($positive_delete == "Pocket"){
            $sql = "UPDATE positive_owe SET positive_money = 0 WHERE positive_person = 'Pocket' AND positive_owe_user = '$user_name'";
        }
        else if($positive_delete == "Account"){
            $sql = "UPDATE positive_owe SET positive_money = 0 WHERE positive_person = 'Account' AND positive_owe_user = '$user_name'";
        }
        else $sql = "DELETE FROM positive_owe WHERE positive_person='$positive_delete' AND positive_owe_user = '$user_name'";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "Someone has been deleted successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
                }
        }
        //Delete Someone negative
        if(isset($_POST["negative_delete"])){
        $negative_delete = $_POST["negative_delete"];
        $sql = "DELETE FROM negative_owe WHERE negative_person='$negative_delete' AND negative_owe_user = '$user_name'";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "Someone has been deleted successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
                }
        }
        //Delete ALL positive
        if(isset($_POST["positive_delete_all"])){
        $sql = "DELETE FROM positive_owe WHERE positive_owe_user = '$user_name'";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "The table has been emptied successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
                }
        }
        //Delete ALL negative
        if(isset($_POST["negative_delete_all"])){
        $sql = "DELETE FROM negative_owe WHERE negative_owe_user = '$user_name'";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "The table has been emptied successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
                }
        }
        //Edit SomeOne positive
        if(isset($_POST["positive_edit_money"])){
        $positive_money = $_POST["positive_edit_money"];
        $positive_person = $_POST["positive_edit_person"];
        /* Upper */ $positive_person = ucfirst($positive_person);
        $sql = "UPDATE positive_owe SET positive_money = " . $positive_money  . " WHERE positive_person = '$positive_person' AND positive_owe_user = '$user_name'";
        if ($conn->query($sql) === TRUE) {
        if($positive_person == "Account"){
            $sql2 = "INSERT INTO sold (sold_date, sold_money, sold_user) VALUES ('" . date('Y/m/d') . "' , " . $positive_money . ", '$user_name')";
            $conn->query($sql2);
        }
        $confirmed = "Money has been updated successfully";
        $added = $positive_person;
        } else {
        echo "Error updating record: " . $conn->error;
        }
        }
        //Edit SomeOne negative
        if(isset($_POST["negative_edit_money"])){
        $negative_money = $_POST["negative_edit_money"];
        $negative_person = $_POST["negative_edit_person"];
        /* Upper */ $negative_person = ucfirst($negative_person);
        $sql = "UPDATE negative_owe SET negative_money = " . $negative_money  . " WHERE negative_person = '$negative_person' AND negative_owe_user = '$user_name'";
        if ($conn->query($sql) === TRUE) {
        $confirmed = "Money has been updated successfully";
        $added = $negative_person;
        } else {
        echo "Error updating record: " . $conn->error;
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
    
<!-- Debts Jumbotron-->
<div class="jumbotron">
  <img src="..\img\balance.svg" width="15%" style="display: block; margin:auto;">
  <h1 class="display-3" style="text-align: center;">Debts!</h1>
  <hr class="my-4">
  <p><span style="color:green;">Green:</span> The people you owe.</p>
  <p><span style="color:red;">Red:</span> The people who owe you.</p>
  <p style="color:blue;"><?php echo $confirmed; ?></p>
    
<!-- Buttons of Adding and editing-->
<div class="row">
    <!-- Positive Side-->
    <div class="col-sm-6">
      <button class="btn btn-success" id="positive_add_show">Add Someone!</button>
        <form action="owe.php" method="post" name="form_positive_delete_all" style="display: inline;"><input type="hidden" name="positive_delete_all" value="">
      <button class="btn btn-success" id="positive_delete_all" style="float: right;">Delete ALL</button></form>
        <br>
        <form method="post" action="owe.php" name="form_positive_add">
        <div class="row" id="positive_add_form">
            <div class="col-sm-4">
                <input type="text" name="positive_person" placeholder="Name of the person" class="form-control"></div>
            <div class="col-sm-4">
                <input type="text" name="positive_money" placeholder="How much?" class="form-control"></div>
            <div class="col-sm-4">
                <button class="btn btn-success" id="positive_add_confirm" style="float: right;">Add to the List</button></div>
        </div>
        </form>
        </div>
    
    <!-- Negative Side   -->
    <div class="col-sm-6">
      <button class="btn btn-danger" id="negative_add_show">Add Someone!</button>
        <form action="owe.php" method="post" name="form_negative_delete_all" style="display: inline;"><input type="hidden" name="negative_delete_all" value="">
      <button class="btn btn-danger" id="negative_delete_all" style="float: right;">Delete ALL</button></form>
        <br>
        <form method="post" action="owe.php" name="form_negative_add">
        <div class="row" id="negative_add_form">
            <div class="col-sm-4">
                <input type="text" name="negative_person" placeholder="Name of the person" class="form-control"></div>
            <div class="col-sm-4">
                <input type="text" name="negative_money" placeholder="How much?" class="form-control"></div>
            <div class="col-sm-4">
                <button class="btn btn-danger" id="negative_add_confirm" style="float: right;">Add to the List</button></div>
        </div>
        </form>
    </div>
</div>
    
<!-- Table of Debts    -->
<!-- positive Debts    -->
<div class="row">
<div class="col-sm-6">
    <div class="table-responsive">
    <table class="table table-striped" style="border: 3px solid rgba(4, 160, 76, 0.78);" id="positive_table">
        <tr style="color: rgb(4, 160, 76);">
            <th>Person</th>
            <th>$$</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
    <?php
    $count_pos = 0;
    $zero_results_pos = '';
    $sql = "SELECT positive_person, positive_money FROM positive_owe WHERE positive_owe_user = '$user_name' ORDER BY positive_money DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    echo "<tr ";
    if($row["positive_person"] == $added) echo "style = 'font-weight : bold;'";
    echo "><td>" . $row["positive_person"]. "</td>
    <td>+" . $row["positive_money"]. "</td>
    <td><form action='owe.php' method='post' name='form_positive_delete'><input type='hidden' name='positive_delete' value='" . $row["positive_person"] . "' ><button id='positive_delete' class='btn btn-sm btn-success'>X</button></form></td>
    <td><span class='positive_edit_form'><form action='owe.php' method='post' name='form_positive_edit'><input type='hidden' name='positive_edit_person' value='" . $row["positive_person"] . "'><input type='text' name='positive_edit_money' placeholder='New Debt?'>
    <button class='btn btn-sm btn-success' id='positive_edit'>OK</button></form></span>
    <button class='btn btn-sm btn-primary'>O</button>
    </td>
    </tr>";
    }
    /* Calculate the sum */
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
    echo '
    <tr style="color: rgb(4, 160, 76);">
            <th>Total</th>
            <th>+' . $count_pos . '</th>
            <th></th>
            <th></th>
        </tr>
    ';
    } else {
    $zero_results_pos = "0 results";
    }
    ?>
    </table>
    </div>
    <?php echo $zero_results_pos; ?>
</div>

<!-- Negative Debts  -->
<div class="col-sm-6">
    <div class="table-responsive">
    <table class="table table-striped" style="border: 3px solid rgba(160, 4, 4, 0.78);" id="negative_table">
        <tr style="color: rgb(160, 4, 4);">
            <th>Person</th>
            <th>$$</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
    <?php
    $count_neg = 0;
    $zero_results_neg = '';
    $sql = "SELECT negative_person, negative_money FROM negative_owe WHERE negative_owe_user = '$user_name' ORDER BY negative_money DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    echo "<tr ";
    if($row["negative_person"] == $added) echo "style = 'font-weight : bold;'";
    echo "><td>" . $row["negative_person"] . "</td>
    <td>-" . $row["negative_money"]. "</td>
    <td><form action='owe.php' method='post' name='form_negative_delete'><input type='hidden' name='negative_delete' value='" . $row["negative_person"] . "' ><button id='negative_delete' class='btn btn-sm btn-danger'>X</button></form></td>
    <td><span class='negative_edit_form'><form action='owe.php' method='post' name='form_negative_edit'><input type='hidden' name='negative_edit_person' value='" . $row["negative_person"] . "'><input type='text' name='negative_edit_money' placeholder='New Debt?'>
    <button class='btn btn-sm btn-success' id='negative_edit'>OK</button></form></span>
    <button class='btn btn-sm btn-warning'>O</button></td>
    </tr>";
    }
    /* Calculate the sum */
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
    echo '
    <tr style="color: rgb(160, 4, 4);">
            <th>Total</th>
            <th>-' . $count_neg . '</th>
            <th></th>
            <th></th>
        </tr>
    ';
    } else {
    $zero_results_neg = "0 results";
    }
    ?>
    </table>
    </div>
    <?php echo $zero_results_neg; ?>
    
    </div>
</div>

<!-- Total count    -->
<?php
    $count = $count_pos - $count_neg;
    if($count > 0) $count_sign = "+";
    else $count_sign = "-";
?>
<input type="text" readonly value="<?php echo $count_sign . $count; ?>" class="form-control" style="text-align: center; color:green; font-weight : bold;">

<!-- End Of Jumbotron-->
</div>

<!-- End of responsive design-->
</div>
</div>
<?php $conn->close(); ?>    
</body>
</html>