<?php
include('../CommonMethods.php');
session_start();

// redirect user to index.php if they haven't logged in
if($_SESSION["HAS_LOGGED_IN"] == false){
    header("Location: index.php");
}

$COMMON = new Common(false);
$fileName = "chooseGroupMeeting.php";

//check if the student has a meeting
$checkForMeeting = "Select * FROM StudentMeeting Where StudentMeeting.StudentID =". $_SESSION['STUDENT_ID'];
$rs = $COMMON->executequery($checkForMeeting,$fileName);
$numRows = mysql_fetch_array($rs);

if($numRows>0){
    header('Location:meetingChosen.php');
}

// Searches for all the meetings that passed
$search_meeting = "SELECT * FROM Meeting WHERE Meeting.start > NOW() AND Meeting.meetingType = true AND Meeting.numStudents < Meeting.studentLimit";
$rs = $COMMON->executequery($search_meeting, $fileName);

$allRows = mysql_num_rows($rs);

//adds the selected meeting to studentMeeting
if ($_POST) {
    //adds the selected meeting to studentMeeting
    $theMeetingID = $_POST['meeting'];

    //echo "The student ID is ".$_SESSION['STUDENT_ID'];
    ////creates a new student meeting
    $create_meeting = "INSERT INTO StudentMeeting(StudentID,MeetingID)
VALUES(" . $_SESSION["STUDENT_ID"] . ",$theMeetingID)";
    $rs=$COMMON->executequery($create_meeting,$fileName);

    // updatess the student table to reflect the student's current status
    $updateStudent = "UPDATE Student SET meetingStatus='meeting_scheduled' WHERE StudentID=".$_SESSION['STUDENT_ID'].";";
    $rs=$COMMON->executequery($updateStudent,$fileName);

    //changes the number of people registered for the meeting, increases them by 1
    $changeNumRegistered = "UPDATE Meeting SET numStudents = numStudents+1 WHERE meetingID = $theMeetingID";
    $rs=$COMMON->executequery($changeNumRegistered,$fileName);

    $_SESSION['MEETING_ID']= $theMeetingID;


    /**
     * This is a segment which emails the student regarding the meeting they have just scheduled.
     * It should be noted that some servers (like the current GL server) have disabled email sending.
     * As a result, this code should assign "true" to sent,
     * but will not actually send mail without the server's permission.
     */
    $command = "SELECT * FROM Meeting WHERE meetingID=".$theMeetingID;
    $meetingInfo=$COMMON->executequery($command,$fileName);
    $command = "SELECT * FROM Student WHERE StudentID=".$_SESSION['STUDENT_ID'];
    $studentInfo = $COMMON->executequery($command,$fileName);
    $to = $studentInfo[1];
    $subject = $studentInfo[2].' '.$studentInfo[4].' Adivising Meeting';
    $email_from = 'sampleadmin@umbc.edu';
    $additional_headers = "From: ".$email_from. "\r\n";
    $additional_parameters = null;
    $message = "Dear "."$studentInfo[2]".":\n\n\t You have a group meeting scheduled for ".$meetingInfo[1]." at ".$meetingInfo[3]." in room ".$meetingInfo[4].".";
    $sent=mail($to, $subject, $message, $additional_headers, $additional_parameters);
    if($sent){
        echo("<p>email sent<p>");
    }else{
        echo("<p>email failed<p>");
    }
    /**
     * End of mail code
     */

    header('Location:homePage.php');

}

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Styles/style.css">
<link rel="icon" type="image/png" href="../Styles/images/umbc.png">
    <title>Choose Your Appointment</title>
</head>
<h1>Choose an Appointment:</h1>
<br>
<body>
<div id="content-container">
<div id="content">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <?php
  //makes all the availible meetings into radio buttons
  if (sizeof($allRows) == 0){
    echo "<h4>Sorry, there are no appointments available at this time.</h4>";
  }
  else{
    while ($aRow = mysql_fetch_assoc($rs)) {
      echo "<input type = 'radio' name='meeting' value='" . $aRow["meetingID"] . "'>";
        ?>
        <h4>Meeting</h4>

        <ul>
            <li>
	   Start: <?php echo htmlspecialchars($aRow["start"]) ?>
            </li>
            <li>
	   End: <?php echo htmlspecialchars($aRow["end"]) ?>
            </li>
            <li>
	   Building Name: <?php echo htmlspecialchars($aRow["buildingName"]) ?>
            </li>
            <li>
	   Room Number: <?php echo htmlspecialchars($aRow["roomNumber"]) ?>
            </li>
        </ul>
        <?php
	   }
    ?>
      <input type="submit">

</form>
       <?php } ?>
<br>
<a href="homePage.php">Return Home</a>
</div>
</div>
</body>
</html>
