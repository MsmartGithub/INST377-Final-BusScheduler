<?php
//display message to user	
echo "Updating your schedule....";
//connect to mysql server
include "config.php";
//receive text submission of schedule
$string = $_POST["schedule"];
//split the input into an array so that we can parse through and begin building the schedule
//This splits the string into an array by newline, each new string should be in
//the format{ buildingcode ; time }
$array = split("\n", $string);
$result = array();
//go through the submitted schedule and fetch the bus stop and route that each schedule item needs
	$db = "busDB";
//For time's sake, this is not the most accurate route that can be taken, only the first that shows up
$num = count($array);
for($i = 0; $i < $num; $i++) {
	//look ahead to the next item to get destination
	$item = current($array);
	$next = next($array);
	//print_r($item);
	//print_r($next);
	if($next != NULL) {
		$n = split(";", $next);
		$n[1] = split(":", $n[1]);
		//print_r($i);
		$t = split(';', $item);
		$sql = "SELECT * FROM Buildings WHERE id = '" . trim($t[0]) . "'";
		$depart = mysql_fetch_assoc(mysql_db_query($db, $sql));
		//print_r($depart);
		$sql = "SELECT * FROM Buildings WHERE id = '{$n[0]}'";
		$dest =  mysql_fetch_assoc(mysql_db_query($db, $sql));
		//print_r($dest);
		$sql = "SELECT * FROM Stops WHERE id = '{$depart[stop]}'";
		$stop = mysql_fetch_assoc(mysql_db_query($db, $sql));
		//print_r($stop);
		$sql = "SELECT id FROM Routes WHERE ('{$depart[stop]}' IN(stop0, stop1, stop2, stop3, stop4, stop5, stop6, stop7, stop8, stop9, stop10))
								AND ('{$dest[stop]}' IN(stop0, stop1, stop2, stop3, stop4, stop5, stop6, stop7, stop8, stop9, stop10))";
		$route = mysql_fetch_assoc(mysql_db_query($db, $sql));
		//recommand a random bus if there is no viable bus (temporary solution)
		if($route == NULL) {
			$sql = "SELECT id FROM Routes WHERE ('{$depart[stop]}' IN(stop0, stop1, stop2, stop3, stop4, stop5, stop6, stop7, stop8, stop9, stop10))";
			$route = mysql_fetch_assoc(mysql_db_query($db, $sql));
		}
		//make time reccomendation more accurate
		$hours = $n[1][0];
		$mins = $n[1][1] - 15;
		if ($mins < 0) {
			$mins = 60 + $mins;
			$hours = $hours - 1;
			while($hours > 12) {
				$hours = $hours - 12;
			}
			if ($hours < 1) {
				$hours = 12 - $hours;
			}
		}
		if ($mins < 10) {
			$mins = "0{$mins}";
		}	
	$result[$i] = array($route[id], "{$hours}:{$mins}", $stop[title]); 
		//echo "<br>";
	}
}
//put together a string of html and store it in the database, this is the schedule table that we have just created
$html = "<table style=*width:50%*><tr><th>Bus</th><th>Time</th><th>Location</th></tr>";
foreach($result as $line) {
	$html = $html . "<tr><td>{$line[0]}</td><td>{$line[1]}</td><td>{$line[2]}</td></tr>";
}
$html = $html . "</table>";
$name = $_SESSION['uname'];
$sql = "UPDATE users SET schedule = '{$html}' WHERE username = '{$name}'";
mysql_db_query($db, $sql);
mysql_close($conn);
?>
<script>
window.location = "home.php";
</script>