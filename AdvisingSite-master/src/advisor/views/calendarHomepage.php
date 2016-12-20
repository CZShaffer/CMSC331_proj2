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
  
    $allRows = array();
    while ($row = $searchResults->fetch_assoc()) {
        array_push($allRows, $row);
    }
  
    // check if advising season is over
    if(!isset($_SESSION["isSeasonOver"])) {
        $select_isSeasonOver  = "SELECT isSeasonOver FROM AdvisingSeason";
        $results = $open_connection->query($select_isSeasonOver);
        if(empty($results)){
            $_SESSION["isSeasonOver"] = true;
            echo "This error shouldn't happen. If it does, contact Lupoli.";
        }

        $seasonOver = true;
        while ($row = mysqli_fetch_row($results)) {
            $seasonOver = ((bool)($row[0]));
        }
        $_SESSION["isSeasonOver"] = $seasonOver;
    }
    $open_connection->close();
}

/*
 * Returns an array of objects
 */
function findStudentsInMeeting($meetingID) {
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
<script type="text/javascript">
    function showfield(name){
          if(name=='group')document.getElementById('div1').style.display="block";
          else document.getElementById('div1').style.display="none";
    }

    function hidefield() {
          document.getElementById('div1').style.display='none';
    }
</script>

<html lang="en">
    <head>
         <meta charset="utf-8">
         <title>Advising Calendar</title>
         <link rel="stylesheet" type="text/css" href="calendarStyle.css">
         <link rel="icon" type="image/png" href="../../Styles/images/umbc.png">
     </head>
     <body>
         <div id="content-container">
              <div id="content">
	          <h1>Appointment Calendar</h1>
                  <h3>Welcome <?php echo htmlspecialchars($_SESSION["ADVISOR_FNAME"]); ?>, here are your meetings.</h3>
    		  <hr>
	          <?php 	
		      $_SESSION["year"]   = null;
    		      $_SESSION["month"] = null;
    		      if($_SESSION["year"]  == null && isset($_GET['year'])){
    		          $_SESSION["year"]  = $_GET['year'];
 	   	      }
		      else if($_SESSION["year"] == null){
      			  $_SESSION["year"] = date("Y",time());  
    		      }          
         
    		      if($_SESSION["month"] == null &&isset($_GET['month'])){
      		          $_SESSION["month"]= $_GET['month'];
    		      }
		      else if($_SESSION["month"] == null){
      		          $_SESSION["month"] = date("m",time());
    		      } 

		      include 'CalendarGen.php';
		      $calendar = new CalendarGen();
		      $calendar->Generate($_SESSION["month"],$_SESSION["year"], $allRows);
	          ?>
   	          <script src="calendarJS.js"></script>
              <div>
              <hr>

              <form action="../utils/forms/createMeetingCalendar.php" method="POST">
              <h4>Create a Meeting</h4>
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
		<label>Max number of Students: </label> 
		<input type = "text" name = "studentLimit">
		<br><br><br>
                </div>
                    </select>

                    </select>
                    </label>
            
            

                <input type="submit" value="Create Appointment">
            
        </ul>

    </form>
</div>
<br><br><hr>
		 <?php					
    if(!isset($_SESSION["isSeasonOver"])) {
      echo('Oops! Something went wrong. Advisors don\'t have to worry about this, only Lupoli.');
      $_SESSION["isSeasonOver"] = true;
      //header('login.html');
    }
					
    // if advising season is over, show message saying so and a link to re-open it
    if($_SESSION["isSeasonOver"]) {
      echo "<br><p style='color:red'>The advising season is currently closed.</p>";
      echo "<a href='openSeasonConfirmation.php'>";
      echo "<button type='button'>Open season</button>";
      echo "</a>";
      //include('appointmentOptions.html');
    }
    
    // otherwise show option to sign up for an appointment
    else {
      echo "<br><a href='closeSeasonConfirmation.php'>";
      echo "<button type='button'>Close season</button>";
      echo "</a>";
      //    include('signUpOption.html');
    }
?>
    <br><br>
    <a href="logout.php">
        <button type="button">Log Out</button>
    </a>
	</div>
	</div>
  </body>
</html>
