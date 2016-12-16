<?php
/**
 * Created by PhpStorm.
 * User: Phillip
 * Date: 12/11/2016
 * Time: 3:47 PM
 */
//if(!defined($GLOBALS['CMDefined'])) {
include('commonMethods.php');
//    define($GLOBALS['CMDefined'], true);
//}
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

/*
if(defined($GLOBALS['setup'])&& $GLOBALS['setup']==true){
    $GLOBALS['setup']=false;
    //header('./setUpDB.php');
}**/
?>