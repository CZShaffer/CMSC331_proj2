<?php



function connectToDB()
{

    setVars();

    // Create connection
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['$username'], $GLOBALS['password']);

    // So the database name is the same as the username. wierd
    if (!mysqli_select_db($conn, $GLOBALS['dbName'])) {
        die("Uh oh, couldn't select database ".$GLOBALS['dbName']);
    }

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Connected successfully
        return $conn;
    }
}

function setVars(){

    if(!defined($GLOBALS['DB_VARS'])) {
        define($GLOBALS['DB_VARS'],true);
        $GLOBALS['servername'] = "studentdb-maria.gl.umbc.edu";
        $GLOBALS['username'] = "pb10459";
        $GLOBALS['password'] = "pb10459";
        $GLOBALS['dbName'] = "pb10459";
    }

}

function setUpDB(){



}
