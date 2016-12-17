<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Advising Calendar</title>
    <link rel="stylesheet" type="text/css" href="calendarStyle.css" />

  </head>
  <body>
    <div id="content-container">
      <div id="content">
	<h1>Appointment Calendar</h1>
	<div class="calendar">
	<div class="month">      
	  <ul>
	    <li class="prev">❮</li>
	    <li class="next">❯</li>
	    <li style="text-align:center; font-size:45px">
	      December<br>  
	    </li>
	  </ul>
	</div>

	<ul class="weekdays" style="font-size:20px; font-family:firaReg">
	  <li>Mon</li>
	  <li>Tue</li>
	  <li>Wed</li>
	  <li>Thu</li>
	  <li>Fri</li>
	  <li>Sat</li>
	  <li>Sun</li>
	</ul>
	
	<ul class="days" style="font-size:20px; font-family:firaReg">
	<?php 
	  $numDays = 31;
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
                			<h2>Appoinments December ';
		

		echo $x;
		echo ', 2016</h2>
              		</div>
              		
			<div class="modal-body">
                			<p></p>
		
                			<button class="accordion">10:00-10:30AM</button>
                			<div class="panel">
                  			<p>Group Appointment
                    			<br>Location<br><br>
                    			John Smith<br>
                    			AB12345<br>
                    			Biology B.S.<br>
                    			<br>
                    			Jane Doe<br>
                    			CD67899<br>
                    			Chemistry B.S.<br>
                  			</p>
                			</div>

                 		<button class="accordion">1:00-1:30PM</button>
                			<div class="panel">
                  			<p>Individual Appointment<br>
                    			Location
                    			<br><br>
                    			Real Name<br>
                    			AB12345<br>
                    			Environmental Science B.A.<br>
                  			</p>
                			</div>

                			<button class="accordion">2:00-2:30PM</button>
                			<div id="foo" class="panel">
                  			<p>Available Group Appointment</p>
                			</div>

                			<br>
                			<script>
                  			var acc = document.getElementsByClassName("accordion");
                  			var i;

                  			for (i = 0; i < acc.length; i++) {
                                  		acc[i].onclick = function(){
                                  			this.classList.toggle("active");
                                  			this.nextElementSibling.classList.toggle("show");
                                  		}
                                 	}
                       		</script>
              		</div>
            	</div>
        		</div>


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
	?>
	</ul>
	</div>
      </div>
    </div>


   <script src="calendarJS.js"></script>
  </body>
</html>



