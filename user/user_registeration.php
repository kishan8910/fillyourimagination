<?
	
	session_start();
    include "../libcommon/conf.php";
    include "../libcommon/classes/db_mysql.php";
    include "../libcommon/functions.php";
    include "../libcommon/db_inc.php";

    include "header.php";

?>

<script type="text/javascript">
	function redirect(url)
	{
		window.location.href = url;
	}

	$(document).ready(function(){
     	
     	$("#userDetails").submit(function(e) {
	    	
	    	e.preventDefault();

	    	   var data_string = $("#userDetails").serialize();


			$.ajax({
	            type: "POST",
	            url: "ajax_save_user.php",
	            data: data_string,
	            success: function(response)
	            {

	            	if (response == 1) 
	            	{


					  var $toastContent = $('<span>Already Registered User!</span>').add($('<button class="btn-flat toast-action" onclick="redirect(\'index_login.php\')">Login Here</button>'));
					  Materialize.toast($toastContent, 10000);
					    
	            	}
	            	else if (response == 2) 
	            	{

	            		var $toastContent = $('<span>User Saved Successfully ! File not saved ! Please login and upload!</span>').add($('<input type="button" class="btn-flat toast-action" onclick="redirect(\'index_login.php\')" value="Login Here">'));
						  Materialize.toast($toastContent, 20000);



	            	}
	            	else
	            	{
	            		var $toastContent = $('<span>Saved Successfully ! Login for further details!</span>').add($('<input type="button" class="btn-flat toast-action" onclick="redirect(\'index_login.php\')" value="Login Here">'));
						  Materialize.toast($toastContent, 20000);
	            	}
	            }
	          });  
	    	return false;


		});

	});

	
	// function saveUser()
	// {
		
	// 	$("#userDetails").submit();
	// }


</script>


<!DOCTYPE HTML>
<div class="container">
<div class="row">
<div class="col s10 offset-s2">
<div class="input-field col s10">
	<div class="card lighten-3 z-depth-2">
<div class="card-content">
  <span class="card-title"><h4>Price Details</h4></span>

  	<?
  	
  		$totalTime = $_SESSION['totalTime'];
  		$printTimeHr = secToHR($totalTime);
        $printTimeHrCalc = $totalTime*(1/3600);
        $totalAmt = $printTimeHrCalc * 150;

        function secToHR($seconds) {
		  $hours = floor($seconds / 3600);
		  $minutes = floor(($seconds / 60) % 60);
		  $seconds = $seconds % 60;
		  return $hours > 0 ? "$hours hours, $minutes minutes" : ($minutes > 0 ? "$minutes minutes, $seconds seconds" : "$seconds seconds");
		}

  	?>
  	<table>
  		<!-- <tr>
  			<td>Filament Used</td><td><?php echo $_SESSION['filamentUsed'] ?> grams</td>
  			
  		</tr> -->
  		<tr>
  			<td>Printing Duration</td><td><?php echo $printTimeHr; ?></td>
  		</tr>
  		<!-- <tr>
  			<td>Price Calculation</td><td><?php echo "(".$printTimeHr.") * 150"; ?></td>
  		</tr> -->
  		<tr>
  			<td>Total</td><td>Rs.<?php echo round($totalAmt,2); ?></td>
  		</tr>
  	</table>
  	<!-- <div>Filament Used : <?php echo $responseArray[0][filamentUsed][amount]; ?> grams</div>
  	<div>Printing Duration (hour) : <?php echo $printTimeHr; ?></div>
  	<div>Price Calculation : <?php echo "(".$printTimeHr.") * 150"; ?></div>
  	<div>Total : <?php echo $totalAmt; ?></div> -->

</div>
</div>
</div>
</div>
<div class="col s10 offset-s2">
		<form id="userDetails" method="POST" >
			<blockquote>
      			<h5>User Information</h5>
    		</blockquote>
			<div class="input-field col s5">
		  		
		  		<i class="material-icons prefix">account_circle</i>
		          <input type='text' maxlength="30" size='40' placeholder="Name" id="name" name='name' value=''  minlength="2" required>
		          <label for="icon_prefix">Name</label>
          	</div>

          	<div class="input-field col s5">
		  		<i class="material-icons prefix">email</i>
		          <input type='email' required size='40' maxlength="50" name='email' placeholder="email" value='' >
		          <label for="icon_prefix">Email</label>
		     </div>

          	<div class="input-field col s5">
		  		<i class="material-icons prefix">phone_android</i>
		          <input type='number' min="1000000000" max="9999999999" name='mobile' required placeholder="mobile number" value=''>
		          <label for="icon_prefix">Mobile</label>
		     </div>

		     <div class="input-field col s5">
		  		<i class="material-icons prefix">drafts</i>
		          <input type="number" min="100000" max="999999"  class="input-large mandatory regx_name validate" required  placeholder="Post Code" name='postcode' id='postcode' value=''>
		          <label for="icon_prefix">Postcode</label>
		     </div>

		      <div class="input-field col s5">
		  		<i class="material-icons prefix">drafts</i>
		          <div class="input-field col s12">
		          <textarea name="address_delivery" maxlength="1000" id="address_delivery" class="materialize-textarea" required ></textarea>
		          <label for="address_delivery">Address (Delivery Address Preferred)</label>
		        </div>
		     </div>

		     <div class="input-field col s5">
		  		<i class="material-icons prefix">security</i>
		          <input type='password' required size='40' name='password' placeholder="password" required value='' >
		          <label for="icon_prefix">Password</label>
		     </div>

		     <div class="input-field col s10">
		          <div class="input-field col s5">
		          	<input type="submit"  style="background-color: #154170;" class="btn" name="save" value="Save and Proceed">
		        </div>
		         <div class="input-field col s5">
		          	<a href="index_login.php"><button  type='button' style="background-color: #154170;" name='btn_login' class='btn waves-effect'>Cancel</button></a>
		        </div>
		        
		     </div>

		    
		</form>

</div>
</div>
</div>


