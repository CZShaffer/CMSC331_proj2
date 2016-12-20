<?php
session_start();
  
// redirect user to index.php if they haven't logged in
if(!isset($_SESSION["HAS_LOGGED_IN"])){
  header("Location: login.php");
}
?>

<html>
  <head>
  <link rel="stylesheet" type="text/css" href="../Styles/style.css">
<link rel="icon" type="image/png" href="../Styles/images/umbc.png">
  <title>Student Homepage</title>
  </head>
  <style>
  .meetingAlert {
padding: 20px;
background-color: #e53900;
color: white;
}
.close {
  margin-left: 15px;
color: white;
  font-weight: bold;
  float: right;
cursor: pointer;
transition: 0.35s;
 }
.close:hover {
color: black;
 }
  </style>

  <body>
  <?php

  // establish connection
  include("../CommonMethods.php");
  $COMMON = new Common(false);
  $filename = "homePage.php";

  // get student info
  $sqlCommand = "SELECT * FROM Student WHERE StudentID=".$_SESSION['STUDENT_ID'].";";
  $rs = $COMMON->executequery($sqlCommand,$filename);
  $row = mysql_fetch_row($rs);

  // notify student if student's appointment has been deleted or canceled from the advisor side
  if($row[7]=="meeting_deleted"){
    echo('
        <div class="meetingAlert">
            <span class="close" onclick="this.parentElement.style.display=\'none\'">
                &times;
            </span>
            <b>Warning!</b>  Your previous meeting has been deleted. Please schedule a new one.
        </div>
    ');
  }
  ?>
    <div id="content-container">
      <div id="content">
        <h1>Student Home</h1>

        <h3>
        Welcome <?php echo htmlspecialchars($_SESSION["STUDENT_EMAIL"]); ?>
        </h3>

        <br>
        <a href="viewMeeting.php" style='font-size:15px;'>View Scheduled Appointment</a>
        <br>

        <br>
        <a href="chooseMeeting.php" style='font-size:15px;'>Schedule Advising Appointment</a>
        <br>

        <br>
        <a href="cancelMeeting.php" style='font-size:15px;'>Cancel Advising Appointment</a>
        <br>

        <br>
        <a href="regSheet.php" style='font-size:15px;'>Edit Pre-advising worksheet</a>
        <br>

        <br>
        <a href="logout.php" style='font-size:15px;'>Log out</a>
        <br>
      </div>
    </div>
  </body>
</html>
