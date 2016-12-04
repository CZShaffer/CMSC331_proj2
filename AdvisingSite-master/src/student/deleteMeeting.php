<?php


include('../CommonMethods.php');
session_start();
$COMMON = new Common(false);
$fileName = "deleteMeeting.php";

  $studentID = $_SESSION['STUDENT_ID'];
  $cancelMeeting = "DELETE FROM StudentMeeting Where studentID = $studentID";
  $rs=$COMMON->executeQuery($cancelMeeting,$fileName);
  
  //finds the number of people in the meeting and drops it by one
  $getNumPeople = "SELECT * FROM Meeting
  INNER JOIN StudentMeeting
  ON StudentMeeting.MeetingID = Meeting.meetingID
  WHERE StudentMeeting.StudentID = $studentID";
  $rs= $COMMON->executequery($getNumPeople,$fileName);
  $theMeeting = mysql_fetch_assoc($rs);
 

  $meetingID = $_SESSION['MEETING_ID'];

  // actually updates the table 
  $subtractOne = "UPDATE Meeting SET numStudents = numStudents-1 WHERE meetingID =$meetingID";
  $rs = $COMMON->executequery($subtractOne, $fileName);

  unset($_SESSION['MEETING_ID']);
  header('Location:homePage.php');

