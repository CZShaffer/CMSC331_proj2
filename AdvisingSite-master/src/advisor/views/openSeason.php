<?php
include '../utils/CommonMethods.php';
include '../utils/dbconfig.php';
session_start();

// redirect user to index.php if they haven't logged in
if($_SESSION["HAS_LOGGED_IN"] == false){
  header("Location: login.php");
}




$open_connection = connectToDB();


$sql = "REMOVE * FROM AdvisingSeason";
$results = $open_connection->query($sql);

$sql = "INSERT INTO AdvisingSeason (`isSeasonOver`) VALUES ('false')";
$results = $open_connection->query($sql);




//$debug = true;
//$COMMON = new Common($debug);
//$filename = "openSeason.php";

// remove current entry in AdvisingSeason table
//$sql = "REMOVE * FROM AdvisingSeason";
//$select_results = $COMMON->executequery($sql, $filename);

// add new entry setting isSeasonOver to false
//$sql = "INSERT INTO AdvisingSeason (`isSeasonOver`) VALUES ('false')";
//$result = $COMMON->executeQuery($sql, $filename);

$_SESSION["isSeasonOver"] = false;

////////////////////maybe check $result

header("Location: homepage.php");
?>