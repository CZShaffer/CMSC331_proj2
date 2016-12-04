<?php
session_start();

// redirect user to index.php if they haven't logged in
if($_SESSION["HAS_LOGGED_IN"] == false){
  header("Location: index.php");
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Styles/style.css">
    <title>Choose Your Appointment</title>
</head>
<body>
<div id="content-container">
<div id="content">

<?php
include('../CommonMethods.php');
session_start();

$COMMON = new Common(false);
$fileName = "cancelMeeting.php";
$studentID = $_SESSION['STUDENT_ID'];

$getCurrentMeeting =  "SELECT * FROM StudentMeeting Where $studentID = StudentID";
$rs = $COMMON->executequery($getCurrentMeeting, $fileName);
$allRows = mysql_num_rows($rs);

// cancel the appointment if there is one to cancel
if ($allRows){
  echo '<h1>Cancel Appointment</h1>';

  echo '<h3>Are you sure you want to cancel your appointment?</h3>';
  echo '<form action="deleteMeeting.php">';
  echo '<input type="submit" value = "YES">';
  echo '</form>';
  echo '<br><br>';
  echo '<form action="homePage.php">';
  echo '<input type="submit" value ="NO">';
  echo '</form>';
    
  

}

//if there is no meeting to cancel
else {
  echo '<h1>No Meeting Selected</h1>';
  echo '<a href="homePage.php">Return Home</a>';
}
?>

</div>
</div>
</body>
</html>
