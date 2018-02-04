<?php
if( $_SERVER['REQUEST_METHOD'] == "POST") {

	$userEmail = $_POST[userEmail];
	$userPassword = $_POST[userPassword];
	$sql = "SELECT id, name, password , email FROM user WHERE email=\"$userEmail\" AND password=\"".md5($userPassword)."\" and userType = 'customer'";	
	$result = sql_query($sql, $connect);
	if(sql_num_rows($result)) {
		
		$row = sql_fetch_array($result);
		
		$_SESSION['user_id']     = $row[0];
		$_SESSION['user_name']   = $row[1];

		echo " <script type=\"text/javascript\">
			window.location.href=\"user.php?u=home&b=user_home\";
		        </script>";
		
	}
	else {
	
		$login_flag = true;
	}
}
if ($_GET[act] == logout ) {
	unset($_SESSION['user_id']);
	unset($_SESSION['user_name']);
  
	session_unset();
	session_destroy();?>
	<script type="text/javascript">
        window.location.href="index.php";
        </script>
<? }


	if( $login_flag == true) {
		
		echo "<div style='color:red'>Login Failed!!!. Try again</div>";
	}
	else
	{
		echo " ";
	}
	?>

     <script type="text/javascript">

        $(document).ready(function(){
            $("#btn_login").click(function(){
                $("#form_login").submit();
            });
        });

    </script>

<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    
</html>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col s3"></div>
        <div class="col s6">
          <div class="card grey lighten-3 z-depth-5" style="padding: 15px;">
            <div class="card-content black-text">
              <span class="card-title center">User Login</span>
            </div>
            <form class="" method="post">
            <div class='row'>
              <div class='col s12'>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='email' name='userEmail' id='user_email' />
                <label for='email'>Enter your email</label>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='password' name='userPassword' id='user_password' />
                <label for='password'>Enter your password</label>
              </div>
              
            </div>

            <div class="card-action">
               <button type='submit' name='btn_login' class='btn waves-effect lighten-1'>Login</button>
               <a href="forgot_password.php"><button class='btn waves-effect lighten-1' type="button" >Forgot Password</button></a>
            </div>
           
          </form>
            
          </div>
        </div>
        <div class="col s3"></div>
      </div>
</div>

</body>

    
</html>






