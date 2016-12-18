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
<link rel="icon" type="image/png" href="../Styles/images/umbc.png">
  <title>Student Homepage</title>
  </head>
  
  <body>
    <div id="content-container">
      <div id="content">
        <h1>Student Home</h1>

        <h3>
	Welcome <?php echo htmlspecialchars($_SESSION["STUDENT_EMAIL"]); ?>
        </h3>

        <br>
        <a href="viewMeeting.php">View Scheduled Appointment</a>
        <br>

        <br>
        <a href="chooseMeeting.php">Schedule Advising Appointment</a>
        <br>

        <br>
        <a href="cancelMeeting.php">Cancel Advising Appointment</a>
        <br>

        <br>
        <a href="logout.php">Log out</a>
        <br>
      </div>
    </div>
  </body>
</html>