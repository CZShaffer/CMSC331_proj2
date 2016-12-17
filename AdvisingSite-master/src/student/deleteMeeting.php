<?php
include('../CommonMethods.php');
session_start();

// redirect user to index.php if they haven't logged in
if($_SESSION["HAS_LOGGED_IN"] == false){
  header("Location: index.php");
}

$COMMON = new Common(false);
$fileName = "deleteMeeting.php";

$studentID = $_SESSION['STUDENT_ID'];
$cancelMeeting = "DELETE FROM StudentMeeting Where studentID = $studentID";
$rs = $COMMON->executeQuery($cancelMeeting, $fileName);

//finds the number of people in the meeting and drops it by one
$getNumPeople = "SELECT * FROM Meeting
  INNER JOIN StudentMeeting
  ON StudentMeeting.MeetingID = Meeting.meetingID
  WHERE StudentMeeting.StudentID = $studentID";
$rs = $COMMON->executequery($getNumPeople, $fileName);
$theMeeting = mysql_fetch_assoc($rs);


$meetingID = $_SESSION['MEETING_ID'];

// actually updates the table 
$subtractOne = "UPDATE Meeting SET numStudents = numStudents-1 WHERE meetingID =$meetingID";
$rs = $COMMON->executequery($subtractOne, $fileName);

$updateStudent = "UPDATE Student SET meetinStatus='meeting_not_scheduled' WHERE StudentID=".$_SESSION['STUDENT_ID'].";";
$rs=$COMMON->executequery($create_meeting,$fileName);

unset($_SESSION['MEETING_ID']);
header('Location:homePage.php');
?>