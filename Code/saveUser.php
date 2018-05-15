<?php
	//Adds this registered user into the database
	$conn = mysql_connect('localhost', 'root', '');
	$db = "busDB";
	$u = $_POST['username'];
	$p = $_POST['password'];
	echo $u;
	$sql = "insert into users(username, password) VALUES ('{$u}', '{$p}')";
	$result = mysql_db_query($db, $sql);
	print_r($result);
	mysql_close($conn);
?>
<script>
//go back to the landing page
window.location = "index.php";
</script>