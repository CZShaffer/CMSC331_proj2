<?php
session_start();

// redirect user to index.php if they haven't logged in
if(!isset($_SESSION["HAS_LOGGED_IN"])){
  header("Location: login.php");
}
?>

<!-- Student Page for if they have already chosen a meeting and attempt to choose a new one -->
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Styles/style.css">
    <title>Meeting Chosen</title>
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
