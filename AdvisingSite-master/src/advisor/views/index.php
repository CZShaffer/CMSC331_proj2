<?php
session_start();

// Checks to see if the user is logged in, if so it redirects them to homepage
if (isset($_SESSION["HAS_LOGGED_IN"])) {
    if ($_SESSION["HAS_LOGGED_IN"]) {
        header('Location: homepage.php');
    }
}
?>

<html>
<head>
    <title>
        Adviser Registration
    </title>
</head>

<body>

<h1>Advisor Registration Form</h1>

<a href="login.php">
    <button type="button">Login</button>
</a>

<hr>

<!-- Use the htmlspecial chars to protect from XSS and CSSR -->
<form action="../utils/forms/registerAdvisor.php" method="post">
    <ul>
        <li>
            <label>
                First Name: <input type="text" name="fName">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"]);
            }
            ?>
        </li>

        <li>
            <label>
                Middle Name: <input type="text" name="mName">
            </label>
        </li>

        <li>
            <label>
                Last Name: <input type="text" name="lName">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"]);
            }
            ?>
        </li>

        <li>
            <label>
                E-mail: <input type="email" name="email">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"]);
            }
            ?>
        </li>

        <li>
            <label>
                Office Building Name: <input type="text" name="bldgName">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"]);
            }
            ?>
        </li>

        <li>
            <label>
                Office Room: <input type="text" name="officeRm">
            </label>
            <?php
            if (isset($_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"])) {
                echo $_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"];
                unset($_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"]);
            }
            ?>
        </li>
        <input type="submit" name="Register!">
    </ul>
</form>
</body>
</html>
