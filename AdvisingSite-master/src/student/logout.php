<?php
//page used to redirect the user to the login page when they log out
session_start();
session_destroy();

header("Location: login.php");

?>
