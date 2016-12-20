<?php
session_start();

// redirect user to index.php if they haven't logged in
if(!isset($_SESSION["HAS_LOGGED_IN"])){
  header("Location: login.php");
}

include '../utils/dbconfig.php';
$conn = connectToDB();
$meetingID = $_GET['advisorMeetingID'];
//intval($advisorMeetingID);

// get meetingID
//$sql = "SELECT * FROM AdvisorMeeting WHERE AdvisorMeetingID = '$advisorMeetingID'";
//$rs = $conn->query($sql);
//$meetingID = -1;
//if ($rs->num_rows > 0) {
//  $row = $rs->fetch_assoc();
//  $meetingID = $row['meetingID'];
//}
//else {
//  echo "Meeting Not found";
//}

// get original meeting info
$sql = "SELECT * FROM Meeting WHERE meetingID = $meetingID";
$rs = $conn->query($sql);
if ($rs->num_rows > 0) {
  $row = $rs->fetch_assoc();
  $start = strftime('%Y-%m-%dT%H:%M:%S', strtotime($row['start']));
  $end = strftime('%Y-%m-%dT%H:%M:%S', strtotime($row['end']));
  $building = $row['buildingName'];
  $room = $row['roomNumber'];
  $type = $row['meetingType'];
  $numStudents = $row['numStudents'];
  $limit = $row['studentLimit'];
}

// if user edits appointment
if ($_POST) {
  $start = $_POST["start"];
  $end = $_POST["end"];
  $building = $_POST["building"];
  $room = $_POST["room"];
  $sql = "UPDATE Meeting
          SET `start`='$start', `end`='$end', `buildingName`='$building', `roomNumber`='$room'
          WHERE `meetingID`='$meetingID'";
  
  // add student limit to query if it is a group appointment
  if(isset($_POST["limit"])) {
    $limit = $_POST["limit"];
    $sql = "UPDATE Meeting
            SET `start`='$start', `end`='$end', `buildingName`='$building', `roomNumber`='$room', `studentLimit`='$limit'
            WHERE `meetingID`='$meetingID'";
  }
  $rs = $conn->query($sql);
  header('Location: calendarHomepage.php?month='.$_SESSION["month"] .'&year=' .$_SESSION["year"]);
  echo "<p style='color:red'>Appointment updated</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Advising Scheduling</title>
        <link rel="stylesheet" type="text/css" href="../../Styles/style.css">
        <link rel="icon" type="image/png" href="../../Styles/images/umbc.png">
    </head>

    <body>
        <div id="content-container">
            <div id="content">
                <h1>Edit appointment</h1>
                <h3>Original appointment:</h3>
                <?php
                echo "Date: ";
                echo ltrim(date("m/d/Y", strtotime($start)),0);
                echo "<br><br>";
                echo "Time: ";
                echo ltrim(date("h:i A", strtotime($start)),0) .' - ';
                echo ltrim(date("h:i A", strtotime($end)),0);
                echo "<br><br>";
                echo "Building: $building";
                echo "<br><br>";
                echo "Room: $room";
                echo "<br><br>";
                echo "Meeting type: ";
    
                // if individual
                if(!$type) {
                    echo "Individual<br>";
                }
                else {
                    echo "Group<br>";
                    echo "Student limit: $limit<br>";
                }
                ?>

                <h3>Updated appointment:</h3>
    
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                    <label for="start">Start time</label>
                    <input id="start" type="datetime-local" name="start" value="<?php echo (isset($start) ? $start : ''); ?>" required>

                    <br><br>
                    <label for="end">End time</label>
                    <input id="end" type="datetime-local" name="end" value="<?php echo (isset($end) ? $end : ''); ?>" required>

                    <br><br>
                    <label for="building">Building</label>
                    <input id="building" type="text" name="building" value="<?php echo (isset($building) ? $building : ''); ?>" required>

                    <br><br>
                    <label for="room">Meeting room</label>
                    <input id="room" type="text" name="room" value ="<?php echo (isset($room) ? $room : ''); ?>" required>

                    <?php
                    // if group appointment
                    if($type) {
                        echo '<br><br>';
                        echo '<label for="limit">Maximum number of students</label>';
                        echo '<input id="limit" type="number" name="limit" value="<?php echo (isset($limit) ? $limit : \'\'); ?>\" required>';
                    }
                    ?>
                    <br><br><br> 
                    <input type="submit" value="Update appointment"><br><br> 
                 </form>
            </div>
        </div>
    </body>
</html>
