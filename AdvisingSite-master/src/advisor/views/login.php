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
        echo "ERROR: 404, Login FAILED";
    }

    $open_connection->close();
}
?>

<html>
<head>
    <title>Advisor Login Portal</title>
</head>
<body>

<h1>
    Advisor Login Page
</h1>

<a href="index.php">
    <button type="button">Register</button>
</a>

<hr>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label>
        <!-- Only email needs an error, the rest is handled by HTML 5 -->
        E-mail: <input type="text" name="email" required>
        <br>
    </label>
    <label>
        <input type="submit">
    </label>
</form>


</body>

</html>