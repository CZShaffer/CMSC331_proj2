<?php
session_start();

// check if user is logged in
if(!isset($_SESSION["HAS_LOGGED_IN"])) {
  header('Location: login.php');
}

include '../advisor/utils/dbconfig.php';
$conn = connectToDB();

// get data to populate sheet
$studentID = $_SESSION['STUDENT_ID'];
$sql = "SELECT * FROM StudentForm WHERE `StudentID` = '$studentID'";
$rs = $conn->query($sql);

error_reporting(0);
if ($rs->num_rows > 0) {
  $row = $rs->fetch_assoc();
//all of the variables needed for the page
  $secondMajor = $row['secondMajor'];
  $minor = $row['minor'];
  $futurePlans = $row['futurePlans'];
  $learningResources = $row['learningResources'];
  $internship = $row['internship'];
  $currentCourse1Name = $row['currentCourse1Name'];
  $currentCourse2Name = $row['currentCourse2Name'];
  $currentCourse3Name = $row['currentCourse3Name'];
  $currentCourse4Name = $row['currentCourse4Name'];
  $currentCourse5Name = $row['currentCourse5Name'];
  $currentCourse6Name = $row['currentCourse6Name'];
  $currentCourse7Name = $row['currentCourse7Name'];
  $plannedCourse1Name = $row['plannedCourse1Name'];
  $plannedCourse2Name = $row['plannedCourse2Name'];
  $plannedCourse3Name = $row['plannedCourse3Name'];
  $plannedCourse4Name = $row['plannedCourse4Name'];
  $plannedCourse5Name = $row['plannedCourse5Name'];
  $plannedCourse6Name = $row['plannedCourse6Name'];
  $plannedCourse7Name = $row['plannedCourse7Name'];
  $plannedCourse1Reason = $row['plannedCourse1Reason'];
  $plannedCourse2Reason = $row['plannedCourse2Reason'];
  $plannedCourse3Reason = $row['plannedCourse3Reason'];
  $plannedCourse4Reason = $row['plannedCourse4Reason'];
  $plannedCourse5Reason = $row['plannedCourse5Reason'];
  $plannedCourse6Reason = $row['plannedCourse6Reason'];
  $plannedCourse7Reason = $row['plannedCourse7Reason'];
  $plannedCourse1Credits = $row['plannedCourse1Credits'];
  $plannedCourse2Credits = $row['plannedCourse2Credits'];
  $plannedCourse3Credits = $row['plannedCourse3Credits'];
  $plannedCourse4Credits = $row['plannedCourse4Credits'];
  $plannedCourse5Credits = $row['plannedCourse5Credits'];
  $plannedCourse6Credits = $row['plannedCourse6Credits'];
  $plannedCourse7Credits = $row['plannedCourse7Credits'];
  $creditsEarned = $row['creditsEarned'];
  $GPA = $row['GPA'];
  $upperLevelCredits = $row['upperLevelCredits'];
  $numWritingIntensives = $row['numWritingIntensives'];
  $numPhysEd = $row['numPhysicalEds'];
  $numEnglishComp = $row['numEnglishComp'];
  $numArtsAndHumanities = $row['numArtsAndHumanities'];
  $numSocialSciences = $row['numSocialSciences'];
  $numMathSci = $row['numMathSciences'];
  $numCulture = $row['numCulture'];
  $languageProficiency = $row['languageProficiency'];
  $performanceReflection = $row['performanceReflection'];
  $studiedWithFriends = $row['studiedWithFriends'];
  $classQuestion = $row['classQuestion'];
  $notes = $row['notes'];
  $BBDiscussion = $row['BBDiscussion'];
  $tutorialCenter = $row['tutorialCenter'];
  $RLCTutor = $row['RLCTutor'];
  $officeHours = $row['officeHours'];
  $emailProfessor = $row['emailProfessor'];
  $volunteerActivities = $row['volunteerActivities'];
  $currentlyEmployed = $row['currentlyEmployed'];
  $commuter = $row['commuter'];
  $commuteHours = $row['commuteHours'];
  $workHours = $row['workHours'];
  $familyHours = $row['familyHours'];
  $extracurricularHours = $row['extracurricularHours'];
  $additionalComments = $row['additionalComments'];
}
//if the page hasnt been filled out and there's no data
else {
  echo "Pre advising worksheet data not found";
}

?>
<!-- html for the page -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Advising Scheduling</title>

    <link rel="icon" type="image/x-icon" href="favicon.png"/>
    <link rel="stylesheet" type="text/css" href="regSheet.css"/>
  </head>
  
  <body>
    <div class="form">
      <form action="sheet.php" method='post' name='regPage'>
	
	<h1>General Information</h1>
	<p><span class="error">* required field.</span></p>
   
	<div class="fieldset">
	<fieldset>
	  <br>
          <!-- drop down list of all UMBC majors to choose second major -->
	  <label for="2ndMajor">2nd Major (if applicable):</label>
	  <select id="2ndMajor" name="2ndMajor">
            <option></option>            
            <option value="<?php echo (isset($secondMajor) ? $secondMajor : ''); ?>" selected="selected"><?php echo (isset($secondMajor) ? $secondMajor : ''); ?></option>
            <option> Acting [BFA]</option>
	    <option> Africana Studies [BA] </option>
	    <option> Cultural Anthropology [BA] </option>
	    <option> Asian Studies [BA] </option>
	    <option> Bioinformatics [BS] </option>
	    <option> Biochemistry & Molecular Biology [BS] </option>
	    <option> Biology Education [BA] </option>
	    <option> Biological Sciences [BA] </option>
	    <option> Biological Sciences [BS] </option>
	    <option> Business Technology Administration [BA] </option>
	    <option> Chemical Engineering [BS]</option>
	    <option> Chemistry Education [BA]</option>
	    <option> Chemistry & Biochemistry [BA]</option>
	    <option> Chemistry & Biochemistry [BS] </option>
	    <option> Computer Engineering [BS]</option>
	    <option> Computer Science [BS] </option>
	    <option> Dance [BA] </option>
	    <option> Design [BFA] </option>
	    <option> Economics [BA] </option>
	    <option> Environmental Science [BS] </option>
	    <option> English [BA] </option>
	    <option> Environmental Studies [BA] </option>
	    <option> Financial Economics [BS] </option>
	    <option> Geography [BA] </option>
	    <option> Geography [BS] </option>
	    <option> Global Studies [BA]</option>
	    <option> Gender and Women’s Studies [BA]</option>
	    <option> Health Administration & Public Policy [BA] </option>
	    <option> Information Systems [BS] </option>
	    <option> Interdisciplinary Studies [BA] </option>
	    <option> Interdisciplinary Studies [BS] </option>
	    <option> Jazz Studies [BA]</option>
	    <option> Mathematics [BA] </option>
	    <option> Mathematics [BS]</option>
	    <option> Management of Aging Services [BA]</option>
	    <option> Media & Communication Studies [BA]</option>
	    <option> Modern Languages and Linguistics [BA]</option>
	    <option> Music [BA] </option>
	    <option> Music Technology [BA]</option>
	    <option> Music Education [BA </option>
	    <option> Music Performance [BA] </option>
	    <option> Music Composition [BA]</option>
	    <option> Philosophy [BA]</option>
	    <option> Physics [BS]</option>
	    <option> Physics Education [BA]</option>
	    <option> Political Science [BA] </option>
	    <option> Psychology [BA] </option>
	    <option> Psychology [BS] </option>
	    <option> Sociology [BA]</option>
	    <option> Social Work [BA]</option>
	    <option> Statistics [BS]</option>
	    <option> Theatre [BA] </option>
	    <option> Visual Arts [BA] </option>
	    <option> Visual Arts [BFA] </option>
	  </select>
	  
	  <br><br>
	  <!-- ability to list if they have a minor -->
	  <label for="tfMinor">Minor(s) (if applicable):</label>
	  <input id="tfMinor" type="text" name="tfMinor" value="<?php echo (isset($minor) ? $minor : ''); ?>">
	  <br><br>	  
	</fieldset>
	</div>
	<!-----------------GOALS-------------------->      
	
	<fieldset>
	  <h2>Goals</h2>
	  <p> Having a goal in mind makes it easier for you to define success. </p>
	  <br>
	  
	  
	  <label for="goal1">What are your plans for the future once your UMBC degree is complete?</label>
	  <span class="error">* </span><br>
	  <textarea id="goal1" name="goal1" cols="40" rows="5" value="<?php echo (isset($futurePlans) ? $futurePlans : ''); ?>" required><?php echo (isset($futurePlans) ? $futurePlans : ''); ?></textarea>
	  <br><br>
	  <label for="goal2">What resources have you used in order to learn more about your career/educational goals?</label>
	  <span class="error">* </span><br>
	  <textarea id="goal2" name="goal2" cols="40" rows="5" value="<?php echo (isset($learningResources) ? $learningResources : ''); ?>" required><?php echo (isset($learningResources) ? $learningResources : ''); ?></textarea>
	  <br><br>
	  <label for="goal3">What research/internship/clinical experience do you have, if any?</label><br>
          <textarea id="goal3" name="goal3" cols="40" rows="5" value="<?php echo (isset($internship) ? $internship : ''); ?>" required><?php echo (isset($internship) ? $internship : ''); ?></textarea>
	</fieldset>
	
	<!-------------------PLANNING------------------>
	
	<fieldset>
	  <h2>Evaluating and Planning Ahead</h2>
	  <p>Planning for the future requires evaluating today.</p>
	  <!-- Below is a table where each <tr> has 4 <td>s and they correspond in order of the <th>s, in 
	  other words, it's arranged by column not by row. Taking a look at the names of the fields will 
	  clarify this if it's still unclear-->
	  <div align="center">
	    <table style="width:100%">
              <tr>
	        <th>Current Courses and Grades</th>
		<th>Proposed Courses for Next Semester</th>
		<th>Reason for Taking the Proposed Course</th>
		<th>Number of Credits for Proposed Course</th>
	      </tr>
	      <tr>
		<td><input type='text' placeholder="ex. BIOL302 A" name='course1' style="width: 99.5%" value="<?php echo (isset($currentCourse1Name) ? $currentCourse1Name : ''); ?>" required></td>
		<td><input type='text' placeholder="ex. BIOL313" name='next1' style="width: 99.5%" value="<?php echo (isset($plannedCourse1Name) ? $plannedCourse1Name : ''); ?>" required></td>
		<td><input type='text' name='reason1' placeholder="ex. 'Major Requirement'" style="width: 99.5%" value="<?php echo (isset($plannedCourse1Reason) ? $plannedCourse1Reason : ''); ?>" required></td>
		<td><input type='text' name='credit1' style="width: 99.5%" value="<?php echo (isset($plannedCourse1Credits) ? $plannedCourse1Credits : ''); ?>" required></td>
	      </tr>
	      <tr>
		<td><input type='text' name='course2' style="width: 99.5%" value="<?php echo (isset($currentCourse2Name) ? $currentCourse2Name : ''); ?>"></td>
		<td><input type='text' name='next2' style="width: 99.5%" value="<?php echo (isset($plannedCourse2Name) ? $plannedCourse2Name : ''); ?>"></td>
		<td><input type='text' name='reason2' style="width: 99.5%" value="<?php echo (isset($plannedCourse2Reason) ? $plannedCourse2Reason : ''); ?>"></td>
		<td><input type='text' name='credit2' style="width: 99.5%" value="<?php echo (isset($plannedCourse2Credits) ? $plannedCourse2Credits : ''); ?>"></td>
	      </tr>
	      <tr>
		<td><input type='text' name='course3' style="width: 99.5%" value="<?php echo (isset($currentCourse3Name) ? $currentCourse3Name : ''); ?>"></td>
		<td><input type='text' name='next3' style="width: 99.5%" value="<?php echo (isset($plannedCourse3Name) ? $plannedCourse3Name : ''); ?>"></td>
		<td><input type='text' name='reason3' style="width: 99.5%" value="<?php echo (isset($plannedCourse3Reason) ? $plannedCourse3Reason : ''); ?>"></td>
		<td><input type='text' name='credit3' style="width: 99.5%" value="<?php echo (isset($plannedCourse3Credits) ? $plannedCourse3Credits : ''); ?>"></td>
	      </tr>
	      <tr>
		<td><input type='text' name='course4' style="width: 99.5%" value="<?php echo (isset($currentCourse4Name) ? $currentCourse4Name : ''); ?>"></td>
		<td><input type='text' name='next4' style="width: 99.5%" value="<?php echo (isset($plannedCourse4Name) ? $plannedCourse4Name : ''); ?>"></td>
		<td><input type='text' name='reason4' style="width: 99.5%" value="<?php echo (isset($plannedCourse4Reason) ? $plannedCourse4Reason : ''); ?>"></td>
		<td><input type='text' name='credit4' style="width: 99.5%" value="<?php echo (isset($plannedCourse4Credits) ? $plannedCourse4Credits : ''); ?>"></td>
	      </tr>
	      <tr>
		<td><input type='text' name='course5' style="width: 99.5%" value="<?php echo (isset($currentCourse5Name) ? $currentCourse5Name : ''); ?>"></td>
		<td><input type='text' name='next5' style="width: 99.5%" value="<?php echo (isset($plannedCourse5Name) ? $plannedCourse5Name : ''); ?>"></td>
		<td><input type='text' name='reason5' style="width: 99.5%" value="<?php echo (isset($plannedCourse5Reason) ? $plannedCourse5Reason : ''); ?>"></td>
		<td><input type='text' name='credit5' style="width: 99.5%" value="<?php echo (isset($plannedCourse5Credits) ? $plannedCourse5Credits : ''); ?>"></td>
	      </tr>
	      <tr>
		<td><input type='text' name='course6' style="width: 99.5%" value="<?php echo (isset($currentCourse6Name) ? $currentCourse6Name : ''); ?>"></td>
		<td><input type='text' name='next6' style="width: 99.5%" value="<?php echo (isset($plannedCourse6Name) ? $plannedCourse6Name : ''); ?>"></td>
		<td><input type='text' name='reason6' style="width: 99.5%" value="<?php echo (isset($plannedCourse6Reason) ? $plannedCourse6Reason : ''); ?>"></td>
		<td><input type='text' name='credit6' style="width: 99.5%" value="<?php echo (isset($plannedCourse6Credits) ? $plannedCourse6Credits : ''); ?>"></td>
	      </tr>
	      <tr>
                <td><input type='text' name='course7' style="width: 99.5%" value="<?php echo (isset($currentCourse7Name) ? $currentCourse7Name : ''); ?>"></td>
                <td><input type='text' name='next7' style="width: 99.5%" value="<?php echo (isset($plannedCourse7Name) ? $plannedCourse7Name : ''); ?>"></td>
                <td><input type='text' name='reason7' style="width: 99.5%" value="<?php echo (isset($plannedCourse7Reason) ? $plannedCourse7Reason : ''); ?>"></td>
                <td><input type='text' name='credit7' style="width: 99.5%" value="<?php echo (isset($plannedCourse7Credits) ? $plannedCourse7Credits : ''); ?>"></td>
              </tr>
	    </table>
	  </div>
	</fieldset>
	
	<!---------------DEGREE AUDIT---------------------->
	
	<fieldset>
	  <h2>Degree Audit</h2>
	  <p>Degree Audit is a helpful tool when choosing your classes and planning for graduation. Track your progress below. In order to access Degree Audit follow these steps:</p>
	  <p><i>Login to myUMBC >> Topics >> Advising and Student Support >> Degree Audit >> Expand All Button</i></p>
	  
	  <h4>Graduation Requirements</h4>
	 
	    <label for="totCred">Number of Credits Earned (120 required):</label>
	    <input id="totCred" name="totCred" type="number" min="0" style="width: 50px" value="<?php echo (isset($creditsEarned) ? $creditsEarned : ''); ?>" required>
	    <span class="error">* </span>
	    <br>
	    <label for="gpa">Current GPA (Minimum GPA of 2.00 required):</label>
	    <input id="gpa" name="gpa" type="number" style="width: 50px" value="<?php echo (isset($GPA) ? $GPA : ''); ?>" required>
	    <span class="error">* </span>
	    <br>
	    <label for="upp">Number of Upper Level Credits Earned (45 required):</label>
	    <input id="upp" name="upp" type="number" min="0" style="width: 40px" value="<?php echo (isset($upperLevelCredits) ? $upperLevelCredits : ''); ?>" required>
	    <span class="error">* </span>
	    <br>
	    <label for="WI">Writing Intensive Courses (1 required):</label>
	    <input id="WI" name="WI" type="number" min="0" style="width: 40px" value="<?php echo (isset($numWritingIntensives) ? $numWritingIntensives : ''); ?>" required>
	    <span class="error">* </span>
	    <br>
	    <label for="PE">Physical Education Courses (2 required):</label>
	    <input id="PE" name="PE" type="number" min="0" style="width: 40px" value="<?php echo (isset($numPhysEd) ? $numPhysEd : ''); ?>" required>
	    <span class="error">* </span>
	 

	  <br>

	  <h4>General Education Requirements</h4>
	  <p>
	 
	    <label for="eng">English Composition (1 required):</label>
	    <input id="eng" name="eng" type="number" min="0" style="width: 40px" value="<?php echo (isset($numEnglishComp) ? $numEnglishComp : ''); ?>" required>
	    <span class="error">* </span>
	    <br>
	    <label for="AH">Arts and Humanities (3 required):</label>
	    <input id="AH" name="AH" type="number" min="0" style="width: 40px" value="<?php echo (isset($numArtsAndHumanities) ? $numArtsAndHumanities : ''); ?>" required>
	    <span class="error">* </span>
	    <br>
	    <label for="SS">Social Sciences (3 required):</label>
            <input id ="SS" name="SS" type="number" min="0" style="width: 40px" value="<?php echo (isset($numSocialSciences) ? $numSocialSciences : ''); ?>" required>
	    <span class="error">* </span>
            <br>
            <label for="mathSci">1 Math and 2 Sciences (included in major):
            <input id="mathSci" name="MS" type="number" min="0" style="width: 40px" value="<?php echo (isset($numMathSci) ? $numMathSci : ''); ?>" required>
	    <span class="error">* </span>
	    <br>
	    <label for="cult">Culture (1 required for BS, 2 for BA):</label>
	    <input id="cult" name="cult" type="number" min="0" style="width: 40px" value="<?php echo (isset($numCulture) ? $numCulture : ''); ?>" required>
	    <span class="error">* </span>
	    <br>
	    <label for="lang">201 Language Proficiency completed:</label>
	    <select id="lang" name="lang" required>
	      <option value="<?php echo (isset($languageProficiency) ? $languageProficiency : ''); ?>"></option>
	      <option value="TRUE">Yes</option>
	      <option value="FALSE">No</option>
	    </select>
	    <span class="error">* </span>
	    
	 </fieldset>
	
	
	<!-----ACADEMIC PROGRESS------>

	<fieldset>
	  <h2>Assess Your Academic Progress</h2>
	  <p>Make good academic decisions by identifying your strengths and weaknesses.</p>
	  <br>
	  <label for="accProg">Think about your academic performance this semester. What are you most proud of? What are you most disappointed in? How do you plan to continue/improve your academic habits next semester?</label>
	  <span class="error">* </span><br>
	  <textarea id="accProg" name="accProg" cols="40" rows="5" value="<?php echo (isset($performanceReflection) ? $performanceReflection : ''); ?>" required><?php echo (isset($performanceReflection) ? $performanceReflection : ''); ?></textarea>
	  
	  <br>
	  <p>I have used the following academic resources/strategies this semester: (Check all that apply)
	    <span class="error">* </span></p>
	  
	  <input id="resource1" type="checkbox" name="resource1" value="1" <?php echo ($studiedWithFriends ? 'checked' : ''); ?>>
	  <label for="resource1">Studied with friends/classmates</label>
	  <br>
          <input id="resource2" type="checkbox" name="resource2" value="1" <?php echo ($classQuestion ? 'checked' : ''); ?>>
	  <label for="resource2">Asked questions before/during/after class</label>
	  <br>
          <input id="resource3" type="checkbox" name="resource3" value="1" <?php echo ($notes ? 'checked' : ''); ?>>
	  <label for="resource3">Took notes in class and reviewed them regularly</label>
	  <br>
          <input id="resource4" type="checkbox" name="resource4" value="1" <?php echo ($BBDiscussion ? 'checked' : ''); ?>>
	  <label for="resource4">Participated in Blackboard discussion</label>
	  <br>
          <input id="resource5" type="checkbox" name="resource5" value="1" <?php echo ($tutorialCenter ? 'checked' : ''); ?>>
	  <label for="resource5">Utilized the Biology/Chemistry/Math/Physics Tutorial Centers</label>
	  <br>
          <input id="resource6" type="checkbox" name="resource6" value="1" <?php echo ($RLCTutor ? 'checked' : ''); ?>>
	  <label for="resource6">Received tutoring through the Learning Resource Center (LRC)</label>
	  <br>
          <input id="resource7" type="checkbox" name="resource7" value="1" <?php echo ($officeHours ? 'checked' : ''); ?>>
	  <label for="resource7">Visited my professors/TAs during office hours</label>
	  <br>
          <input id="resource8" type="checkbox" name="resource8" value="1" <?php echo ($emailProfessor ? 'checked' : ''); ?>>
	  <label for="resource8">Emailed my professors/TAs with questions</label>
	</fieldset>
	
	<!----------------TIME COMMITMENTS-------------------->
	
	<fieldset>
	  <h2>Assess Your Time Commitments</h2>
	  <p>Successful students manage their time well.</p>
	  <br>
	  <label for="timeComm1">What are your current volunteer and co-curricular activities, if any?</label><br>
				      <textarea id="timeComm1" name="timeComm1" cols="40" rows="5" value="<?php echo (isset($volunteerActivities) ? $volunteerActivities : ''); ?>" required><?php echo (isset($volunteerActivities) ? $volunteerActivities : ''); ?></textarea>
	  <br><br>
	  <label for="timeComm2">Are you presently employed and/or have family responsibilities? How many hours a week?</label><br>
				      <textarea id="timeComm2" name="timeComm2" cols="40" rows="3" value="<?php echo (isset($currentlyEmployed) ? $currentlyEmployed : ''); ?>" required><?php echo (isset($currentlyEmployed) ? $currentlyEmployed : ''); ?></textarea>
	  <br><br>
	  <label for="timeComm3">Are you a commuter student? If so, how long is your commute?</label><br>
				      <textarea id="timeComm3" name="timeComm3" cols="40" rows="3" value="<?php echo (isset($commuter) ? $commuter : ''); ?>" required><?php echo (isset($commuter) ? $commuter : ''); ?></textarea>
	  
	  <p><i>Next semester</i>, I will:<span class="error">*</span>
	  </p>

	  <label for="commute">Commute (</label>
	  <input id="commute" name="commute" type="number" min="0" style="width: 30px" value="<?php echo (isset($commuteHours) ? $commuteHours : ''); ?>" required>
          <label for="commute">hours per week)</label>
	  <br>

          <label for="work">Work (</label>
	  <input id="work" name="work" type="number" min="0" style="width: 30px" value="<?php echo (isset($workHours) ? $workHours : ''); ?>" required>
	  <label for="work">hours per week)</label>
	  <br>

          <label for="fam">Family Responsibilities (</label>
	  <input id="fam" name="fam" type="number" min="0" style="width: 30px" value="<?php echo (isset($familyHours) ? $familyHours : ''); ?>" required> 
	  <label for="fam">hours per week)</label>
	  <br>

	  <label for="extra">Extracurricular Activities (</label>
	  <input id="extra" name="extra" type="number" min="0" style="width: 30px" value="<?php echo (isset($extracurricularHours) ? $extracurricularHours : ''); ?>" required>
	  <label for="extra">hours per week)</label>
	</fieldset>
	
	<!----------------QUESTIONS--------------------->      
	
	<fieldset>
	  <label for="question"><h2>Additional Questions, Comments, and Concerns:</h2></label>
				      <textarea id="question" name="question" cols="40" rows="5" value="<?php echo (isset($additionalComments) ? $additionalComments : ''); ?>"><?php echo (isset($additionalComments) ? $additionalComments : ''); ?></textarea>
	</fieldset>
	
	<!------------------------------------->
	
	<div class="nextbutton">
	  <input type="submit"  value="Submit" name="Submit">
	</div>
      </form>
    </div>
  </body>
</html>
