<?php
session_start();

// redirect user to index.php if they haven't logged in
if(!isset($_SESSION["HAS_LOGGED_IN"])){
  header("Location: login.php");
}
?>

<html>
  <head>
    <title>Advising Scheduling</title>
    <link rel="stylesheet" type="text/css" href="../../Styles/style.css">
    <link rel="icon" type="image/png" href="../../Styles/images/umbc.png">
  </head>

  <body>
    <div id="content-container">
      <div id="content">
	<h1>Close advising season</h1>
 	<p>Are you sure you want to close the scheduling site? This can be reversed.</p>
  	<a href="closeSeason.php" style="text-decoration:none;">
    	  <button type="button">Close season</button>
  	</a>
 	<br><br>
  	<a href="homepage.php" style="text-decoration:none;">
    	  <button type="button">Take me back</button>
 	 </a>
      </div>
    </div>
  </body>
</html>