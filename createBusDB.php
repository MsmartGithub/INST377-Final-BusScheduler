<?php

$conn = mysql_connect("localhost", "root", NULL);
if (!$conn)
    {     
        die('Unable to connect' . mysql_error()); 
    }

$sql = "CREATE DATABASE busDB";
if (mysql_query($sql) != FALSE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . mysql_error();
}
echo '<br>';
$db = 'busDB';
$sql = "CREATE TABLE Users (
username VARCHAR(45) PRIMARY KEY,
password VARCHAR(45)
)";

if (mysql_db_query($db, $sql) != FALSE) {
    echo "Table Users created successfully";
} else {
    echo "Error creating table: " . mysql_error();
}
echo '<br>';
$sql = "CREATE TABLE Schedules (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
time0 INT(6),
time1 INT(6),
time2 INT(6),
time3 INT(6),
time4 INT(6),
time5 INT(6),
time6 INT(6),
time7 INT(6),
time8 INT(6),
time9 INT(6),
time10 INT(6)
)";

if (mysql_db_query($db, $sql) != FALSE) {
    echo "Table Schedules created successfully";
} else {
    echo "Error creating table: " . mysql_error();
}
echo '<br>';
$sql = "CREATE TABLE Times (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
stopid INT(6),
routeid INT(6),
stoptime INT(6),
stopinterval INT(6)
)";

if (mysql_db_query($db, $sql) != FALSE) {
    echo "Table Times created successfully";
} else {
    echo "Error creating table: " . mysql_error();
}
echo '<br>';
mysql_close($conn);
?>