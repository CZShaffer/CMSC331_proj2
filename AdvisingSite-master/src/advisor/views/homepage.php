<?php
session_start();

$allRows = "";

if (!isset($_SESSION["HAS_LOGGED_IN"])) {
    header('Location: login.php');
}


// IF THERE ARE LOGGED IN
if ($_SESSION["HAS_LOGGED_IN"]) {
    include '../utils/dbconfig.php';

    // Create meeting first and then add advisor to meeting ; DISPLAY MEETINGS
    // Create meeting form that lets the advisor create a meeting

    // Includes the form for creating meetings
    $advisorID = $_SESSION["ADVISOR_ID"];

    $open_connection = connectToDB();

    $searchAdvisorMeetings = "
      SELECT 
        Advisor.AdvisorID, 
        Meeting.meetingID,
        Meeting.start, 
        Meeting.end,
        Meeting.buildingName, 
        Meeting.roomNumber,
        Meeting.meetingType
      From 
        Advisor
      INNER JOIN 
        AdvisorMeeting ON Advisor.AdvisorID = AdvisorMeeting.AdvisorID
      INNER JOIN 
        Meeting ON AdvisorMeeting.MeetingID = Meeting.MeetingID 
      WHERE 
        Advisor.advisorID = '$advisorID'
    ";

    $searchResults = $open_connection->query($searchAdvisorMeetings);


//    $allRows = $searchResults->fetch_all(MYSQLI_ASSOC);

    $allRows = array();
    while ($row = $searchResults->fetch_assoc()) {
        array_push($allRows, $row);
    }


    $open_connection->close();
}

/*
 * Returns an array of objects
 */
function findStudentsInMeeting($meetingID)
{
    $open_connection = connectToDB();

    $queryForStudent = "
        SELECT
          Student.StudentID,
          Student.email,
          Student.firstName,
          Student.lastName,
          Student.schoolID,
          Student.major
        FROM Student
          INNER JOIN
          StudentMeeting ON Student.StudentID = StudentMeeting.StudentID
          INNER JOIN
          Meeting ON StudentMeeting.MeetingID = Meeting.meetingID
        WHERE Meeting.meetingID = '$meetingID'
    ";

    $studentResults = $open_connection->query($queryForStudent);


    $studentInfos = array();

    while ($studentInfo = $studentResults->fetch_assoc()) {
        array_push($studentInfos, $studentInfo);
    }

    return $studentInfos;
}

?>

<html>
<script type="text/javascript">
  function showfield(name){
    if(name=='group')document.getElementById('div1').style.display="block";
    else document.getElementById('div1').style.display="none";
  }
 
 function hidefield() {
 document.getElementById('div1').style.display='none';
 }
  
  </script>
<head>
    <title>Advisor Homepage</title>
<link rel="stylesheet" type="text/css" href="../../Styles/style.css">
<link rel="icon" type="image/png" href="../../Styles/images/umbc.png">
</head>
<body>
<div id="content-container">
<div id="content">

<h1>
    Advisor Home
</h1>

<?php if ($_SESSION["HAS_LOGGED_IN"]) { ?>

    <h3>
        Welcome <?php echo htmlspecialchars($_SESSION["ADVISOR_FNAME"]); ?>, here are your meetings.
    </h3>

    <a href="logout.php">
        <button type="button">Log Out</button>
    </a>

    <hr>

    <?php foreach ($allRows as $aRow) { ?>
        <h4>Meeting</h4>

        <div class="meetingInfo">
            <ul>
                <form action="../utils/forms/deleteMeeting.php" method="POST">
                    <input name="meetingID" value="<?php echo htmlspecialchars($aRow["meetingID"]) ?>" hidden>

                    <input type="submit" value="Delete Meeting">
                </form>
		<br><br>
                <!-- Will need to use this value for selecting future values -->
                <li hidden>
                    Meeting Id: <?php echo htmlspecialchars($aRow["meetingID"]) ?>
                </li>
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
                <li>
                    Meeting Type:
                    <?php
                    if ($aRow["meetingType"] == 0) {
                        echo htmlspecialchars("Individual");
                    } else {
                        echo htmlspecialchars("Group");
                    }
                    ?>
                </li>
            </ul>
        </div>

        <div class="studentInfo">
            <h4>Students in Meeting</h4>
            <?php
            $studentsInfo = findStudentsInMeeting($aRow["meetingID"]);
            ?>

            <?php foreach ($studentsInfo as $studentInfo) { ?>
                <ul>
                    <li hidden>
                        Student ID: <?php echo htmlspecialchars($studentInfo["StudentID"]) ?>
                    </li>

                    <li>
                        Email: <?php echo htmlspecialchars($studentInfo["email"]) ?>
                    </li>
                    <li>
                        First Name: <?php echo htmlspecialchars($studentInfo["firstName"]) ?>
                    </li>
                    <li>
                        Last Name: <?php echo htmlspecialchars($studentInfo["lastName"]) ?>
                    </li>

                    <li>
                        Student ID: <?php echo htmlspecialchars($studentInfo["schoolID"]) ?>
                    </li>

                    <li>
                        Major: <?php echo htmlspecialchars($studentInfo["major"]) ?>
                    </li>
                </ul>
            <?php } ?>

        </div>

        <hr>
    <?php } ?>

    <form action="../utils/forms/createMeeting.php" method="POST">
        <h4>
            Create a Meeting
        </h4>
        <ul>
            <li>
                <label>Meeting Start Date </label>
                <input type="datetime-local" name="meetingStartTime"  value="<?php echo (isset($_SESSION['meetingStartTime']) ? $_SESSION['meetingStartTime'] : ''); ?>">
                <br>

                <?php
                if (isset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"])) {
                    echo $_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"];
                    unset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"]);
                }
                ?>
            </li>

            <li>
                <label>Building Name</label>
                <input type="text" name="buildingName" value="<?php echo (isset($_SESSION['buildingName']) ? $_SESSION['buildingName'] : ''); ?>">
                   <br>                
		<?php
                if (isset($_SESSION["ERROR_ADVISOR_MEETING_BUILDING"])) {
                    echo $_SESSION["ERROR_ADVISOR_MEETING_BUILDING"];
                    unset($_SESSION["ERROR_ADVISOR_MEETING_BUILDING"]);
                }
                ?>
            </li>

            <li>
                <label>Room Number</label>
                <input type="text" name="roomNumber" value="<?php echo (isset($_SESSION['roomNumber']) ? $_SESSION['roomNumber'] : ''); ?>">
                <br>

                <?php
                if (isset($_SESSION["ERROR_ADVISOR_MEETING_ROOM"])) {
                    echo $_SESSION["ERROR_ADVISOR_MEETING_ROOM"];
                    unset($_SESSION["ERROR_ADVISOR_MEETING_ROOM"]);
                }
                ?>
            </li>

            <li>
                <label>Type of Meeting:</label>
                <select name="meetingType" onchange="showfield(this.options[this.selectedIndex].value)" >
                        <option value="individual">Individual</option>
                        <option value="group">Group</option>
                </select><br><br><br>
					<body onload="hidefield()">
<div id="div1">
					<label>
                Max number of Students: </label> 
		      <input type = "text" name = "studentLimit">  
					<br><br><br>
            </div>
                    </select>

                    </select>
                </label>
            </li>
            

                <input type="submit">
            
        </ul>

    </form>

<?php } ?>
</div>
</div>
</body>

</html>
