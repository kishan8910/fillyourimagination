<script type="text/javascript">
  
function redirect(url)
{
  window.location.href = url;
}


function confirmEstimation()
{

  $("#estimate_btn").attr("disabled",true);

  $.ajax({
        type: "POST",
        url: "home/ajax_confirm_estimation.php",
        data: "",
        success: function(response)
        {

          if (response == 1) 
          {

           
      var $toastContent = $('<span>Error Occurred!</span>').add($('<button class="btn-flat toast-action" onclick="redirect(\'?u=home&b=estimate\')">Choose Again</button>'));
      Materialize.toast($toastContent, 10000);
        
          }
          else
          {
            
            var $toastContent = $('<span>Saved Successfully !</span>').add($('<input type="button" class="btn-flat toast-action" onclick="redirect(\'?u=home&b=estimate\')" value="Continue">'));
        Materialize.toast($toastContent, 10000);

      // alert(toastContent);

          }
        }
      });  
    return false;
}

</script>

<div class="container">
<div class="row">
<div class="col s10 offset-s2">
<div class="input-field col s10">
	<div class="card lighten-1 z-depth-4">
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
  		<tr>
  			<td>Filament Used</td><td><?php echo $_SESSION['filamentUsed'] ?> grams</td>
  			
  		</tr>
  		<tr>
  			<td>Printing Duration</td><td><?php echo $printTimeHr; ?></td>
  		</tr>
  		<tr>
  			<td>Price Calculation</td><td><?php echo "(".$printTimeHr.") * 150"; ?></td>
  		</tr>
  		<tr>
  			<td>Total</td><td> Rs.<?php echo round($totalAmt,2); ?></td>
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


  <div class="input-field col s10 offset-s2">
              <div class="input-field col s5">
                <input type="button" class="btn" style="background-color: #02547D;" name="save" id="estimate_btn" value="Confirm" onclick="confirmEstimation();">
            </div>
             <div class="input-field col s5">
                <a href="?u=home&b=estimate" ><button type='button' style="background-color: #02547D;" name='btn_login' class='btn waves-effect lighten-1'>Cancel</button></a>
            </div>
            
         </div>
</div>
</div>