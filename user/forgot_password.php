<style type="text/css">
	
.successmeg {
	font-size: 24px;
	margin-left: 325px;
	font-weight: bold;
}

</style>


<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include "../libcommon/conf.php";
include "../libcommon/classes/db_mysql.php";
include "../libcommon/functions.php";
include "../libcommon/db_inc.php";

include "header.php";


include "../libcommon/phpmailer/class.phpmailer.php";

			if(isset($_POST['upload'])) 
			{

				$captcha = sql_real_escape_string($_POST['captcha']);
				$email =  sql_real_escape_string($_POST['email']);
				$captchaSecurity = $_SESSION['capcha'];
				if ($captchaSecurity != $captcha) 
				{
					$input_errors[] = "captcha not valid";
				}
				if(!preg_match("/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/", $email))
				{
	     			$input_errors[] = "Email Format is incorrect or empty"."<br/>";
				}
				
				if(!$input_errors)
				{
					$sql = "SELECT id FROM user WHERE email=\"$email\"";
							//echo $sql;	
					$result = sql_query($sql, $connect);
					//$row = sql_fetch_row($result);
					
					if(sql_num_rows($result) )
					{
						$row = sql_fetch_array($result);				
						//$studentID  = $row[0];
						$encrypt = get_rand_id1(12);
						$sql = "insert into forgot_password(email,random_number) values('".$email."','".$encrypt."')";
						$result = sql_query($sql, $connect);
					
						$MailSubject = "Password Recovery Mail";
                		$MailBody = "Dear Candidate, <br><br>Click here to reset your password ".$website_url."user/pswd_reset.php?email=".$email."&key=".$encrypt."</a><br/> <br/>";  
               			
               			// $response = sendEmail($MailSubject, $MailBody, $email);
               			$response = sendEmail('Password Recovery Email',$MailBody,0,$email);
               			if($response == 1)
               			{
							echo "<div class=\"successmeg\">
									Your password reset link has been send to your e-mail address.  
								  </div>";
						}
						else
						{
							echo "<div class=\"successmeg\" style=\"color:red;\">
									Failed to deliver e-mail.  
								  </div>";
						}

                		// include "footer.php";
            		}
            		else
            		{
            			echo "<h3 style=\"color:red; font-size:16px; margin-left:575px;margin-top:175px;\">Email not registered</h3>
            				<div style='font-size:16px; margin-left:610px;'>
								<a href='forgot_password.php'><strong>Try Again</strong></a>
							</div>
            			";
                	
            		}
            	}
            	else
            	{

            		echo "<div class=\"alert alert-error\" style=\"width: 70%; margin:80px auto;padding:70px; text-align:center;\">";
					 $count = 0;
				    echo "<h5 style=\"text-align:left;margin:10px 0;color:red;\">Correct the errors</h5>";
				    foreach( $input_errors as $error)
				    {
				        echo "<div style=\"font-size:14px;text-align:left;margin:6px 0;color:red;\">".++$count.") ".$error."</div>";
				    }
					echo "</div>";

            	}
            }
            


function get_rand_id1($length)
{
  if($length>0)
  {
    $rand_id="";
    for($i=1; $i<=$length; $i++)
    {
        mt_srand((double)microtime() * 1000000);
        $num = mt_rand(1,36);
        $rand_id .= assign_rand_value($num);
    }
  }
return $rand_id;
}
if (!isset($_POST['upload']) && !$input_errors) 
{

	?>

	

		<!--<div class="alert alert-info" style="width:43%; margin:0 auto; text-align:center; font-size:16px; text-decoration:underline;">
			<a href="student_account_create.php"><strong>Click here to apply B.Tech admission online.</strong></a>
		</div>-->
	
	<form action="" id="reset_pswd" method="POST">
	<script>


  		
 	
	</script>

	<div class="container">
<div class="row">
<div class="col s10 offset-s2">
            <blockquote>
                <h5>Forgot Password</h5>
            </blockquote>
        <div class="input-field col s5 validation">
		    <i class="material-icons prefix">mail</i>
		    <input required type='email' name="email" placeholder="Email" value="<?php echo $email; ?>"autocomplete="off"/>
		    <label for="icon_prefix">Registered Email</label>
		</div>

		<div class="input-field col s5 validation">
		    <i class="material-icons prefix">image</i>
		    <input type='text' name="captcha" placeholder='Enter the characters' ><img id="imgCaptcha" src="create_image.php" >
			<span style="color:red";><?php echo $captchaError;?></span>
		    <label for="icon_prefix">Enter what you see in image</label>
		</div>

		<div class="input-field col s5 validation">
		   
		   <input name="upload" style="margin-bottom: 4px;" type="submit" class="btn" id="ok" value="Submit">
			<input type="hidden" name="admissionType" value='0' >
		</div>

    </div>
    </div>
    </div>
	
	

	
	</form>
	

<?php
}



?>

