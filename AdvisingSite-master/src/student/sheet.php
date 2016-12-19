<?php
session_start();

// redirect user to login page if they are not logged in
if(!isset($_SESSION["HAS_LOGGED_IN"])){
  header("Location: login.php");
}

include('../CommonMethods.php');
$debug = true;
$COMMON = new Common($debug);

//setting the variables to the inputed values in the form
$major2 = isset($_POST['2ndMajor']) ? $_POST['2ndMajor'] : "";
$minor = isset($_POST['tfMinor']) ? $_POST['tfMinor'] : "";
$goal1 = isset($_POST['goal1']) ? $_POST['goal1'] : "";
$goal2 = isset($_POST['goal2']) ? $_POST['goal2'] : "";
$goal3 = isset($_POST['goal3']) ? $_POST['goal3'] : "";
$currClass1 = isset($_POST['course1']) ? $_POST['course1']: "";
$currClass2 = isset($_POST['course2']) ? $_POST['course2']: "";
$currClass3 = isset($_POST['course3']) ? $_POST['course3']: "";
$currClass4 = isset($_POST['course4']) ? $_POST['course4']: "";
$currClass5 = isset($_POST['course5']) ? $_POST['course5']: "";
$currClass6 = isset($_POST['course6']) ? $_POST['course6']: "";
$currClass7 = isset($_POST['course7']) ? $_POST['course7']: "";
$nextClass1 = isset($_POST['next1']) ? $_POST['next1']: "";
$nextClass2 = isset($_POST['next2']) ? $_POST['next2']: "";
$nextClass3 = isset($_POST['next3']) ? $_POST['next3']: "";
$nextClass4 = isset($_POST['next4']) ? $_POST['next4']: "";
$nextClass5 = isset($_POST['next5']) ? $_POST['next5']: "";
$nextClass6 = isset($_POST['next6']) ? $_POST['next6']: "";
$nextClass7 = isset($_POST['next7']) ? $_POST['next7']: "";
$reason1 = isset($_POST['reason1']) ? $_POST['reason1']: "";
$reason2 = isset($_POST['reason2']) ? $_POST['reason2']: "";
$reason3 = isset($_POST['reason3']) ? $_POST['reason3']: "";
$reason4 = isset($_POST['reason4']) ? $_POST['reason4']: "";
$reason5 = isset($_POST['reason5']) ? $_POST['reason5']: "";
$reason6 = isset($_POST['reason6']) ? $_POST['reason6']: "";
$reason7 = isset($_POST['reason7']) ? $_POST['reason7']: "";
$numCred1 = isset($_POST['credit1']) ? $_POST['credit1']: "";
$numCred2 = isset($_POST['credit2']) ? $_POST['credit2']: "";
$numCred3 = isset($_POST['credit3']) ? $_POST['credit3']: "";
$numCred4 = isset($_POST['credit4']) ? $_POST['credit4']: "";
$numCred5 = isset($_POST['credit5']) ? $_POST['credit5']: "";
$numCred6 = isset($_POST['credit6']) ? $_POST['credit6']: "";
$numCred7 = isset($_POST['credit7']) ? $_POST['credit7']: "";
$totCred = isset($_POST['totCred']) ? $_POST['totCred']: "";
$gpa = isset($_POST['gpa']) ? $_POST['gpa']: "";
$uppLevel = isset($_POST['upp']) ? $_POST['upp']: "";
$WI = isset($_POST['WI']) ? $_POST['WI']: "";
$PE = isset($_POST['PE']) ? $_POST['PE']: "";
$engCred = isset($_POST['eng']) ? $_POST['eng']: "";
$AHCred = isset($_POST['AH']) ? $_POST['AH']: "";
$SSCred = isset($_POST['SS']) ? $_POST['SS']: "";
$mathSciCredit = isset($_POST['MS']) ? $_POST['MS']: "";
$cultCred = isset($_POST['cult']) ? $_POST['cult']: "";
$langCred = isset($_POST['lang']) ? $_POST['lang']: "";
$accProg = isset($_POST['accProg']) ? $_POST['accProg']: "";
$resource1 = isset($_POST['resource1']) ? true : false;
$resource2 = isset($_POST['resource2']) ? true : false;
$resource3 = isset($_POST['resource3']) ? true : false;
$resource4 = isset($_POST['resource4']) ? true : false;
$resource5 = isset($_POST['resource5']) ? true : false;
$resource6 = isset($_POST['resource6']) ? true : false;
$resource7 = isset($_POST['resource7']) ? true : false;
$resource8 = isset($_POST['resource8']) ? true : false;
$timeComm1 = isset($_POST['timeComm1']) ? $_POST['timeComm1']: "";
$timeComm2 = isset($_POST['timeComm2']) ? $_POST['timeComm2']: "";
$timeComm3 = isset($_POST['timeComm3']) ? $_POST['timeComm3']: "";
$commute = isset($_POST['commute']) ? $_POST['commute']: "";
$work = isset($_POST['work']) ? $_POST['work']: "";
$family = isset($_POST['fam']) ? $_POST['fam']: "";
$extraAc = isset($_POST['extra']) ? $_POST['extra']: "";
$question = isset($_POST['question']) ? $_POST['question']: "";

//inserting the variabes into the table                                           
$id = $_SESSION['STUDENT_ID'];

//deleting the information from the student table to insert the new information, could have also used UPDATE
$sql = "DELETE FROM StudentForm WHERE StudentID = $id";

$result = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

//inserting new data into the database
$sql = "INSERT INTO StudentForm (`StudentID`, `secondMajor`, `minor`, `futurePlans`, `learningResources`, `internship`, `currentCourse1Name`, `currentCourse2Name`, `currentCourse3Name`, `currentCourse4Name`, `currentCourse5Name`, `currentCourse6Name`, `currentCourse7Name`, `plannedCourse1Name`, `plannedCourse2Name`, `plannedCourse3Name`, `plannedCourse4Name`, `plannedCourse5Name`, `plannedCourse6Name`, `plannedCourse7Name`, `plannedCourse1Reason`, `plannedCourse2Reason`, `plannedCourse3Reason`, `plannedCourse4Reason`, `plannedCourse5Reason`, `plannedCourse6Reason`, `plannedCourse7Reason`, `plannedCourse1Credits`, `plannedCourse2Credits`, `plannedCourse3Credits`, `plannedCourse4Credits`, `plannedCourse5Credits`, `plannedCourse6Credits`,`plannedCourse7Credits`, `creditsEarned`, `GPA`, `upperLevelCredits`, `numWritingIntensives`, `numPhysicalEds`, `numEnglishComp`, `numArtsAndHumanities`, `numSocialSciences`, `numMathSciences`, `numCulture`, `languageProficiency`, `performanceReflection`, `studiedWithFriends`, `classQuestion`, `notes`, `BBDiscussion`, `tutorialCenter`, `RLCTutor`, `officeHours`, `emailProfessor`, `volunteerActivities`, `currentlyEmployed`, `commuter`, `commuteHours`, `workHours`, `familyHours`, `extracurricularHours`, `additionalComments`) 

        VALUES ('$id', '$major2', '$minor', '$goal1', '$goal2', '$goal3', '$currClass1', '$currClass2', '$currClass3', '$currClass4', '$currClass5', '$currClass6', '$currClass7', '$nextClass1', '$nextClass2', '$nextClass3', '$nextClass4', '$nextClass5', '$nextClass6', '$nextClass7', '$reason1', '$reason2', '$reason3', '$reason4', '$reason5', '$reason6', '$reason7', '$numCred1', '$numCred2', '$numCred3', '$numCred4', '$numCred5', '$numCred6', '$numCred7', '$totCred', '$gpa', '$uppLevel', '$WI', '$PE', '$engCred', '$AHCred', '$SSCred', '$mathSciCredit', '$cultCred', '$langCred', '$accProg', '$resource1', '$resource2', '$resource3', '$resource4', '$resource5', '$resource6', '$resource7', '$resource8', '$timeComm1', '$timeComm2', '$timeComm3', '$commute', '$work', '$family', '$extraAc', '$question')";

$result = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

header('location: homePage.php');
?>
