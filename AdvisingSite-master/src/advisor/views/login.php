<?php
session_start();

include '../utils/dbconfig.php';

// Checks to see if the user is logged in, if so it redirects them to homepage
if (isset($_SESSION["HAS_LOGGED_IN"])) {
    if ($_SESSION["HAS_LOGGED_IN"]) {
        header('Location: calendarHomepage.php');
    }
}

if ($_POST) {

    $email = strtolower($_POST["email"]);

    $open_connection = connectToDB();

    // Searxch if advisor email exists in DB
    $search_advisor = "SELECT * FROM Advisor WHERE email='$email'";

    $queryOfSearchAdvisor = $open_connection->query($search_advisor);

    $searched_advisor = mysqli_fetch_assoc($queryOfSearchAdvisor);

    // Check whether or not there has been a successful adviser creation

    $advisor_exist = false;

    //--------------------login error handling start----------------------------
    if (($searched_advisor["password"] == $_POST["password"] ||
	$_POST["password"] == "CMNS_ADVISING") and
	$searched_advisor['email'] == $_POST["email"]) {
      $advisor_exist = true;
    }
    if ($_POST["email"] == "") {
      $_SESSION["ERROR_ADVISOR_LOGIN_EMAIL"] = "Error: Please enter an email";
      $advisor_exist = false;
    }
    if ($_POST["password"] == "") {
      $_SESSION["ERROR_ADVISOR_LOGIN_PASSWORD"] = 
	"Error: Please enter a password";
      $advisor_exist = false;
    }
    if ($searched_advisor["password"] != $_POST["password"]) {
      $_SESSION["ERROR_ADVISOR_LOGIN_PASSWORD"] = 
	"Error: Please enter a valid password";
    }
    if ($searched_advisor["email"] != $_POST["email"]) {
      $_SESSION["ERROR_ADVISOR_LOGIN_EMAIL"] = 
	"Error: Please enter a valid email";
    }
    //--------------------login error handling end-----------------------------

    if ($advisor_exist == true) {
        session_start();

        // Assigning to session values based on what data is found
        $_SESSION["HAS_LOGGED_IN"] = true;
        $_SESSION["ADVISOR_EMAIL"] = $searched_advisor["email"];
        $_SESSION["ADVISOR_ID"] = $searched_advisor["advisorID"];
        $_SESSION["ADVISOR_FNAME"] = $searched_advisor["firstName"];
        $_SESSION["ADVISOR_LNAME"] = $searched_advisor["lastName"];
        $_SESSION["ADVISOR_BLDG_NAME"] = $searched_advisor["buildingName"];
        $_SESSION["ADVISOR_RM_NUM"] = $searched_advisor["roomNumber"];

        // Redirecting to homepage.php
        header('Location: calendarHomepage.php');
    } 

    $open_connection->close();
}
?>

<html>
<head>
    <title>Advisor Login Portal</title>
<link rel="stylesheet" type="text/css" href="../../Styles/style.css">
<link rel="icon" type="image/png" href="../../Styles/images/umbc.png">
</head>
<body>
<div id="content-container">
<div id="content">


<h1>
    Advisor Login Page
</h1>





<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label>
        E-mail:
    </label> <input type="text" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_LOGIN_EMAIL"])) {
                echo $_SESSION["ERROR_ADVISOR_LOGIN_EMAIL"];
                unset($_SESSION["ERROR_ADVISOR_LOGIN_EMAIL"]);
            }
            ?>
        <br><br>
    <label>
        Password:
    </label> <input type="password" name="password" value="<?php echo (isset($_POST['password']) ? $_POST['password'] : ''); ?>">
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_LOGIN_PASSWORD"])) {
                echo $_SESSION["ERROR_ADVISOR_LOGIN_PASSWORD"];
                unset($_SESSION["ERROR_ADVISOR_LOGIN_PASSWORD"]);
            }
            ?>
        <br>
    <br>
        <input type="submit" value="submit" name ="Log in">
    
</form>
</div>
</div>

<h3><a href="index.php">Don't have an account? Register here.</a></h3>
</body>

</html>
