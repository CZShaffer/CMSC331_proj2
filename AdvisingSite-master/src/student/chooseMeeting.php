<?php
include("../CommonMethods.php");
session_start();

// redirect user to index.php if they haven't logged in
if($_SESSION["HAS_LOGGED_IN"] == false){
  header("Location: index.php");
}

echo('

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Styles/style.css">
<link rel="icon" type="image/png" href="../Styles/images/umbc.png">
    <title>Choose Meeting</title>
</head>
<style>
    .meetingAlert {
        padding: 20px;
        background-color: #e53900;
        color: white;
    }

    .close {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        cursor: pointer;
        transition: 0.35s;
    }

    .close:hover {
        color: black;
    }
</style>
<body>
');

// retrieve student information
$COMMON = new Common(false);
$filename = "chooseMeeting.php";
$sqlCommand = "SELECT * FROM Student WHERE StudentID=".$_SESSION['STUDENT_ID'].";";
$rs = $COMMON->executequery($sqlCommand,$filename);
$row = mysql_fetch_row($rs);

// if the student's previous meeting has been deleted or canceled from the advisor side,
// let the student know with a warning display
if($row[7]=="meeting_deleted"){
    echo('
        <div class="meetingAlert">
            <span class="close" onclick="this.parentElement.style.display=\'none\'">
                &times;
            </span>
            <b>Warning!</b>  Your previous meeting has been deleted. Please schedule a new one.
        </div>
    ');

    /** These two commands are to stop the message from annoying the student. When active, they will allow the user to see the message only once.
     * example use: A student decides not to schedule that meeting at that time. These commands determine if the message will remind them when they come back.
     * They have been commented out to make testing easier, but the option is there to put them back in.
     **/
    //$sqlCommand = "UPDATE Student SET meetingStatus='meeting_not_made' WHERE StudentID=".$_SESSION['STUDENT_ID'].";";
    //$rs = $COMMON->executequery($sqlCommand,$filename);
}

echo('
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
    ');
?>
