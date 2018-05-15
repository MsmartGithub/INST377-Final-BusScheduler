<?php
//downloads xml file data from nextBus API
//Commercial version would be accurate to multiple busses and times across all days of the week
//for this concept, we will focus on tracking only one bus on each route on the friday schedule
$url = "http://webservices.nextbus.com/service/publicXMLFeed?command=routeConfig&a=umd&r={$_POST['hiddenval']}";
$xml = simplexml_load_file($url);
/*
Now that we have an xml file on the server, we can parse it and add the useful data to the database.
Xml files are a tree structure, so to get all the relevant data we interate through it like we would 
any tree data structure. Since $xml is a SimpleXML object, we can use library functions to parse the data. 
The goal here is to get all the information for each route: Stop Title, StopID, lat, and long.
*/
	//connect to mysql server

	$conn = mysql_connect("localhost", "root", "");
		if (!$conn)
			{     
				die('Unable to connect' . mysql_error()); 
			}	

//	$xml = simplexml_load_file("132schedule.xml");
	// Create connection

	class Route {
		public $routeTag;
		public $routeName;
		public $stops = array();
			// Assigning the values
            public function __construct($tag, $name, $stops) {
              $this->routeTag = $tag;
              $this->routeName = $name;
              $this->stops = $stops;
            }
	}
	function times($data) {
		$url1 = "http://webservices.nextbus.com/service/publicXMLFeed?command=schedule&a=umd&r={$_POST['hiddenval']}";
		$xml1 = simplexml_load_file($url1);
//		$xml1 = simplexml_load_file("test.xml");
		foreach ($xml1->route[0]->tr[0]->stop as $stop) {
			$atr = $stop->attributes();
			$tag = trimTag($atr['tag']);
			if($tag == $data){
							echo "{$tag}<br>";
				return (string) $stop;
			}
		}
		return NULL;
	}
	function trimTag($tag){
		if(strpos($tag, "_") != FALSE){
			$tag = substr($tag, 0, strpos($tag, "_"));
		}
		return $tag;
	}
	function stopArr($xml) {
		$array = array();
		foreach ($xml->route->stop as $stop) {
			$ar = $stop->attributes();
			$a = $ar['stopId'];
			$b = trimTag($ar['tag']);
			$c = $ar['title'];
			$d = $ar['lat'];
			$e = $ar['lon'];
			$time = times($b);
			$x = array();
			array_push($x, $time, $a, $b, $c, $d, $e);
			array_push($array, $x);
		}
		
		return $array;
	}
	$array = $xml->route[0]->attributes();
	$attr1 = (string) $array[0];
	$attr2 = (string) $array[1];
	$route = new route($attr1,
						$attr2,
						stopArr($xml));

	
	//populate tables
	/* TESTING TOOLS
		if ($conn->query("TRUNCATE TABLE Routes") === TRUE) {
				echo "Table Cleared<br>";
			} else {
				echo "Error: " . $stopsql . "<br>" . $conn->error;
		}	
		if ($conn->query("TRUNCATE TABLE Routes") === TRUE) {
				echo "Table Cleared<br>";
			} else {
				echo "Error: " . $stopsql . "<br>" . $conn->error;
		}
		*/
	$i = 0;
	//calculateing the times
	$time1 = $route->stops[0][0];
	$time2 = NULL;
	$it = 0;
	while($it < 11) {
		if($route->stops[$it][0] != NULL) {
			$time2 = $route->stops[$it][0];
		}
		$it = $it + 1;
	}
	$routeName = $route->routeName;
	$numStops = count($route->stops);
	sscanf($time1,"%d:%d:%d", $hrs1, $min1, $sec1);
	sscanf($time2,"%d:%d:%d", $hrs2, $min2, $sec2);
	$hrInt = round(($hrs2 - $hrs1)/$numStops, 0);
	$minInt = round((($min2 - $min1)/$numStops)+3, 0);
	$secInt = round(($sec2 - $sec1)/$numStops, 0);
	$h = $hrs1;
	$m = $min1;
	$s = $sec1;
	//edit tables
	foreach ($route->stops as $stop) {
		
		$db = "busDB";
		$stopsql = "INSERT INTO Stops(id, tag, title, lat, lon)
				VALUES({$stop[1]}, '{$stop[2]}', '{$stop[3]}', {$stop[4]}, {$stop[5]})";
		if (mysql_db_query($db, $stopsql) != FALSE) {
				echo "Inserted into DB";
			} else {
				echo "Insertion Error: " . mysql_error();
		}
		
		//time for this specific stop
		$h = $h + $hrInt;
		$m = $m + $minInt;
		$s = $s + $secInt;
		if($s > 59) {
			$m = $m + 1;
			$s = $s - 60;
		}
		if($m > 59) {
			$h = $h + 1;
			$m = $m - 60;
		}

		if ($i === 0) {
			$routesql = "INSERT INTO Routes(id, stop{$i}, time{$i})
					VALUES({$route->routeTag}, {$stop[1]}, '{$h}:{$m}:{$s}')";
		if (mysql_db_query($db, $routesql) != FALSE) {
				echo "Inserted into DB";
			} else {
				echo "Insertion Error: " . mysql_error();
		}
		} else {
			$routesql = "UPDATE Routes
				SET stop{$i} = {$stop[1]}, time{$i} = '{$h}:{$m}:{$s}' WHERE id = {$route->routeTag}";
			if (mysql_db_query($db, $routesql) != FALSE) {
				echo "Updated Routes";
			} else {
				echo "Insertion Error: " . mysql_error();
			}
		}
		$i = $i + 1;
			if ($i > 10) {
				$i = 0;
			}
	}
	mysql_close($conn);
//	mysql_close($conn);
?>	