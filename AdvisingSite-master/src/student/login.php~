<!DOCTYPE HTML>
<html>
<head>
<title>Student Login</title>
<link rel="stylesheet" type="text/css" href="../Styles/style.css">
<link rel="icon" type="image/png" href="../Styles/images/umbc.png">
</head>

<body>
<div id="content-container">
<div id="content">

<?php
include '../CommonMethods.php';  

// check if advising season is over
$debug = true;
$COMMON = new Common($debug);
$filename = "login.php";

// get isSeasonOver from AdvisingSeason table
$select_isSeasonOver  = "SELECT isSeasonOver FROM AdvisingSeason";
$select_results = $COMMON->executequery($select_isSeasonOver, $filename);

if(mysql_num_rows($select_results) == 0){
  echo "This error shouldn't happen";
}

$results_row = mysql_fetch_array($select_results);
$isSeasonOver = $results_row[0];

// redirect user to seasonOver.html if the season is over
if($isSeasonOver) {
  header("Location: seasonOver.html");
}

//declare and define empty login_error
$login_email_error = $login_ID_error = "";
  
if ($_POST) {
  $email = strtolower($_POST["email"]);
  $ID = $_POST["ID"];
  $debug = true;
  $COMMON = new Common($debug);
  $fileName = "login.php";
  
  //uses the student email and ID to pull from the table to validate
  $login_val_query_email = "SELECT * FROM Student WHERE email = '$email'";
  $results = $COMMON->executequery($login_val_query_email, $fileName);
  $login_val_query_ID = "SELECT * FROM Student WHERE schoolID = '$ID'";
  $results_ID = $COMMON->executequery($login_val_query_ID, $fileName);
  $num_errors = $num_fields = 0;

  $EMAIL_INFO = mysql_fetch_row($results);
  $ID_INFO = mysql_fetch_row($results_ID);
  
  //if email field is left empty or does not exist in table
  if(empty($email) || (mysql_num_rows($results) == 0)){
    $login_email_error = "Please enter a valid email.";
    $num_fields++;
    $num_errors++;
  }
  //if ID field is left empty or does not exist in table
  if(empty($ID) || (mysql_num_rows($results_ID) == 0)){
    $login_ID_error = "Please enter a valid student ID.";
    $num_fields++;
    $num_errors++;
  }
  //if the email and id do not match in table
  if(($EMAIL_INFO[5] != $ID_INFO[5]) && ($num_fields === 0)){
    $login_email_error = "Email does not match entered ID";
    $login_ID_error = "ID does not match entered Email";
    $num_errors++;
  }

  if ($num_errors === 0){
    // Search is advisor email exists in student
    // Run raw sql query in attempt to create a new advisor
    $search_student = "SELECT * FROM Student WHERE email='$email'";
    $rs = $COMMON->executequery($search_student, $fileName);
    // Check whether or not there has been a successful adviser creation
    $num_rows = mysql_num_rows($rs);
    
    if ($num_rows == 1) {
      session_start();
      
      $studentDict = mysql_fetch_assoc($rs);
      
      $_SESSION["HAS_LOGGED_IN"] = true;
      $_SESSION["STUDENT_EMAIL"] = $studentDict["email"];
      $_SESSION["STUDENT_ID"] = $studentDict["StudentID"];
      $_SESSION["MAJOR"] = $studentDict["major"];
      
      //redirectedd to index.php
      header('Location: homePage.php');
      
      // Can only do function overloading in classes, why need to pass empty string
    }
  }
}
?>

<h1>
    Student Login Page
</h1>
<!-- to log in students will use their email and their ID -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

  <label>E-mail</label><input type="text" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
  <span class="error"> <?php echo $login_email_error;?></span>
  <br>
  <br>

  <label>Student ID</label><input type="text" name="ID" value="<?php echo (isset($_POST['ID']) ? $_POST['ID'] : ''); ?>">
  <span class="error"> <?php echo $login_ID_error;?></span>
  <br>
  <br>
  <label><input type="submit" value="submit" name="Log in"></label>

</form>
</div>
</div>
<h3><a href="index.php">Don't have an account? Register here.</a></h3>
</body>



