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
<style>
    div.meetingAlert {
        padding: 20px;
        background-color: #e53900;
        color: white;
    }

    span.close {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        cursor: pointer;
        transition: 0.35s;
    }

    .closebtn:hover {
        color: black;
    }
</style>
<body>
<?php
$filename = "chooseMeeting.php";
$sqlCommand = "SELECT * FROM Student WHERE StudentID=".$_SESSION['STUDENT_ID'].";";
$rs = $COMMON->executequery($sqlCommand,$filename);
$row = mysql_fetch_row($rs);
//echo("".$row[7]);
if($row[7]=="meeting_deleted"){
    echo('
        <div class="meetingAlert">
            <span class="close" onclick="this.parentElement.style.display=\'none\'">
                &times;
            </span>
            <b>Warning!</b>  Your previous meeting has been deleted. Please schedule a new one.
        </div>
    ');
    $sqlCommand = "UPDATE Student SET meetingStatus='meeting_not_made' WHERE StudentID=".$_SESSION['STUDENT_ID'].";";
    $rs = $COMMON->executequery($sqlCommand,$filename);
}

?>
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