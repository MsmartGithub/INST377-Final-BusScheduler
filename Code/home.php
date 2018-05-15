<?php
include "config.php";

// Check user login or not
if(!isset($_SESSION['uname'])){
    header('Location: index.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: index.php');
}
?>
<!doctype html>
<html>
<!--Main Page-->
<!--Displays user's schedule and allows the creation of a new schedule-->
<script src="http://demo.makitweb.com/jquery.js" type="text/javascript"></script>
    <head>
	<style>
		table {
			border-collapse: collapse;
			text-align: left;
		}
		table, th, td {
			border: 1px solid black;
		}
	</style>
	</head>
    <body>
        <h1>Welcome to our Schedule Builder!</h1>
        <form method='post' action="">
            <input type="submit" value="Logout" name="but_logout">
        </form>
		<script type="text/javascript">
			//pull up a user's schedule if there is one
			$(document).ready(function(){	
				var username = "<?php echo $_SESSION['uname']; ?>";
					$.ajax({
						url:'fetchSchedule.php',
						type:'post',
						data:{username:username},
						success:function(response){
							var val = response.replace("*", "'");
							$(".container").append(val);
						}
					});
			});
		</script>
		<div class="container"></div>
		<p>Enter Schedule in format: {BuildingCode ; Time}
			Find Schedule Information on Testudo</p>
		<textarea rows="4" cols="50" name="schedule" form="form">Enter Schedule...</textarea>
		<form id= "form" method= "post" action = "buildschedule.php">
			<input type="submit" name="submit" value="Submit">
		</form>
    </body>
</html>
