<?php

include('commonMethods.php');

$filename = 'dropDB.php';
$COMMON = new Common(false);
$sqlCommand = "DROP TABLE Student;";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "DROP TABLE StudentForm;";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "DROP TABLE StudentMeeting;";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "DROP TABLE Advisor;";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "DROP TABLE AdvisorMeeting;";
$rs = $COMMON->executeQuery($sqlCommand, $filename);


$sqlCommand = "DROP TABLE Meeting;";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "DROP TABLE Season";
$rs = $COMMON->executeQuery($sqlCommand, $filename);


?>