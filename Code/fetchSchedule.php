<?php
//Gets schedule data out of the database
include "config.php";
if ($_POST['username'] != ""){
	$db = "busDB";
    $sql_query = "SELECT schedule FROM users where username='".$_POST['username']."'";
    $result = mysql_db_query($db, $sql_query);
    $row = mysql_fetch_array($result);
	echo $row['schedule'];
}
?>				