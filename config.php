<?php
session_start();
$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = "root"; /* Password */
$dbname = "test"; /* Database name */
$port = 3305;

$con = mysqli_connect($host, $user, $password,$dbname, 3305);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}