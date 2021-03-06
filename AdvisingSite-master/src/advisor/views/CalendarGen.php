<?php 
  class CalendarGen {
    public function __construct() {
	$this->navHref = htmlentities($_SERVER['PHP_SELF']);
    }
    private $naviHref= null;


public function findStudentsInMeeting($meetingID) {
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
	$prevMonth = (int)(($currMonth - 1) % 12);
	if($prevMonth == 0) $prevMonth = 12;
	$prevYear = $currYear;
	if($prevMonth == 12) $prevYear--;
	$nextMonth = (int)($currMonth % 12) + 1;
	$nextYear= $currYear;
	if($nextMonth == 1) $nextYear++;
	echo '<div class="calendar">
	<div class="month">      
	  <ul>
	    <li class="prev"><a href="' .$this->navHref .'?month='.$prevMonth .'&year='.$prevYear .'" style="text-decoration:none;color:white;">❮</a></li>
	    <li class="next"><a href="' .$this->navHref .'?month='.$nextMonth .'&year='.$nextYear .'" style="text-decoration:none;color:white;">❯</a></li>
	    <li style="text-align:center; font-size:45px">'
	     .$monthName .' ' .$currYear
		.'<br>  
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
	  	echo '<li><button id="empty" class="buttonEmpty" style=""></button></li>';
		echo '<!-- The Modal -->
          		<div id="myModal';
		echo $x;
		echo '" class="modal">

            	<!-- Modal content -->
            	<div class="modal-content">
              		<div class="modal-header">
                			
              		</div>
              		
			<div class="modal-body">
		</div></div></div>';
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
                			<h2>Appointments on ';
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
					echo ltrim(date("h:i A", strtotime($appt["start"])),0).' - '.ltrim(date("h:i A", strtotime($appt["end"])),0);					
					echo '</button>
                			<div class="panel">
                  				<br>';
						if($appt["meetingType"] == 0){
							echo 'Individiual Advising<br>';
						}
						else{
							echo 'Group Advising<br>';
						}
						
						
						echo 'Room ' .htmlspecialchars($appt["buildingName"]) .' ' . htmlspecialchars($appt["roomNumber"]);
						
							//$_SESSION["advisorMeetingID"] = $appt["meetingID"];
							echo '<br><br><a href="editAppointment.php?advisorMeetingID=' .$appt["meetingID"] .'"><button>Edit Appointment</button></a>
							<br><br>

							<form action="../utils/forms/deleteMeetingCalendar.php" method="POST">
                    					<input name="meetingID" value="';
							echo htmlspecialchars($appt["meetingID"]); 
							echo '" style="display:none;">
                    					<input type="submit" value="Delete Appointment">
                					</form><br><br>';



						$studentsInfo = findStudentsInMeeting($appt["meetingID"]);
						if(empty($studentsInfo)){
							echo 'No students currently scheduled';
						}
						else{
							foreach ($studentsInfo as $studentInfo) {
								echo 'Name: ' .htmlspecialchars($studentInfo["firstName"]).' ' .htmlspecialchars($studentInfo["lastName"]).'<br>'; 
                        					echo 'Student ID: ' .htmlspecialchars($studentInfo["schoolID"]).'<br>'; 
								$major = $studentInfo["major"];
								if($major == 'BioSciBA')
									$major = 'Biological Sciences B.A.';
								if($major == 'BioSciBS')	
									$major = 'Biological Sciences B.S.';
								if($major == 'BioChem')	
									$major = 'Biochemistry and Molecular Biology B.S.';
								if($major == 'BioInfo')	
									$major = 'Bioinformatics and Computational Biology B.S.';
								if($major == 'BioEd')	
									$major = 'Biology Education B.A.';
								if($major == 'ChemBA')	
									$major = 'Chemistry B.A.';
								if($major == 'ChemBS')	
									$major = 'Chemistry B.S.';
								if($major == 'ChemEd')
									$major = 'Chemistry Education B.A.';
                        					echo 'Major: ' .htmlspecialchars($major) .'<br>'; 
								echo 'Email: ' .htmlspecialchars($studentInfo["email"]) .'<br>'; 
								
								//$_SESSION['MEETING_ID'] = $appt["meetingID"];
								//echo '<a href="removeStudentConfirmation.php?removeStudentID=' .htmlspecialchars($studentInfo["schoolID"]) 
								//.'&name=' .htmlspecialchars($studentInfo["firstName"]).' ' .htmlspecialchars($studentInfo["lastName"]) 
								//.'&date=' .$apptMonth ."/" .$apptDay .'&meetingID=' .htmlspecialchars($appt["meetingID"]) .'"><button>Remove Student</button></a>';
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
					if($hasAppt){
						echo '<script>
							//document.getElementById("myBtn' .$x .'").className.replace( /(?:^|\s) (?!\S)/g , \'\' );
							document.getElementById("myBtn' .$x .'").className = "buttonActive";
						</script>';
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
	echo '</ul></div>';
    }	
}	
?>
