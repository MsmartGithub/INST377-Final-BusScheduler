<?php

$url = "http://webservices.nextbus.com/service/publicXMLFeed?command=schedule&a=umd&r={$_POST['hiddenval']}";
$xml = simplexml_load_file($url);
$newfile = $xml->asXML("{$_POST['hiddenval']}schedule.xml");


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
stop0 INT(6),
time0 TIME,
stop1 INT(6),
time1 TIME,
stop2 INT(6),
time2 TIME,
stop3 INT(6),
time3 TIME,
stop4 INT(6),
time4 TIME,
stop5 INT(6),
time5 TIME,
stop6 INT(6),
time6 TIME,
stop7 INT(6),
time7 TIME,
stop8 INT(6),
time8 TIME,
stop9 INT(6),
time9 TIME,
stop10 INT(6),
time10 TIME
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
stoptime TIME,
stopinterval TIME
)";

if (mysql_db_query($db, $sql) != FALSE) {
    echo "Table Times created successfully";
} else {
    echo "Error creating table: " . mysql_error();
}
echo '<br>';
$sql = "CREATE TABLE Routes (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(45),
stop0 INT(6),
time0 TIME,
stop1 INT(6),
time1 TIME,
stop2 INT(6),
time2 TIME,
stop3 INT(6),
time3 TIME,
stop4 INT(6),
time4 TIME,
stop5 INT(6),
time5 TIME,
stop6 INT(6),
time6 TIME,
stop7 INT(6),
time7 TIME,
stop8 INT(6),
time8 TIME,
stop9 INT(6),
time9 TIME,
stop10 INT(6),
time10 TIME
)";

if (mysql_db_query($db, $sql) != FALSE) {
    echo "Table Times created successfully";
} else {
    echo "Error creating table: " . mysql_error();
}
echo '<br>';
$sql =  "CREATE TABLE Stops (
id INT(6) UNSIGNED PRIMARY KEY,
tag VARCHAR(45),
title VARCHAR(45),
lat DECIMAL(9,7),
lon DECIMAL(9,7))";
if (mysql_db_query($db, $sql) != FALSE) {
    echo "Table Stops created successfully";
} else {
    echo "Error creating table: " . mysql_error();
}
echo '<br>';

$sql = "CREATE TABLE Buildings (
id VARCHAR(45) PRIMARY KEY,
stop INT(6))";

if (mysql_db_query($db, $sql) != FALSE) {
    echo "Table Buildings created successfully";
} else {
    echo "Error creating table: " . mysql_error();
}
mysql_close($conn);


?>	