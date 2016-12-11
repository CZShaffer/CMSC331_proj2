<?php
session_start();

if ($_POST) {
    include '../dbconfig.php';

    // Parse values from form
    $fName = $_POST["fName"];
    $_SESSION["fName"] = $_POST["fName"];
    $mName = $_POST["mName"];
    $_SESSION["mName"] = $_POST["mName"];
    $lName = $_POST["lName"];
    $_SESSION["lName"] = $_POST["lName"];
    $email = $_POST["email"];
    $_SESSION["email"] = $_POST["email"];
    $bldgName = $_POST["bldgName"];
    $_SESSION["bldgName"] = $_POST["bldgName"];
    $officeRm = $_POST["officeRm"];
    $_SESSION["officeRm"] = $_POST["officeRm"];
    $password = $_POST["password"];
    $_SESSION["password"] = $_POST["password"];


    $regexToCheckIfValidEmail = "/^[A-Za-z0-9_.]+@[A-Za-z0-9]+\.[A-za-z0-9]{3}$/";

    $numOfErrors = 0;

    if ($fName == "") {
        $_SESSION["ERROR_ADVISOR_REGISTRATION_FNAME"] = "Error: You must provide a first name.";
        $numOfErrors += 1;
    }

    if ($lName == "") {
        $_SESSION["ERROR_ADVISOR_REGISTRATION_LNAME"] = "Error: You must provide a last name.";
        $numOfErrors += 1;
    }

    if ($email == "" or !preg_match($regexToCheckIfValidEmail, $email)) {
        $_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"] = "Error: Invalid Email!";
        $numOfErrors += 1;
    }

    if ($bldgName == "") {
        $_SESSION["ERROR_ADVISOR_REGISTRATION_BLDGNAME"] = "Error: You need to provide a building name.";
        $numOfErrors += 1;
    }

    if ($officeRm == "") {
        $_SESSION["ERROR_ADVISOR_REGISTRATION_OFFICERM"] = "Error: You need to provide office room number.";
	$numOfErrors += 1;
    }

    if ($password == "") {
        $_SESSION["ERROR_ADVISOR_REGISTRATION_PASSWORD"] = "Error: You need to provide a password";
	$numOfErrors += 1;
    }

    if ($numOfErrors == 0) {
        // Connect to DB
        $open_connection = connectToDB();
        $checkForEmails = "SELECT 1 from `Advisor` WHERE `email` = '$email' LIMIT 1";
        $results = $open_connection->query($checkForEmails);

        if (mysqli_num_rows($results) == 0) {

            $insert_adviser = "
              INSERT INTO Advisor (
                email, firstName, middleName, lastName, buildingName, roomNumber, password
              )
              VALUES (
                '$email', '$fName', '$mName', '$lName', '$bldgName', '$officeRm' , '$password'
              )
            ";
            $open_connection->query($insert_adviser);
            header('Location: ../../views/login.php');
        } else {
            $_SESSION["ERROR_ADVISOR_REGISTRATION_EMAIL"] = "Error: This email already exists!";
            header('Location: ../../views/index.php');
        }
    } else {
        header('Location: ../../views/index.php');
    }
}