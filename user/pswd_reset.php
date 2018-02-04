<style type="text/css">
  
.successmeg {
  font-size: 20px;
  margin-left: 300px;
  font-weight: bold;
}

</style>
<?php
session_start();
include "../libcommon/conf.php";
include "../libcommon/classes/db_mysql.php";
include "../libcommon/functions.php";
include "../libcommon/db_inc.php";

include "header.php";

$email = $_GET['email'];
$rand_number = $_GET['key'];
if(isset($_POST['submit']))
{ 
	$reset_password = $_POST['reset_password'];
	$reset_passwordcnf = $_POST['confirm_password'];
	if($reset_password == "" || !preg_match("/^[A-Za-z0-9\s.\-\@\_\#\$\/]{2,20}$/", $reset_password))
    {  
        $input_errors[] = "Password is incorrect or empty"."<br/>";
         
    }
    
    if($reset_passwordcnf != $reset_password)
    {  
        $input_errors[] =  "Confirm Password Is Not Correct";
        
    }
	if(!$input_errors)
	{
		$sql = "SELECT email , random_number FROM forgot_password WHERE email=\"$email\" and random_number = \"$rand_number\"";
		$result = sql_query($sql, $connect);
				
		if(sql_num_rows($result) )
		{
		
			$sql = "SELECT id from user where email=\"$email\"";
			$result1 = sql_query($sql, $connect);
			if(sql_num_rows($result1) )
			{
				$row = sql_fetch_array($result1);		
				$user_id = $row[0];
				$sql = "UPDATE user SET  password =\"".md5($reset_password)."\"  where id =\"$user_id\"";
        $result2 = sql_query($sql, $connect);
                
    			echo "<div class=\"successmeg\">
                     Your have sucessfully changed the password <a href=\"index.php\">Click here to login</a> .  
                   </div>";
                
                $sql = "delete from forgot_password where email=\"$email\""; 
                $result3 = sql_query($sql, $connect);

            }
            else
            {
            	echo "Error";
            }


		}
		else
		{	
			echo "<div class=\"successmeg\">
                     Your Link for reset Password has expired or Invallid. Please  <a href=\"forgot_password.php\">Click here to reset password again</a> .  
                    </div>";
		}
	}
	else
	{
				
		echo "<div class=\"alert alert-error\" style=\"width: 70%; margin:10px auto; text-align:center;\">";
		echo "<h5 style=\"text-align:left;margin:10px 0;color:red;\">Correct the errors</h5>";
    foreach( $input_errors as $error)
    {
        echo "<div style=\"font-size:14px;text-align:left;margin:6px 0;color:red;\">".++$count.") ".$error."</div>";
    }
		echo "</div>";
		
	}
}

?>

<div class="banner_tab">
<div class="login_space" style='margin:70px;' >
<div class="error_style">
<?php
		if( $login_flag == true) 
		{		
			echo "<span id=\"err_log\" style='padding:3px;' >".$error_message."</span>";
		}				
?>
</div>
<div class="col-sm-2">

	<!--<div class="alert alert-info" style="width:43%; margin:0 auto; text-align:center; font-size:16px; text-decoration:underline;">
		<a href="student_account_create.php"><strong>Click here to apply B.Tech admission online.</strong></a>
	</div>-->
</div><br />
<form action="" id="admission" method="POST">
<script>

	
</script>
<table class="validation"  border="0" cellpadding="5" cellspacing="0" align="center" style="width:40%; height: 211px;">
<tr valign="top">
        <th id="head" colspan='2' style="text-align:center; font-size: larger; height:40%; font-family:Droid Sans,Arial,Verdana;">
            
            <h4>
                        RESET YOUR PASSWORD
                    </h4>
        </th>

</tr>
    <tr>
            <!--<td colspan="2" align="center" style="height:40px;">Login</td>-->
        	</tr>

  

<tr>
  <td style="width:30%; text-align:right;"> <b style="margin-right: -13px;">New Password: </b> </td>
  <td style="text-align:left; margin:0 0 0 10px;">
        <input type="password" class="required mandatory regx_password" name="reset_password" id="reset_password" style="width:215px; margin-left: 27px;" placeholder="New Password"/>
  </td>
</tr>
<tr>
  <td style="width:32%; text-align:right;"> <b style="margin-right: -13px;">Confirm Password: </b> </td>
  <td style="text-align:left; margin:0 0 0 10px;">
        <input type="password" class="required mandatory regx_password" name="confirm_password" id="confirm_password" style="width:215px; margin-left: 27px;" placeholder="Confirm Password"/><br/>
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span id='message'></span>

  </td>
</tr>
<script>

  $('#confirm_password').on('keyup', function () {
    if ($(this).val() == $('#reset_password').val()) {
       $('#message').html('Password OK').css('color', 'green');
    } else $('#message').html('Sorry Password not matching').css('color', 'red');
});
  </script>
<!-- <tr>
<td colspan='2' style="text-align:left; margin:0 0 0 10px; padding-left:135px;">
        <input type="radio" name="admissionType" class="keyinput" value='0' checked style="vertical-align:top;">  Management  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
        <input type="radio" name="admissionType" class="keyinput" value='1' style="vertical-align:top;">  Govt.
  </td>
</tr> -->
<tr>
   <td colspan="2" align="center" style="height:40px;">
	   <input type="hidden" name="admissionType" value='0' >
	   <input name="submit" style="margin-bottom: 0px;" type="submit" class="btn btn-info" id="ok" value="RESET PASSWORD">
	   
   </td>

</tr>  
</table>
</form>

</div></div>
