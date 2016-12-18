<?php 
  class CalendarGen {
    public function __construct() {

    }

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
    

    public function generate($currMonth, $currYear, $meetingsInfo) {
	  $numDays = 0;
	  $monthName = " ";
	  $firstDayOfWeek = date('N',strtotime($currYear.'-'.$currMonth.'-01'));

	  switch($currMonth){
	  	case 1:
			$numDays = 31;
			$monthName = "January";
			break;
		case 2:
			$numDays = 28;
			$monthName = "February";
			break;
		case 3:
			$numDays = 31;
			$monthName = "March";
			break;
		case 4:
			$numDays = 30;
			$monthName = "April";
			break;
		case 5:
			$numDays = 31;
			$monthName = "May";
			break;
		case 6:
			$numDays = 30;
			$monthName = "June";
			break;
		case 7:
			$numDays = 31;
			$monthName = "July";
			break;
		case 8:
			$numDays = 31;
			$monthName = "August";
			break;
		case 9:
			$numDays = 30;
			$monthName = "September";
			break;
		case 10:
			$numDays = 31;
			$monthName = "October";
			break;
		case 11:
			$numDays = 30;
			$monthName = "November";
			break;
		case 12:
			$numDays = 31;
			$monthName = "December";
			
	}
	$prevMonth = (int)($currMonth - 1) % 12;
	$nextMonth = (int)($currMonth + 1) % 12;
	echo '<div class="calendar">
	<div class="month">      
	  <ul>
	    <li class="prev"><a href="#?currMonth=\'';
	    echo $prevMonth;
	    echo '\'" style="text-decoration:none;">❮</a></li>
	    <li class="next"><a href="#?currMonth=\'';
	    echo $nextMonth;
	    echo '\'" style="text-decoration:none;">❯</a></li>
	    <li style="text-align:center; font-size:45px">';
	    echo $monthName .' ' .$currYear;
	    echo '
	      <br>  
	    </li>
	  </ul>
	</div>

	<ul class="weekdays" style="font-size:20px; font-family:firaReg">
	  <li>Sun</li>
	  <li>Mon</li>
	  <li>Tue</li>
	  <li>Wed</li>
	  <li>Thu</li>
	  <li>Fri</li>
	  <li>Sat</li>
	</ul>

	<ul class="days" style="font-size:20px; font-family:firaReg">';
	  for($i = 0; $i < $firstDayOfWeek; $i++){
	  	echo '<li></li>';
	  }
	  for($x = 1; $x <= $numDays; $x++){	    
		echo '<li><button id="myBtn';
		echo $x;
		echo '" class="button">';
		echo $x;
		echo '</button></li>';	
	  	echo '<!-- The Modal -->
          		<div id="myModal';
		echo $x;
		echo '" class="modal">

            	<!-- Modal content -->
            	<div class="modal-content">
              		<div class="modal-header">
                			<span class="close"> x </span>
                			<h2>Appoinments On ';
		echo $monthName; 
		echo ' ';
		

		echo $x .', '.$currYear;
		echo '</h2>
              		</div>
              		
			<div class="modal-body">
                		<p></p>';
		

				$hasAppt = FALSE;
				foreach ($meetingsInfo as $appt){ 
					$apptMonth = date("m",strtotime($appt["start"]));
					$apptDay = date("d",strtotime($appt["start"]));

					if($apptDay == $x && $apptMonth ==$currMonth){
					$hasAppt = TRUE;
                			echo '<button class="accordion">';
					echo date("H:i", strtotime($appt["start"])).' - '.date("H:i", strtotime($appt["end"]));					echo '</button>
                			<div class="panel">
                  				<br>';
						if($appt["meetingType"] == 0){
							echo 'Individiual Advising<br>';
						}
						else{
							echo 'Group Advising<br>';
						}
						
						
						echo 'Room ' .htmlspecialchars($appt["buildingName"]) .' ' . htmlspecialchars($appt["roomNumber"]);
						echo '

							<form action="../utils/forms/deleteMeetingCalendar.php" method="POST">
                    					<input name="meetingID" value="';
							echo htmlspecialchars($appt["meetingID"]); 
							echo '" style="display:none;">
                    					<input type="submit" value="Delete Meeting">
                					</form><br><br>';



						$studentsInfo = findStudentsInMeeting($appt["meetingID"]);
						if(empty($studentsInfo)){
							echo 'No Students Currently Scheduled';
						}
						else{
							foreach ($studentsInfo as $studentInfo) {
								echo 'Name: ' .htmlspecialchars($studentInfo["firstName"]).' ' .htmlspecialchars($studentInfo["lastName"]).'<br>'; 
                        					echo 'Student ID: ' .htmlspecialchars($studentInfo["schoolID"]).'<br>'; 
                        					echo 'Major: ' .htmlspecialchars($studentInfo["major"]).'<br>'; 
								echo 'Email: ' .htmlspecialchars($studentInfo["email"]) .'<br>'; 
							}
						}
                    				echo '<!--Student Name<br>
                    				Student ID<br>
                    				Student Major<br>-->
                    				<br>
                    			</div>
					<br>';
					}
					
                 		}
					if(!$hasAppt)
						echo 'No appointments Scheduled<br><br>';
                			
                			echo '<script>
                  			var acc = document.getElementsByClassName("accordion");
                  			

                  			for (var i = 0; i < acc.length; i++) {
                                  		acc[i].onclick = function(){
                                  			this.classList.toggle("active");
                                  			this.nextElementSibling.classList.toggle("show");
                                  		}
                                 	}
                       			</script>
				
              		</div>
            	</div> <!--closes modalContent-->
        	</div> <!--closes myModal-->


		<script>
            	// Get the modal
            		var modal';
		echo $x;
		echo ' = document.getElementById("myModal';
		echo $x;
		echo '");

            	// Get the button that opens the modal
            	var btn = document.getElementById("myBtn';
		echo $x;
		echo '");

            	// Get the <span> element that closes the modal
              	var span = document.getElementsByClassName("close")[';
		$index = $x - 1;
		echo $index;
		echo '];

              	// When the user clicks the button, open the modal
              	btn.onclick = function() {
              	modal';
		echo $x;
		echo '.style.display = "block";
              	}

              	// When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                modal';
		echo $x;
		echo '.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                if (event.target == modal';
		echo $x;
		echo ') {
                modal';
		echo $x;
		echo '.style.display = "none";
                }
                }
          	</script>';

	}
    }	
}	
?>