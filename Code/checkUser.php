<?php
//Check username and password against the database, 
//returns 1 and starts a user session if the user/pass exists in the database, returns 0 if it does not
include "config.php";
// define variables and set to empty values
$uname = $password = "";
//validate input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$uname = mysql_real_escape_string(test_input($_POST['username']));
$password = mysql_real_escape_string(test_input($_POST['password']));
}

if ($uname != "" && $password != ""){
	$db = "busDB";
    $sql_query = "select count(*) as cntUser from users where username='".$uname."' and password='".$password."'";
    $result = mysql_db_query($db, $sql_query);
    $row = mysql_fetch_array($result);
    $count = $row['cntUser'];
    if($count > 0){
        $_SESSION['uname'] = $uname;
        echo 1;
    }else{
        echo 0;
    }
}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>