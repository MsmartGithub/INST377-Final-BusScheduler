<?php
	//need to remove the time limit because this takes about 5 mins to run
	set_time_limit(0);
	// Create connection
	$conn = mysql_connect("localhost", "root", "");
		if (!$conn)
			{     
				die('Unable to connect' . mysql_error()); 
			}	
	$db = "busDB";
	//get building data from umd.io api
	$json = file_get_contents('https://api.umd.io/v0/map/buildings');
	$obj = json_decode($json);
	//get all this building data into a usable array
	$bldgarr = array();
	$i = 0;
	foreach($obj as $building) {
		if($building->code != 	""){
		$bldgarr[$i] = array("code"=>$building->code, "lat"=> $building->lat, "lng"=> $building->lng);
		$i = $i + 1;
		}
	}
	$sql = "SELECT id, lat, lon FROM Stops";
	//fetch stop data from the database;
	$result = mysql_db_query($db, $sql);
	//*Figure out where the nearest stop is for each building and insert data into db 
	try {
	foreach ($bldgarr as $bldxy) {
		//return result resource pointer to the top row
		mysql_data_seek($result, 0);
		$curr = 0;
		$diff = array(100, 100);
		while($stopxy = mysql_fetch_assoc($result)) {
			if (abs($stopxy[lat] - $bldxy[lat]) <= $diff[0]) {
				$slon = abs($stopxy[lon]);
				$blon = abs($bldxy[lng]);
				if (abs($slon - $blon) <= $diff[1]) {
					$diff[0] = abs($stopxy[lat] - $bldxy[lat]);
					$diff[1] = abs($slon - $blon);
					$curr = $stopxy[id];
					echo "Found new curr <br>";
				}	
			}
		}
		print_r($curr);
		$sql = "INSERT INTO Buildings(id, stop)
				VALUES('{$bldxy[code]}', '{$curr}')";
		if (mysql_db_query($db, $sql) != FALSE) {
			echo "New record created successfully";
		} else {
			echo mysql_error();
		}
	}
	
	} catch (Exception $e) {
		echo 'Caught exception: ', $e->getMessage(), "\n"; 
	}

	
	mysql_close($conn);
	//*/
?>
