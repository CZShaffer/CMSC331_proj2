<?php
include '../utils/dbconfig.php';
session_start();

// redirect user to index.php if they haven't logged in
if($_SESSION["HAS_LOGGED_IN"] == false){
  header("Location: login.php");
}

$open_connection = connectToDB();

// remove current entry in AdvisingSeason table
$sql = "TRUNCATE TABLE AdvisingSeason";
$results = $open_connection->query($sql);

// add new entry setting isSeasonOver to false
$sql = "INSERT INTO AdvisingSeason (`isSeasonOver`) VALUES (0)";
$results = $open_connection->query($sql);

$_SESSION["isSeasonOver"] = false;

header("Location: calendarHomepage.php");
?>