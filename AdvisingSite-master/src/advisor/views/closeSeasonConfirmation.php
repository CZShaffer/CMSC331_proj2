<?php
session_start();

// redirect user to index.php if they haven't logged in
if(!isset($_SESSION["HAS_LOGGED_IN"])){
  header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Advising Scheduling</title>

    <link rel="icon" type="image/x-icon" href="favicon.png"/>
    <link rel="stylesheet" type="text/css" href="_________________________.css"/>
  </head>

  <body>
    
    <h2>Close advising season</h2>
    <p>Are you sure you want to close the scheduling site? This can be reversed.</p>

    <form action="closeSeason.php" method="POST">
      <input type="submit" value="Yes">
      <input type="submit" value="No">
    </form>
  </body>
</html>
