<script>

    function select_payment()
    {
    	$('#proceed').attr('disabled', true);
        var studentID =  $("#udf2").val();
        var txnid =  $("#txnid").val();
        var amount =  $("#amount").val();
        var patterncourseID = $("#udf3").val();
        var allotmentID = $("#udf1").val();
        var applnNo = $("#udf4").val();
  	    var dataString = "studentID="+studentID+"&txnid="+txnid+"&amount="+amount+"&allotmentID="+allotmentID+"&patterncourseID="+patterncourseID+"&applnNo="+applnNo;
	    $.ajax({
	            type: "POST",
	            url: "allotment/ajax_save_transaction_details.php",
	            data: dataString,
	            success: function(response)
	            {
	            	if (response == 1) 
	                {
	                	jAlert("Some error has been occured. Please try again");
	                	return false;
	                }
	                else if (response == 0) 
	                {
	                	$("#payuForm").submit();
	                	return true;
	                } 
	            }
	    });
    }
    function cancel()
	{
		window.location.href = "onlineapplication.php?menu=home&action=display_form";
	}
	
  </script>
<?php

$sqlcheck = "SELECT id FROM admission_tuitionfee_online_payment WHERE studentID=".$udf2." AND status = \"success\" and admission_allotment_table_id  = \"".$allotmentID."\"";
$resultcheck = sql_query($sqlcheck,$connect);
if(sql_num_rows($resultcheck))
{
	?>
		<script type="text/javascript">
			window.location.href = "onlineapplication.php?menu=home&action=display_form";
		</script>";
	<?
}

$action = '';

$hash = '';

// Hash Sequence
	$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	

	foreach($hashVarsSeq as $hash_var) 
	{	
		$hash_string .= $hash_var!=null ? $$hash_var : '';
  		$hash_string .= '|';
    }
    // echo $hash_string;
    $hash_string .= $SALT;

    // echo $hash_string;
    $hash = strtolower(hash('sha512', $hash_string));
    // echo $hash;
  	$action = $PAYU_BASE_URL . '/_payment';

?>
<html>
	    <form action="<?php echo $action; ?>" method="post" name="payuForm" id="payuForm">
	      	<input type="hidden" name="key" value="<?php echo $key ?>" />
	      	<input type="hidden" name="hash" value="<?php echo $hash ?>"/>
	      	<input type="hidden" name="txnid"  id="txnid" value="<?php echo $txnid ?>" />
	      	<input type="hidden" name="amount" id="amount" value="<?php echo $amount?>" />
	       	<input type="hidden" name="firstname" id="firstname" value="<?php echo $firstname; ?>" />
			<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
	        <input type="hidden" name="phone" value="<?php echo $phone; ?>" />
	      	<input type="hidden" name="productinfo" value="<?php echo $productinfo; ?>"/>
	      	<input type="hidden" name="surl" value="<?php echo $surl; ?>" size="64" />
	      	<input type="hidden" name="furl" value="<?php echo $furl; ?>" size="64" />
	      	<input type="hidden" name="service_provider" value="<?php echo $service_provider; ?>" size="64" />
	      	<input type="hidden" name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" />
	      	<input type="hidden" name="curl" value="" />
	      	<input type="hidden" name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" />
	      	<input type="hidden" name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" />
	      	<input type="hidden" name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" />
	      	<input type="hidden" name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" />
	      	<input type="hidden" name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" />
	     	<input type="hidden" name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" />
	      	<input type="hidden" name="udf1" id="udf1" value="<?php echo $udf1; ?>" />
	      	<input type="hidden" name="udf2" id="udf2" value="<?php echo $udf2; ?>" />
	      	<input type="hidden" name="udf3" id="udf3" value="<?php echo $udf3; ?>" />
	      	<input type="hidden" name="udf4" id="udf4" value="<?php echo $udf4; ?>" />
	      	<input type="hidden" name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" />
	      	<input type="hidden" name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" />

	      	<div style = "width:50%; margin:13% auto ; padding: 10px; text-align:center; background-color:#eee; border: 2px solid #0672a4;">
				<table class="table table-bordered" cellpadding="0" cellspacing="2" border="0" align="center" >
					<tr>
						<th style="text-align: center;">Total amount to be paid :   </th>
						<th style="text-align: center;">&#8377;<?=$amount?></th>
					</tr>
					<tr>
						<td colspan="2" style = "text-align:center">
							<input type="button" onclick = "select_payment();" id="proceed" value="Proceed to Payment Gateway">
							<span style= "margin:15px"></span>
							<button type="button" onclick = "return cancel();" >Cancel</button>
						</td>
					</tr>
				</table>
			</div>

	    </form>
    </body>
   

</html>
