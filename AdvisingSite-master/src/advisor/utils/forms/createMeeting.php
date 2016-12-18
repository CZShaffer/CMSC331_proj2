<?php

session_start();
date_default_timezone_set("EST");

if ($_SESSION["HAS_LOGGED_IN"] and $_POST) {
    include '../dbconfig.php';

    // Parse through variables from form
    $start = $_POST["meetingStartTime"];
    $_SESSION["meetingStartTime"] = $_POST["meetingStartTime"];  
    $bName = $_POST["buildingName"];
    $_SESSION["buildingName"] = $_POST["buildingName"];  
    $rNumber = $_POST["roomNumber"];
    $_SESSION["roomNumber"] = $_POST["roomNumber"];  
    $typeOfMeeting = $_POST["meetingType"];
    $_SESSION["meetingType"] = $_POST["meetingType"];
    $isIndividual = false;
    $studentLimit = 1;

    $numOfErrors = 0;

    if ($typeOfMeeting == "group") {
        $isIndividual = true;
        if ($_POST["studentLimit"] == "") {
            $_SESSION["ERROR_STUDENT_LIMIT"] = "Error: Please enter a number of students";
            $numOfErrors += 1;
        }
        else if (($_POST["studentLimit"] < 2) || ($_POST["studentLimit"] > 40)) {
            $_SESSION["ERROR_STUDENT_LIMIT"] = "Error: Please enter a number greater than 1 and less than 41";
            $numOfErrors += 1;
        }
        else{
            $studentLimit = $_POST["studentLimit"];
        }
    }

    if ($start == "") {
        $_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"] = "Error: Please enter in a date.";
        $numOfErrors += 1;
    }

    if ($bName == "") {
        $numOfErrors += 1;
        $_SESSION["ERROR_ADVISOR_MEETING_BUILDING"] = "Error: You haven't enetered a building name.";
    }

    if ($rNumber == "") {
        $numOfErrors += 1;
        $_SESSION["ERROR_ADVISOR_MEETING_ROOM"] = "Error: You must enter in a room number.";
    }

    if ($numOfErrors == 0) {
        // Use assigned variable stored in session
        $advisorID = $_SESSION["ADVISOR_ID"];

        $startDate = new DateTime($start);

        // Add 30 mins
        $endDate = new DateTime($start);
        $endDate->add(new DateInterval('PT30M'));

        // Storing dates into string format for MySQL
        $formattedStartDate = $startDate->format('Y-m-d H:i:s');
        $formattedEndDate = $endDate->format('Y-m-d H:i:s');

        // Open DB Connection
        $open_connection = connectToDB();

        // Create meeting SQL query and insert into DB
        $insertIntoMeetings = "
          INSERT INTO Meeting(start,end,buildingName,roomNumber, meetingType, numStudents, studentLimit)
          VALUES (
            '$formattedStartDate','$formattedEndDate','$bName', '$rNumber', '$isIndividual', 0, '$studentLimit'
          )
        ";

        $resultOfMeetingInsert = $open_connection->query($insertIntoMeetings);

        // Create SQL query to find latest meeting ID and parse the data to find the int
        $findTheMeetingID = "
          SELECT MAX(Meeting.MeetingID)
          FROM Meeting
        ";

        $meetingId = $open_connection->query($findTheMeetingID);
        $fetchMeetingArray = $meetingId->fetch_array();

        // Create sql query to insert the meeting to advisor meeting
        $insertIntoAdvisingMeeting = "
          INSERT INTO
          AdvisorMeeting(advisorID,meetingID)
          VALUES('$advisorID', '$fetchMeetingArray[0]')
        ";
        $open_connection->query($insertIntoAdvisingMeeting);

        error_log($open_connection->error);
    }
    header('Location: ../../views/homepage.php');
}