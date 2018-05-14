<?php
$conn = new mysqli('localhost', 'root', 'root', 'test',3305);
if ($conn->connect_error) die($conn->connect_error);

//store post data to array
	function checkData($data, $len, $fldname) {
		//check length of string
		if (strlen(trim($data)) > $len) {
			//return the data and an error
			echo 'value="' . $values[$data] . '"';
		} else {
			$insData[$fldname] = trim($data);
		}
		
	}
	foreach ($_POST as $key => $value) {
		$data[$key] = $value;
	}

	$q = "insert into `users` (`";
	$qd = ") values ('";
	foreach ($data as $fldName => $postdata) {
		$q .= $fldName . "`, `";
		$qd .= $postdata . "', '";
	}
	$qstr = substr($q,0,-3) . substr($qd,0,-3) . ");";
	$result = $conn->query($qstr);
	$q = "select * from users";

?>
