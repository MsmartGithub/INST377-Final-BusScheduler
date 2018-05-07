//This is the master file used to build our database
<html>

<body>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
    <script src="http://malsup.github.com/jquery.form.js"></script> 
<p id="demo"></p>
<?php

$url = "http://webservices.nextbus.com/service/publicXMLFeed?command=routeList&a=umd";
$xml = simplexml_load_file($url);
$newfile = $xml->asXML("nextbusroutexml.xml");


?>	
<script>
//create xml files for each bus route
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    myFunction("route", this);
    }
};	
xhttp.open("GET", "nextbusroutexml.xml", true);
xhttp.send();


//these functions are used to create the xml files serverside
function myFunction(attr, xml) {
    var xmlDoc = xml.responseXML;
	compileRoutes(attr, xmlDoc);
}
function compileRoutes(attr, xmlDoc) {
	var arr = new Array();
	var x = xmlDoc.getElementsByTagName(attr);
	for(var i = 0; i < x.length; i++) {
		arr.push(x[i].attributes[0].nodeValue);
	}
	//create xml files used to populate the database and add them to the database
	generateScheduleXML(arr);
	
	var string = arr.join("<br>");
	document.getElementById("demo").innerHTML = string;
}
function generateScheduleXML(array) {
	for (var i = 0; i < array.length; i++){
		//creates a form object and auto submits using ajax to populate the database with data from nextBus api
		var form = document.createElement("form");
		form.id = `form${i}`;
		form.method = "POST";
		form.action = "nextbusapi.php";
		var element1 = document.createElement("input");
			element1.name = "hiddenval";
			element1.type = "hidden";
			element1.value = array[i];
		form.appendChild(element1);
		document.body.appendChild(form);
		$(`#form${i}`).ajaxSubmit({url: 'nextbusapi.php', type: 'post'});
		
	}
}
</script>

</body>
</html>

