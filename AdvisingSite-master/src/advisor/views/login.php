<?php
session_start();

include '../utils/dbconfig.php';

// Checks to see if the user is logged in, if so it redirects them to homepage
if (isset($_SESSION["HAS_LOGGED_IN"])) {
    if ($_SESSION["HAS_LOGGED_IN"]) {
        header('Location: homepage.php');
    }
}

if ($_POST) {
  if ($_POST["email"] == "") {
    $_SESSION["ERROR_ADVISOR_LOGIN_EMAIL"] = "Error: Please enter an email";
  }
  if ($_POST["password"] == "") {
    $_SESSION["ERROR_ADVISOR_LOGIN_PASSWORD"] = "Error: Please enter a password";
  }


    $email = strtolower($_POST["email"]);

    $open_connection = connectToDB();

    // Searxch if advisor email exists in DB
    $search_advisor = "SELECT * FROM Advisor WHERE email='$email'";

    $queryOfSearchAdvisor = $open_connection->query($search_advisor);

    $num_rows = mysqli_num_rows($queryOfSearchAdvisor);
    // Check whether or not there has been a successful adviser creation


    if ($num_rows == 1) {
        session_start();
        // Translate the SQL Query into a dictioanry
        $advisorDict = mysqli_fetch_assoc($queryOfSearchAdvisor);

        // Assigning to session values based on what data is found
        $_SESSION["HAS_LOGGED_IN"] = true;
        $_SESSION["ADVISOR_EMAIL"] = $advisorDict["email"];
        $_SESSION["ADVISOR_ID"] = $advisorDict["advisorID"];
        $_SESSION["ADVISOR_FNAME"] = $advisorDict["firstName"];
        $_SESSION["ADVISOR_LNAME"] = $advisorDict["lastName"];
        $_SESSION["ADVISOR_BLDG_NAME"] = $advisorDict["buildingName"];
        $_SESSION["ADVISOR_RM_NUM"] = $advisorDict["roomNumber"];

        // Redirecting to homepage.php
        header('Location: homepage.php');
    } else {
        echo "Login FAILED";
    }

    $open_connection->close();
}
?>

<html>
<head>
    <title>Advisor Login Portal</title>
<link rel="stylesheet" type="text/css" href="../../Styles/style.css">
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
        <input type="submit">
    
</form>
</div>
</div>

<h3><a href="index.php">Don't have an account? Register here.</a></h3>
</body>

</html>