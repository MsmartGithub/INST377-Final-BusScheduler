<script src="http://demo.makitweb.com/jquery.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
	//Tries to log the user in, must be a valid username/password
    $("#but_submit").click(function(){
        var username = $("#txt_uname").val().trim();
        var password = $("#txt_pwd").val().trim();

        if( username != "" && password != "" ){
            $.ajax({
                url:'checkUser.php',
                type:'post',
                data:{username:username,password:password},
                success:function(response){
                    var msg = "";
                    if(response == 1){
                        window.location = "home.php";
                    }else{
                        msg = "Invalid username and password!";
                    }
                    $("#message").html(msg);
                }
            });
        }
    });
	//takes the user to the registration page
	$("#but_reg").click(function(){
		window.location = "createUser.php";
	});
});
</script>
<h1>UMD Bus Schedule Builder</h1>
<div class="container">

    <div id="div_login">
        <h1>Login</h1>
        <div id="message"></div>
        <div>
            <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" />
        </div>
        <div>
            <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Password"/>
        </div>
        <div>
            <input type="button" value="Submit" name="but_submit" id="but_submit" />
        </div>
    </div>
</div>
<div class="container">
	<div id="div_signup">
		<h1>Register</h1>
		<div>
			<input type="button" value="Register" name="but_reg" id="but_reg"/>
		</div>
	</div>
</div>

