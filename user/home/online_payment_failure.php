


<script type="text/javascript">
  
function tryAgain() {
    window.location.href = "?u=home&b=user_home";
}

</script>


<?php

$key=$_POST["key"];
$txnid=$_POST["txnid"];
$amount=$_POST["amount"];
$productinfo=$_POST["productinfo"];
$firstname=$_POST["firstname"];
$email=$_POST["email"];

$udf1=$_POST["udf1"]; 
$udf2=$_POST["udf2"]; 


$status=$_POST["status"];

$posted_hash=$_POST["hash"];


$sql = "UPDATE user_model_online_payment SET status=\"$status\", transactionDate = \"".date("Y-m-d H:i:s")."\" WHERE transactionID = \"$txnid\"";
sql_query($sql, $connect);


if (isset($_POST["additionalCharges"])) 
{
    $additionalCharges=$_POST["additionalCharges"];
    $retHashSeq = $additionalCharges.'|'.$SALT.'|'.$status.'|||||||'.$udf4.'|'.$udf3.'|'.$udf2.'|'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;           
}
else 
{   

    $retHashSeq = $SALT.'|'.$status.'|||||||'.$udf4.'|'.$udf3.'|'.$udf2.'|'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

}
$hash = hash("sha512", $retHashSeq);

if ($hash != $posted_hash) 
{
    echo '
      <div class="container">
      <div class="row">
        <div class="col s6 offset-s3">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text" style="margin-top:140px;">
              <span class="card-title">Error Occured !</span>
              <p>Invalid Transaction</p>
            </div>
            <div class="card-action">
              <a href="?u=home&b=user_home"><input type="button" class="btn" value="Try Again"></a>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    ';
}
else 
{

  echo '
      <div class="container">
      <div class="row">
        <div class="col s6 offset-s3 valign">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text" style="margin-top:140px;">
              <span class="card-title">Error Occured !</span>
              <p>
                  <h3>Your order status is '. $status .'</h3>
                  <h4>Your transaction id for this transaction is ".$txnid.". You may try making the payment by clicking the <a href="?u=home&b=user_home">link.</a></h4>
              </p>
            </div>
            <div class="card-action">
              
              
            </div>
          </div>
        </div>
      </div>
    </div>

    ';
  
  
 } 
?>









