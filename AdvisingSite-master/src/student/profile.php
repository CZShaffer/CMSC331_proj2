<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>The HTML5 Herald</title>
    <link rel="stylesheet" href="../../static/css/main.css">
</head>

<body>

<?php
require_once("basics/navbar.php");

session_start();

// redirect user to index.php if they haven't logged in
if($_SESSION["HAS_LOGGED_IN"] == false){
  header("Location: index.php");
}
?>

<header>
    <h1>
        Profile Page
    </h1>
</header>


</body>

</html>