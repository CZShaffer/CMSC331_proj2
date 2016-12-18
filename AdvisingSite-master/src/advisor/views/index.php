<?php
session_start();

// Checks to see if the user is logged in, if so it redirects them to homepage
if (isset($_SESSION["HAS_LOGGED_IN"])) {
    if ($_SESSION["HAS_LOGGED_IN"]) {
        header('Location: calendarHomepage.php');
    }
}
?>

<html>
<head>
    <link rel="icon" type="image/png" href="../../Styles/images/umbc.png">
<link rel="stylesheet" type="text/css" href="../../Styles/style.css">
<title>Advisor Registration</title>

</head>
<body>
<div id="content-container">
<div id="content">


<h1>Advisor Registration Form</h1>



<!--<hr> -->

<!-- Use the htmlspecial chars to protect from XSS and CSSR -->
<form action="../utils/forms/registerAdvisor.php" method="post">
    	
            <label>
                First Name:
            </label> <input type="text" name="fName" value="<?php echo (isset($_SESSION['fName']) ? $_SESSION['fName'] : ''); ?>">
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"]);
            }
            ?>
     	<p><br></p>
            <label>
                Middle Name: 
            </label><input type="text" name="mName" value="<?php echo (isset($_SESSION['mName']) ? $_SESSION['mName'] : ''); ?>">
      <p><br></p>
            <label>
                Last Name:
            </label> <input type="text" name="lName" value="<?php echo (isset($_SESSION['lName']) ? $_SESSION['lName'] : ''); ?>">
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"]);
            }
            ?>
     	<p><br></p>
            <label>E-mail:</label> 
	    <input type="email" name="email" value="<?php echo (isset($_SESSION['email']) ? $_SESSION['email'] : ''); ?>">
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"]);
            }
            ?>
       	
	<p><br></p>
            <label>
                Office Building Name:
            </label> <input type="text" name="bldgName" value="<?php echo (isset($_SESSION['bldgName']) ? $_SESSION['bldgName'] : ''); ?>">	
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"]);
            }
            ?>
       
	<p><br></p>
            <label>
                Office Room:
            </label> <input type="text" name="officeRm" value="<?php echo (isset($_SESSION['officeRm']) ? $_SESSION['officeRm'] : ''); ?>">
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"]);
            }
            ?>
       <p><br></p>
            <label>
                Password:
            </label> <input type="password" name="password" value="<?php echo (isset($_SESSION['password']) ? $_SESSION['password'] : ''); ?>">
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_PASSWORD"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_PASSWORD"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_PASSWORD"]);
            }
            ?>
       <p><br></p>
        <input type="submit" value="submit" name="Register!">
    
</form>
</div>
</div>
<h3><a href="login.php"> Have you already registered? Log in here. </a></h3>
</body>

</html>
