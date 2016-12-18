<?php

session_start();

if ($_SESSION["HAS_LOGGED_IN"] and $_POST) {

    include '../dbconfig.php';
    //include("..../CommonMethods.php");

    // ID That needs to be deleted
    // Advisor ID
    // Use assigned variable stored in session
    $advisorID = $_SESSION["ADVISOR_ID"];
    $selectedMeetingID = $_POST["meetingID"];

    $open_connection = connectToDB();

    // Delete from AdvisorMeeting
    $deleteFromAdvisorMeeting = "
      DELETE FROM AdvisorMeeting
      WHERE MeetingId = '$selectedMeetingID'
    ";
    $open_connection->query($deleteFromAdvisorMeeting);

    // Delete from Meeting
    $deleteFromMeeting = "
      DELETE FROM Meeting
      WHERE MeetingId = '$selectedMeetingID'
    ";
    $open_connection->query($deleteFromMeeting);

    $getStudents = "SELECT * FROM StudentMeeting WHERE MeetingID=".$selectedMeetingID.";";
    $result = $open_connection->query($getStudents);

    while($row = mysqli_fetch_row($result)){
        $studentID = $row[1];
        $updateStudent = "UPDATE Student SET meetingStatus='meeting_deleted' WHERE StudentID=".$studentID.";";
        $rs = $open_connection->query($updateStudent);
        $deleteStudentMeeting = "DELETE FROM StudentMeeting WHERE StudentID=".$studentID.";";
        $rs = $open_connection->query($deleteStudentMeeting);
    }
    //$deleteStudentMeeting = "DELETE FROM StudentMeeting WHERE MeetingID=".$selectedMeetingID.";";

    $open_connection->close();
}

header('Location: ../../views/homepage.php');
