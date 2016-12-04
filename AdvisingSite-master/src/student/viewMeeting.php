<html>
<head>
    <title>View Your Meeting</title>
    <link rel="stylesheet" type="text/css" href="../Styles/style.css">
</head>
<body>
<div id="content-container">
<div id="content">
<h1>View Meeting</h1>
<?php
session_start();

if($_SESSION["HAS_LOGGED_IN"]){
  include '../CommonMethods.php';
  
  $debug = true;
  $COMMON = new Common($debug);
  $filename = "viewMeeting.php";
  
  $studentID = $_SESSION["STUDENT_ID"];
  
  //query to obtain meeting id corresponding to student from student meeting table
  $select_Meeting_ID  = "SELECT MeetingID FROM StudentMeeting WHERE StudentID = $studentID";

  //defining valuable == to meeting id returned by query
  $select_results = $COMMON->executequery($select_Meeting_ID, $filename);
 
  if(mysql_num_rows($select_results) == 0){
    echo "<br>You have not scheduled any appointments.<br>";
  }
  else{
  //fetching value from query result
  $results_row = mysql_fetch_array($select_results);
  
  //defining variable as array variable
  $currentApptIDVal = $results_row[0];
  
  $selectMeetingData = "SELECT * FROM Meeting WHERE meetingID = $currentApptIDVal";
  
  $rs = $COMMON->executequery($selectMeetingData, $filename);
  
  $meetingDict = mysql_fetch_assoc($rs);
  
  $_SESSION["CURRENT_MEETING_ID"] = $meetingDict["meetingID"];
  $_SESSION["CURRENT_START_TIME"] = $meetingDict["start"];
  $_SESSION["CURRENT_END_TIME"] = $meetingDict["end"];
  $_SESSION["CURRENT_APPT_BUILDING"] = $meetingDict["buildingName"];
  $_SESSION["CURRENT_APPT_ROOM"] = $meetingDict["roomNumber"];
  
  echo "Your meeting is from ", $_SESSION["CURRENT_START_TIME"],  " to ",  $_SESSION["CURRENT_END_TIME"],  " in ",  $_SESSION["CURRENT_APPT_BUILDING"], " ",  $_SESSION["CURRENT_APPT_ROOM"], "<br>";
  }
}

?>
<br>
<a href="homePage.php">Return Home</a>
<br>
</div>
</div>
</body>
</html>