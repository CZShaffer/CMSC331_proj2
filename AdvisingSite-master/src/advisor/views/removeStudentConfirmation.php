<?php
session_start();

// redirect user to index.php if they haven't logged in
if(!isset($_SESSION["HAS_LOGGED_IN"])){
  header("Location: login.php");
}


if(isset($_GET['removeStudentID'])){
    		$removeStudentID = $_GET['removeStudentID'];
		$name = $_GET['name'];
		$date = $_GET['date'];
		echo '

<html>
  <head>
    <title>Remove Student</title>
    <link rel="stylesheet" type="text/css" href="../../Styles/style.css">
    <link rel="icon" type="image/png" href="../../Styles/images/umbc.png">
  </head>
  <body>
    <div id="content-container">
      <div id="content">

        <h1>Removing Student</h1>
        <p>Are you sure you want to remove ' .$name
	 .' from the appointment on ' .$date  .'? This cannot be reversed.</p>

  	<a href="removeStudent.php?studentID="' .$removeStudentID .'style="text-decoration:none;">
    	  <button type="button">Remove Student</button>
  	</a>

  	<br><br>
  	<a href="calendarHomepage.php?month='.$_SESSION["month"] .'&year=' .$_SESSION["year"] .'" style="text-decoration:none;">
    	  <button type="button">Take me back</button>
  	</a>
      </div>
    </div>
  </body>
</html>';
}
else{
header('Location: calendarHomepage.php?month='.$_SESSION["month"] .'&year=' .$_SESSION["year"]);
}
?>