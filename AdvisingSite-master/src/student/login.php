<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../Styles/style.css">
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
$login_error = "";
  
if ($_POST) {
  $email = strtolower($_POST["email"]);
  $debug = true;
  $COMMON = new Common($debug);
  $fileName = "login.php";
  
  $login_val_query = "SELECT * FROM Student WHERE email = '$email'";
  $results = $COMMON->executequery($login_val_query, $fileName);
  
  
  //if email field is left empty or does not exist in table
  if(empty($email) || mysql_num_rows($results) == 0){
    $login_error = "Please enter a valid email.";
  }
  else{
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

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

  <label>E-mail</label><input type="text" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
  <span class="error"> <?php echo $login_error;?></span>
  <br>
  <br>
  <label><input type="submit"></label>

</form>
</div>
</div>
<h3><a href="index.php">Don't have an account? Register here.</a></h3>
</body>



