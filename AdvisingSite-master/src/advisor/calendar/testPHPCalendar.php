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
  
  // check if advising season is over
  if(!isset($_SESSION["isSeasonOver"])) {
    $select_isSeasonOver  = "SELECT isSeasonOver FROM AdvisingSeason";
    $results = $open_connection->query($select_isSeasonOver);
    
    $seasonRows = array();
    while ($row = $results->fetch_assoc()) {
      array_push($seasonRows, $row);
    }
    
    if(empty($seasonRows)) {
      $_SESSION["isSeasonOver"] = true;
      echo "This error shouldn't happen. If it does, contact Lupoli.";
    }
    
    //  $results_row = mysql_fetch_array($allRows);
    $_SESSION["isSeasonOver"] = $seasonRows[0];
    echo gettype($seasonRows["isSeasonOver"]);
    echo $_SESSION["isSeasonOver"];
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







<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Advising Calendar</title>
    <link rel="stylesheet" type="text/css" href="calendarStyle.css" />
    <link rel="icon" type="image/png" href="../../Styles/images/umbc.png">
  </head>
  <body>
    <div id="content-container">
      <div id="content">
	<h1>Appointment Calendar</h1>

	

    <h3>
        Welcome <?php echo htmlspecialchars($_SESSION["ADVISOR_FNAME"]); ?>, here are your meetings.
    </h3>
	
	
	<?php 	
		//if($currMonth == null)
			$currMonth = 1;
			//$currMonth = date("m",time());
		$currYear = 2017;
		include 'CalendarGen.php';
		$calendar = new CalendarGen();
		$calendar->Generate($currMonth,$currYear, $allRows);

	?>
	</ul>
	</div>
      


   <script src="calendarJS.js"></script>


   <hr>

   <form action="../utils/forms/createMeetingCalendar.php" method="POST">
        <h4>
            Create a Meeting
        </h4>
        <ul>
            
                <label>Meeting Start Date </label>
                <input type="datetime-local" name="meetingStartTime"  value="<?php echo (isset($_SESSION['meetingStartTime']) ? $_SESSION['meetingStartTime'] : ''); ?>">
                <br>

                <?php
                if (isset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"])) {
                    echo $_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"];
                    unset($_SESSION["ERROR_ADVISOR_MEETING_DATE_OR_TIME"]);
                }
                ?>
            
                <label>Building Name</label>
                <input type="text" name="buildingName" value="<?php echo (isset($_SESSION['buildingName']) ? $_SESSION['buildingName'] : ''); ?>">
                   <br>                
		<?php
                if (isset($_SESSION["ERROR_ADVISOR_MEETING_BUILDING"])) {
                    echo $_SESSION["ERROR_ADVISOR_MEETING_BUILDING"];
                    unset($_SESSION["ERROR_ADVISOR_MEETING_BUILDING"]);
                }
                ?>
            
                <label>Room Number</label>
                <input type="text" name="roomNumber" value="<?php echo (isset($_SESSION['roomNumber']) ? $_SESSION['roomNumber'] : ''); ?>">
                <br>

                <?php
                if (isset($_SESSION["ERROR_ADVISOR_MEETING_ROOM"])) {
                    echo $_SESSION["ERROR_ADVISOR_MEETING_ROOM"];
                    unset($_SESSION["ERROR_ADVISOR_MEETING_ROOM"]);
                }
                ?>
            
                <label>Type of Meeting:</label>
                <select name="meetingType" onchange="showfield(this.options[this.selectedIndex].value)">
                        <option value="individual">Individual</option>
                        <option value="group">Group</option>
                </select><br><br><br>
					<body onload="hidefield()">
<div id="div1">
	
					<label>
                Max number of Students: </label> 
		      <input type = "text" name = "maxStudents">  
					<br><br><br>
            </div>
                    </select>

                    </select>
                </label>
            
            

                <input type="submit">
            
        </ul>

    </form>


	</div>
	</div>
  </body>
</html>