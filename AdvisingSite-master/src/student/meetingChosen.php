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
<br>
<body>
<div id="content-container">
<div id="content">
<h1>Sorry, you already have a meeting selected.</h1>

<form action="homePage.php">
   <input type="submit" value = "Go Home">
</form>

</div>
</div>
</body>
</html>