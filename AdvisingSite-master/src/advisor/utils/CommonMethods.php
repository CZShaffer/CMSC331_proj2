<?php
class Common
{
    var $conn;
    var $debug;

    function Common($debug)
    {
        $this->debug = $debug;
        $rs = $this->connect("pb10459"); // db name really here
        return $rs;
    }

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

    function connect($db)// connect to MySQL
    {
        $conn = @mysqli_connect("studentdb.gl.umbc.edu", "pb10459", "pb10459") or die("Could not connect to MySQL");
        $rs = @mysqli_select_db($db, $conn) or die("Could not connect select $db database");
        $this->conn = $conn;
    }

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

    function executeQuery($sql, $filename) // execute query
    {
        if ($this->debug == true) {
            echo("$sql <br>\n");
        }
        $rs = mysqli_query($sql, $this->conn) or die("Could not execute query '$sql' in $filename");
        return $rs;
    }

} // ends class, NEEDED!!

?>
