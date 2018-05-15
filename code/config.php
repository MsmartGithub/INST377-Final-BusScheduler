<?php
//Used to connecting to the database and carrying session variables
session_start();
$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
//mysql connection to server
$conn = mysql_connect($host, $user, $pass);
?>