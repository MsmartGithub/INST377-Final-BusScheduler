
<html>
<head>
	<title>Sign Up</title>

</head>
<body>
	<div class="content">
	<div class="container">
		<div class="row">
			<h1>Register</h1><br>
			<form action="saveUser.php" method="post" class="form-horizontal">
				<input id="name" type="hidden" name="name" value="">
				<div class="form-group">
					<label for="name" class="control-label col-sm-3">Name</label>
					<div class="col-sm-3">
						<input type="text" onchange="validText(this.value, this.name)" class="form-control" id="name" name="name" placeholder="Name" value="">
						<span class="small text-warning" id="f_nameerr"></span>
					</div>
				</div>

				<div class="form-group">
					<label for="username" class="control-label col-sm-3">Username</label>
					<div class="col-sm-4">
						<input type="text" onchange="validText(this.value, this.name)" class="form-control" id="username" name="username" placeholder="Username" value="">
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="control-label col-sm-3">Password</label>
					<div class="col-sm-3">
						<input type="password" name="password" placeholder="Password" class="form-control" id="password" value="">
					</div>
					<!-- <div class="col-sm-2">
						<input type="text" name="zip" class="form-control" id="zip" placeholder="Zip Code" value="">
					</div> -->
				</div>

				<div class="form-group">
					<input type="submit" value="Submit" class="btn btn-info pull-right">
				</div>
			</form>
			
	
</body>
</html>