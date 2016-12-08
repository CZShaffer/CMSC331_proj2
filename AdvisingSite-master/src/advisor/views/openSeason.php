<?php
include '../CommonMethods.php';
session_start();

// redirect user to index.php if they haven't logged in
if($_SESSION["HAS_LOGGED_IN"] == false){
  header("Location: index.php");
}

// if user closes season
if(isset($_POST['yes'])) {

  $debug = true;
  $COMMON = new Common($debug);
  $filename = "openSeason.php";

  // remove current entry in AdvisingSeason table
  $sql  = "REMOVE * FROM AdvisingSeason";
  $select_results = $COMMON->executequery($sql, $filename);

  // add new entry setting isSeasonOver to false
  $sql = "INSERT INTO AdvisingSeason (`isSeasonOver`) VALUES ('false'))";
  $result = $COMMON->executeQuery($sql, $_SERVER["filename"]);

  ////////////////////maybe check $result

}

// else, redirect user to homePage.php
else {
  header("Location: homePage.php");
}
?>