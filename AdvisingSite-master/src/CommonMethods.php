<?php 

class Common
{
  var $conn;
  var $debug;
  
  function Common($debug)
  {
    $this->debug = $debug; 
    $rs = $this->connect("phi3"); // db name really here
    return $rs;
  }

  // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
  
  function connect($db)// connect to MySQL
  {
    $conn = @mysql_connect("studentdb-maria.gl.umbc.edu", "phi3", "phi3") or die("Could not connect to MySQL");
    $rs = @mysql_select_db($db, $conn) or die("Could not connect select $db database");
    $this->conn = $conn; 
    //echo "Connected successfully";
  }

  // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
  
  function executeQuery($sql, $filename) // execute query
  {
    //if($this->debug == true) { echo("$sql <br>\n"); }
    $rs = mysql_query($sql, $this->conn) or die("Could not execute query '$sql' in $filename"); 
    return $rs;
  }



} // ends class, NEEDED!!

?>
