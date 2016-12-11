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
    <title>Choose Your Meeting</title>
</head>
<body>
<div id="content-container">
<div id="content">
<h1>Would you like a group meeting or an Individual Meeting</h1>

<form action="chooseIndividualMeeting.php">
   <input type="submit" value = "Individual Meeting">
</form><br><br>

<form action="chooseGroupMeeting.php">
   <input type="submit" value ="Group Meeting">
</form>
</div>
</div>
</body>