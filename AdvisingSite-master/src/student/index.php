<?php
include '../CommonMethods.php';

// check if advising season is over
$debug = true;
$COMMON = new Common($debug);
$filename = "index.php";

// get isSeasonOver from AdvisingSeason table
$select_isSeasonOver  = "SELECT isSeasonOver FROM AdvisingSeason";
$select_results = $COMMON->executequery($select_isSeasonOver, $filename);

if(mysql_num_rows($select_results) == 0){
  echo "This error shouldn't happen";
}

$results_row = mysql_fetch_array($select_results);
$isSeasonOver = $results_row[0];

// redirect user to seasonOver.html if the season is over
if($isSeasonOver) {
  header("Location: seasonOver.html");
}

$email_error_message = $fName_error_message = $lName_error_message = "";
$schoolID_error_message = $major_error_message = "";
$email = $fName = $lName = $schoolID = $major = "";

if($_POST){
 
  //defining variables used for query
  $email = $_POST["email"];
  $fName = $_POST["fName"];
  $mName = $_POST["mName"];
  $lName = $_POST["lName"];
  $schoolID = $_POST["schoolID"];
  $major = $_POST["major"]; 
  
  //regex for email validation 
  $email_validation = '/^[A-Za-z0-9_]+@[A-Za-z0-9]+\.[A-za-z0-9]{3}$/';
  
  //boolean to determine if email is invalid
  $invalid_email = false;
  
  //boolean to determine if miscellanious error has occured
  $misc_error = false;
  
  //boolean to determine if student record exists in db
  $student_exists = false;
  
  //query for student validation
  $student_val_query = "SELECT * FROM Student WHERE email = '$email'";
  
  //query execution
  $validation_query = $COMMON->executequery($student_val_query, $filename);

  //determines if atleast one record exists with entered email
  if(mysql_num_rows($validation_query) > 0){
    $student_exists = true;
    $email_error_message = "Record exists for ". $email;
  }
  
  //email validation, may not need nested ifs
  if(!preg_match($email_validation, $email)){
    
    $invalid_email = true;
  
    if(empty($_POST["email"]) || $invalid_email == true){
      //echo "<br>Please enter email.<br>";
      $misc_error = true;
      $email_error_message = "*Please enter a valid e-mail address.*";
    }
  
    if(empty($_POST["fName"])){
      //echo "<br>Please enter first name.<br>";
      $misc_error = true;
      $fName_error_message = "*Please enter your first name.*";
    }
    
    if(empty($_POST["lName"])){
      //echo "<br>Please enter last name.<br>";
      $misc_error = true;
      $lName_error_message = "*Please enter your last name.*";
    }
    
    if(empty($_POST["schoolID"])){
      //echo "<br>Please enter school id.<br>";
      $misc_error = true;
      $schoolID_error_message = "*Please enter your school ID.*";
    }
    
    if(empty($_POST["major"])){
      //echo "<br>Please enter major.<br>";
      $misc_error = true;
      $major_error_message = "*Please enter your major.*";
    }
  }
  
  //additional field validation
  if(preg_match($email_validation, $email)){
 
    if(empty($_POST["email"])){
      //echo "<br>Please enter email.<br>";
      $misc_error = true;
      $email_error_message = "*Please enter an e-mail address.*";
    }
    
    if(empty($_POST["fName"])){
      //echo "<br>Please enter first name.<br>";
      $misc_error = true;
      $fName_error_message = "*Please enter your first name.*";
    }
    
    if(empty($_POST["lName"])){
      //echo "<br>Please enter last name.<br>";
      $misc_error = true;
      $lName_error_message = "*Please enter your last name.*";
    }
    
    if(empty($_POST["schoolID"])){
      //echo "<br>Please enter school id.<br>";
      $misc_error = true;
      $schoolID_error_message = "*Please enter your school ID.*";
    }
    
    if(empty($_POST["major"])){
      $misc_error = true;
      $major_error_message = "*Please enter your major.*";
    }
  }
  

  //query activity after determining if no errors have occured
  if($invalid_email == false && $misc_error == false && $student_exists == false){
        
    $sql = "INSERT INTO Student (email,firstName,middleName,lastName,schoolID,major) VALUES ('$email','$fName','$mName','$lName', '$schoolID','$major')";
    
    //executes query and redirects to login
    if($rs = $COMMON->executeQuery($sql,$fileName)){
      header('Location: login.php');
    }
  }
}
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../Styles/style.css">
<!--<style = "text/css">
  .error {color: #FF0000;}
	  select{
	  display: inlinr-block;
	  float: left;
	  width: 170px;
	  }  
  label{
display: inline-block;  
float: left;
clear: left;
width: 100px;
text-align: left;
}
  input {
display: inline-block;
float: left;
}
</style>   -->

<title>Student Registration</title>

</head>

<body>

<div id="content-container">
<div id="content">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

 <h1>Welcome! Please complete the registration form.</h1>

<br>
  <label>Email</label><input type="text" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
  <span class="error"> <?php echo $email_error_message;?></span>
<br>

<br>
  <label>First Name</label><input type="text" name="fName" value="<?php echo (isset($_POST['fName']) ? $_POST['fName'] : ''); ?>">
  <span class="error"> <?php echo $fName_error_message;?></span>
<br>

<br>
 <label>Middle Name</label><input type="text" name="mName" value="<?php echo (isset($_POST['mName']) ? $_POST['mName'] : ''); ?>">
<br>

<br>
  <label>Last Name</label><input type="text" name="lName" value="<?php echo (isset($_POST['lName']) ? $_POST['lName'] : ''); ?>">
  <span class="error"> <?php echo $lName_error_message;?></span>
<br>

<br>
  <label>School ID</label><input type="varchar" name="schoolID" value="<?php echo (isset($_POST['schoolID']) ? $_POST['schoolID'] : ''); ?>">
  <span class="error"> <?php echo $schoolID_error_message;?></span>
<br>

<br>
  <label>Major</label><!--<input type="text" name="major" >-->
	  <select name="major">
	  <option value="">Please choose a major</option>
          <option value="BioSciBA">Biological Sciences BA</option>
	  <option value="BioSciBS">Biological Sciences BS</option>
	  <option value="BioChem">Biochemistry & Molecular Biology BS</option>
	  <option value="BioInfo">Bioinformatics & Computational Biology BS</option>
	  <option value="BioEd">Biology Education BA</option>
	  <option value="ChemBA">Chemistry BA</option>
	  <option value="ChemBS">Chemistry BS</option>
	  <option value="ChemEd">Chemistry Education BA</option>
</select>
  <span class="error"> <?php echo $major_error_message;?></span>
<br>

<br>
<input type="submit">
<br>

</form>
</div>
</div>

</body>


<br>
<h3><a href="login.php"> Have you already registered? Log in here. </a></h3> 
</html>