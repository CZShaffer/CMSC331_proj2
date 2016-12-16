<?php

//include('./dropDB.php');
include('./commonMethods.php');

$filename = 'setUpDB.php';

//echo("making tables");
$COMMON = new Common(false);
$sqlCommand = "CREATE TABLE Student(
  StudentID int(7) PRIMARY KEY UNIQUE AUTO_INCREMENT NOT NULL, 
  email text NOT NULL,
  firstName text NOT NULL,
  middleName text NULL,
  lastName text NOT NULL,
  schoolID VARCHAR(7) NOT NULL,
  major text NOT NULL,
  meetingStatus text NOT NULL
);";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "CREATE TABLE StudentMeeting(
  StudentMeetingID int(11) PRIMARY KEY UNIQUE AUTO_INCREMENT NOT NULL,
  StudentID int(7) NOT NULL,
  MeetingID int(11) NOT NULL
);";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "CREATE TABLE Advisor(
  advisorID int(11) PRIMARY KEY UNIQUE AUTO_INCREMENT NOT NULL,
  email VARCHAR(50) NOT NULL,
  firstName text NOT NULL,
  middleName text NULL,
  lastName text NOT NULL,
  buildingName text NOT NULL,
  roomNumber text NOT NULL
);";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "CREATE TABLE AdvisorMeeting(
  AdvisorMeetingID int(11) PRIMARY KEY UNIQUE AUTO_INCREMENT NOT NULL,
  AdvisorID int(7) NOT NULL,
  MeetingID int(7) NOT NULL
);";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "CREATE TABLE Meeting(
  meetingID int(11) PRIMARY KEY UNIQUE AUTO_INCREMENT NOT NULL,
  start datetime NOT NULL,
  end datetime NOT NULL,
  buildingName text NOT NULL,
  roomNumber text NOT NULL,
  RmeetingType tinyint(1) NOT NULL,
  numStudents tinyint(2) NOT NULL,
  studentLimit tinyint(2) NOT NULL
);";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "CREATE TABLE StudentForm(
  studentFormID int(11) PRIMARY KEY UNIQUE AUTO_INCREMENT NOT NULL,
  StudentID int(7) NOT NULL UNIQUE,
  secondMajor text NULL,
  futurePlans text NULL ,
  learningResources text NULL,
  internship text NULL,
  currentCourse1Name text NULL,
  currentCourse2Name text NULL,
  currentCourse3Name text NULL,
  currentCourse4Name text NULL,
  currentCourse5Name text NULL,
  currentCourse6Name text NULL,
  currentCourse7Name text NULL,
  plannedCourse1Name text NULL,
  plannedCourse2Name text NULL,
  plannedCourse3Name text NULL,
  plannedCourse4Name text NULL,
  plannedCourse5Name text NULL,
  plannedCourse6Name text NULL,
  plannedCourse7Name text NULL,
  plannedCourse1Reason text NULL,
  plannedCourse2Reason text NULL,
  plannedCourse3Reason text NULL,
  plannedCourse4Reason text NULL,
  plannedCourse5Reason text NULL,
  plannedCourse6Reason text NULL,
  plannedCourse7Reason text NULL,
  plannedCourse1Credits TINYINT NULL,
  plannedCourse2Credits TINYINT NULL,
  plannedCourse3Credits TINYINT NULL,
  plannedCourse4Credits TINYINT NULL,
  plannedCourse5Credits TINYINT NULL,
  plannedCourse6Credits TINYINT NULL,
  plannedCourse7Credits TINYINT NULL,
  creditsEarned SMALLINT NOT NULL,
  GPA FLOAT NOT NULL,
  upperLevelCredits SMALLINT NOT NULL,
  numWritingIntensives TINYINT NOT NULL,
  numEnglishComp TINYINT NOT NULL,
  numArtsAndHumanities TINYINT NOT NULL,
  numCulture TINYINT NOT NULL,
  languageProficiency BOOLEAN NOT NULL,
  performanceReflection text NULL,
  studiedWithFriends BOOLEAN NOT NULL,
  classQuestion BOOLEAN NOT NULL,
  notes BOOLEAN NOT NULL,
  BBDiscussion BOOLEAN NOT NULL,
  tutorialCenter BOOLEAN NOT NULL,
  RLCTutor BOOLEAN NOT NULL,
  officeHours BOOLEAN NOT NULL,
  emailProfessor BOOLEAN NOT NULL,
  volunteerActivities text NULL,
  currentlyEmployed text NULL,
  commuter text NULL,
  commuteHours TINYINT NOT NULL,
  workHours TINYINT NOT NULL NULL,
  familyHours SMALLINT NOT NULL,
  extracurricularHours SMALLINT NOT NULL,
  additionalComments text NULL  
);";
$rs = $COMMON->executeQuery($sqlCommand, $filename);

$sqlCommand = "CREATE TABLE Season(isSeasonOver tinyint(1) NOT NULL DEFAULT=1);";
$rs = $COMMON->executeQuery($sqlCommand, $filename);


?>

