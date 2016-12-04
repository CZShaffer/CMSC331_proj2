<?php

session_start();

if ($_SESSION["HAS_LOGGED_IN"] and $_POST) {

    include '../dbconfig.php';


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

    $open_connection->close();
}

header('Location: ../../views/homepage.php');
