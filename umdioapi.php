<?php
	// Create connection
	$conn = new mysqli("localhost", "root", "root", "busDB");
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$json = file_get_contents('https://api.umd.io/v0/map/buildings');
	$obj = json_decode($json);
	//get all the buildings with building codes
	$bldgarr = array();
	$i = 0;
	foreach($obj as $building) {
		if($building->code != 	""){
		$bldgarr[$i] = array("code"=>$building->code, "lat"=> $building->lat, "lng"=> $building->lng);
		$i = $i + 1;
		}
	}
	//*Figure out where the nearest stop is for each building and insert data into db 
	$sql = "SELECT id, lat, lon FROM Stops";
	$result = $conn->query($sql);
	
	foreach ($bldgarr as $bldxy) {
		$curr = 0;
		echo "Checking {$bldxy[code]}...<br>";
		print_r($bldxy);
		echo "<br>";
		$diff = array(100, 100);
		foreach ($result as $stopxy) {
			print_r($stopxy);
			echo "<br>";
			print_r($bldxy);
			echo"<br>";
			if (abs($stopxy[lat] - $bldxy[lat]) <= $diff[0]) {
				$slon = abs($stopxy[lon]);
				$blon = abs($bldxy[lng]);
				if (abs($slon - $blon) <= $diff[1]) {
					$diff[0] = abs($stopxy[lat] - $bldxy[lat]);
					$diff[1] = abs($slon - $blon);
					$curr = $stopxy[id];
					print_r($curr);
					echo "<br>";
				}	
			}
		}
		echo "diddlydoosquigglysqwooo";
		$sql = "INSERT INTO Buildings(id, stop)
				VALUES('{$bldxy[code]}', '{$curr}')";
		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		echo "<br>next one<br>";
	}
	
	$conn->close;
	//*/
?>