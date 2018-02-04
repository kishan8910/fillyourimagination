<script type="text/javascript">
  
  function CallPrint(strid)
{
  $("#print_invoice").hide();
  var prtContent = document.getElementById(strid);
  var WinPrint =
  window.open('','','letf=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status=0');
  // WinPrint.document.write('<link rel="stylesheet" href="../../libcommon/materialize/css/materialize.min.css">');
  WinPrint.document.write(prtContent.innerHTML);
  WinPrint.document.close();
  WinPrint.focus();
  WinPrint.print();
  WinPrint.close();
  prtContent.innerHTML=strOldOne;
}

</script>

<?php


$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];

$udf1=$_POST["udf1"]; 
$udf2=$_POST["udf2"];
$udf3 = $_POST["udf3"]; //user_files_title
$udf4 = $_POST["udf4"]; //user_files_amount_arr






$sql = "UPDATE user_model_online_payment SET status=\"$status\", transactionDate = \"".date("Y-m-d H:i:s")."\" WHERE txnID = \"$txnid\"";
sql_query($sql, $connect);



if (isset($_POST["additionalCharges"])) 
{
    $additionalCharges=$_POST["additionalCharges"];
    $retHashSeq = $additionalCharges.'|'.$payu_merchant_salt.'|'.$status.'|||||||'.$udf4.'|'.$udf3.'|'.$udf2.'|'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
}
else {
        $retHashSeq = $payu_merchant_salt.'|'.$status.'|||||||'.$udf4.'|'.$udf3.'|'.$udf2.'|'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
    }
$hash = hash("sha512", $retHashSeq);

// echo "<br><br>".$retHashSeq;

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
              '; 
             
            echo '</div>
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
        <div class="col s6 offset-s3">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text" style="margin-top:140px;">
              <span class="card-title">Payment Success!</span>
              <p>
                Thank You. Your online payment status is '. $status .'.
                Your Transaction ID for this transaction is '.$txnid.'.
                We have received a payment of Rs. ' . $amount . '.
              </p>
            </div>
            <div class="card-action">
              <a href="?u=home&b=user_home"><input type="button" class="btn" value="Continue"></a>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    ';
    $user_files_title = explode(',', $udf3);
    $user_files_amount_arr = explode(',', $udf4);
    

            $query = "select * from user where id = '$_SESSION[user_id]'";
            $result = sql_query($query,$connect);
            $data = sql_fetch_array($result);
            $user_mobile = $data['mobile'];
            $email = $user_email = $data['email'];
            $firstname = $_SESSION['user_name'];

            include 'invoice_print.php';

         echo '
      <div class="container">
      <div class="row">
        <div class="col s6 offset-s3">
          
            <div class="card-content center">
              
              <input type="button" class="btn" id="print_invoice" onClick=\'javascript:CallPrint("invoice");\' value="Print">   
              
            </div>
           
          
        </div>
      </div>
    </div>

    ';

}  

?>	