<?php
include('../CommonMethods.php');
session_start();

// redirect user to index.php if they haven't logged in
if($_SESSION["HAS_LOGGED_IN"] == false){
  header("Location: index.php");
}

// establish connection
$COMMON = new Common(false);
$fileName = "deleteMeeting.php";

// gets the student's meeting (if not already in session)
$studentID = $_SESSION['STUDENT_ID'];
if(!isset($_SESSION['MEETING_ID'])){
    $findMeeting = "SELECT * FROM StudentMeeting WHERE StudentID=".$studentID;
    $meetingInfo = mysql_fetch_row($COMMON->executeQuery($findMeeting, $fileName));
    $_SESSION['MEETING_ID'] = $meetingInfo[2];
}

// deletes student's meeting
$cancelMeeting = "DELETE FROM StudentMeeting Where StudentID = $studentID";
$rs = $COMMON->executeQuery($cancelMeeting, $fileName);

//finds the number of people in the meeting and drops it by one
$getNumPeople = "SELECT * FROM Meeting
  INNER JOIN StudentMeeting
  ON StudentMeeting.MeetingID = Meeting.meetingID
  WHERE StudentMeeting.StudentID = $studentID";
$rs = $COMMON->executequery($getNumPeople, $fileName);
$theMeeting = mysql_fetch_assoc($rs);


$meetingID = $_SESSION['MEETING_ID'];

// updates the meeting to have fewer people
$subtractOne = "UPDATE Meeting SET numStudents = numStudents-1 WHERE meetingID =$meetingID";
$rs = $COMMON->executequery($subtractOne, $fileName);

// updates the student to reflect meeting status
$updateStudent = "UPDATE Student SET meetingStatus='meeting_not_scheduled' WHERE StudentID=".$_SESSION['STUDENT_ID'].";";
$rs=$COMMON->executequery($updateStudent,$fileName);

unset($_SESSION['MEETING_ID']);
header('Location:homePage.php');
?>