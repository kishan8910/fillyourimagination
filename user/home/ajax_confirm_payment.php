<?php

session_start();
include "../../libcommon/conf.php";
include "../../libcommon/classes/db_mysql.php";

include "../../libcommon/db_inc.php";
include "../../libcommon/functions.php";


$user_files = trim(sql_real_escape_string($_POST['user_files']));

$user_files = substr($user_files, 0,-1);


echo "
<style>
td,th {
  padding: 3px 5px;
}
</style>
";


echo "<input type='hidden' value='".$user_files."' id='user_files'>";

$query = "SELECT uf.id as user_files_id,uf.user_id,uf.filepath,uf.file_title,uf.infill,uf.layerHeight,uf.material,uf.filamentUsed,uf.totalTime,re.reviewed_price,re.reviewed_time,uf.estimated_price FROM user_files uf inner join reviewed_estimation re on uf.id = re.user_files_id where uf.id in (".$user_files.")";

$result = sql_query($query,$connect);

if(sql_num_rows($result)) 
{
  $totalAmount = 0;
   echo '<div class="container">
<div class="row">
<div class="col s10 offset-s2">
<div class="input-field col s10">
  <div class="card blue-grey darken-1">
<div class="card-content white-text">
  <span class="card-title">Price Details</span>';

  $user_files_amount_arr = array();
  $user_files_title = array();
  while ($details = sql_fetch_array($result)) {

  $user_files_id = $details['user_files_id'];
  $filepath = $details['filepath'];
  $file_title = $details['file_title'];
  $infill = $details['infill'];
  $layerHeight = $details['layerHeight'];
  $material = $details['material'];
  $filamentUsed = $details['filamentUsed'];
  $totalTime = $details['totalTime'];
  $reviewed_price = $details['reviewed_price'];
  $reviewed_time = $details['reviewed_time'];
  $estimated_price = $details['estimated_price'];

  $user_files_amount_arr[$user_files_id] = $reviewed_price;
  $user_files_title[$user_files_id] = $file_title;

      $stimated_hr= secToHR($totalTime);
      $reviewed_hr = secToHR($reviewed_time);
      // $printTimeHrCalc = $totalTime*(1/3600);
       


  echo '

      <table>
      <tr><th style="text-align:center;" colspan="2"><h5>'.$file_title.'</h5></th></tr>
      <tr>
        <td>Infill Percentage</td><td>'.$infill.' %</td>
        
      </tr>
      <tr>
        <td>Layer Height</td><td>'.$layerHeight.' mm</td>
        
      </tr>
      <tr>
        <td>Material Type</td><td>'.$material.'</td>
        
      </tr>
      <tr>
        <td>Filament Used</td><td>'.$filamentUsed.' grams</td>
        
      </tr>
      <tr>
        <td>Estimated Printing Duration</td><td>'.$stimated_hr.'</td>
      </tr>
      <tr>
        <td>Estimated Printing Price</td><td>'.$estimated_price.'</td>
      </tr>
      <tr>
        <td>Reviewed Printing Duration</td><td>'.$reviewed_hr.'</td>
      </tr>
      <tr>
        <td>Reviewed Printing Price</td><td>'.$reviewed_price.'</td>
      </tr>
      
      
    </table>

  ';
  }

  echo '
  </div></div></div>
  </div></div></div>';

  echo '
  <div class="container">
<div class="row">
  <div class="col s10 offset-s2">
    <h4 class="header">Invoice</h4>
    <div class="card horizontal">
      
      <div class="card-stacked">
        <div class="card-content">
            ';
            $total_sum = 0;
            foreach ($user_files_title as $user_files_id => $file_title) {
                $tax_amount = null;
                $amount = null;
                $model_rate = $user_files_amount_arr[$user_files_id];
                // echo "
                
                // <tr>
                //   <td style='width:25%;font-size:18px;'>".$file_title."</td>
                //   <td style='width:25%;font-size:18px;'>".$model_rate."</td>
                //   <td style='width:25%;font-size:18px;'>";
                      $tax_amount = ($model_rate*$printing_tax)/100;
                      // echo $printing_tax." %";
                  // echo "</td>
                  // <td style='width:25%;font-size:18px;'>";
                      $amount = $tax_amount + $model_rate;
                      $amount = round($amount,2);
                //   echo "</td>
                // </tr>";
                $total_sum = $total_sum + $amount;
            }
            
            // echo "<tr><td style='font-size:20px;'>Total  </td><td style='font-size:20px;'>";
           
            $total_sum = round($total_sum,2);
            // echo $total_sum;

            $query = "select * from user where id = '$_SESSION[user_id]'";
            $result = sql_query($query,$connect);
            $data = sql_fetch_array($result);
            $user_mobile = $data['mobile'];
            $email = $user_email = $data['email'];
            $firstname = $_SESSION['user_name'];
            



            // $productinfo = array('paymentParts' => array(array(
            //   'name'=>"INFILLCUBE",
            //     'description'=>'Printing Charge',
            //     'value'=>'$total_sum',
            //     'isRequired'=>'true',
            //     'settlementEvent' => 'EmailConfirmation'
            //   )),
            //   'paymentIdentifiers'=>array(array(
            //             'field'=>'CompletionDate',
            //             'value'=> date("d/m/Y")
            //     ),
            //   array(
            //           'field'=>'TxnId',
            //           'value'=>$txnid
            //   )));
            // $productinfo = "INFILLCUBE";

           


            //payment essentials

            $key = $payu_merchant_key;
            $amount = round($total_sum,2);
            $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            $udf1 = $_SESSION['user_id'];
            $udf2 = $user_files;
            

            //  $productinfo = array('paymentParts' => array(array(
            //   'name'=>"INFILLCUBE",
            //     'description'=>'Tution Fee',
            //     'value'=>'500',
            //     'isRequired'=>'true',
            //     'settlementEvent' => 'EmailConfirmation'
            // )),
            //     'paymentIdentifiers'=>array(array(
            //             'field'=>'CompletionDate',
            //             'value'=>'02/01/2017'
            //     ),
            //   array(
            //           'field'=>'TxnId',
            //           'value'=>$txnid
            //   )));
            $productinfo = "INFILLCUBE";
            $service_provider = "payu_paisa";
            $udf3 = implode(',', $user_files_title);
            $udf4 = implode(',', $user_files_amount_arr);
            
            $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
              $hashVarsSeq = explode('|', $hashSequence);
                $hash_string = '';  

              foreach($hashVarsSeq as $hash_var) 
              { 
                $hash_string .= $hash_var!=null ? $$hash_var : '';
                  $hash_string .= '|';
              }
                // echo $hash_string;
                $hash_string .= $payu_merchant_salt;

                // echo $hash_string;
                $hash = strtolower(hash('sha512', $hash_string));
                $action = $PAYU_BASE_URL . '/_payment';
            // echo "<input type='hidden' id='key' value='".$payu_merchant_key."'>";
            // echo "<input type='hidden' id='salt' value='".$payu_merchant_salt."'>";
            // echo "<input type='hidden' id='txnid' value='".$txnid."'>";
            // echo "<input type='hidden' id='amount' value='".$amount."'>";
            // echo "<input type='hidden' id='user_name' value='".$_SESSION['user_name']."'>";
            // echo "<input type='hidden' id='user_mobile' value='".$user_mobile."'>";
            // echo "<input type='hidden' id='user_email' value='".$user_email."'>";
            // echo "<input type='hidden' id='hash' value='".$hash."'>";
            // echo "<input type='hidden' id='udf1' value='".$udf1."'>";
            // echo "<input type='hidden' id='udf2' value='".$udf2."'>";
            // echo "<input type='hidden' id='udf3' value='".$udf3."'>";
            // echo "<input type='hidden' id='udf4' value='".$udf4."'>";
            




            echo '
        </div>';
              include 'invoice.php';

        echo '<div class="card-action">
          

            <div class="input-field col s10 offset-s2">
                  <div class="input-field col s5">
                    <input type="button" class="btn" name="save" value="Checkout" onclick=\'saveTransactionDetails("'.$user_files.'");\'>
                </div>
                 <div class="input-field col s5">
                    <input type="button" name="btn_login" value="Cancel" class="btn waves-effect lighten-1" onclick="cancelPayment();">
                </div>
                
             </div>


        </div>';
        
      $surl = $local_success_url_model;
      $furl = $local_failure_url_model;


?>

<html>
      <form action="<?php echo $action; ?>" method="post" name="payuForm" id="payuForm">
          <input type="hidden" name="key" value="<?php echo $payu_merchant_key ?>" />
          <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
          <input type="hidden" name="txnid"  id="txnid" value="<?php echo $txnid ?>" />
          <input type="hidden" name="amount" id="amount" value="<?php echo $amount ?>" />
          <input type="hidden" name="firstname" id="firstname" value="<?php echo $_SESSION[user_name]; ?>" />
      <input type="hidden" name="email" id="email" value="<?php echo $user_email; ?>" />
          <input type="hidden" name="phone" value="<?php echo $user_mobile; ?>" />
          <input type="hidden" name="productinfo" value="INFILLCUBE"/>
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

          <!-- <div style = "width:50%; margin:13% auto ; padding: 10px; text-align:center; background-color:#eee; border: 2px solid #0672a4;"> -->
        <!-- <table class="table table-bordered" cellpadding="0" cellspacing="2" border="0" align="center" >
          <tr>
            <th style="text-align: center;">Total amount to be paid :   </th>
            <th style="text-align: center;">&#8377;<?=$amount?></th>
          </tr> -->
          <!-- <tr>
            <td colspan="2" style = "text-align:center">
              <input type="button" onclick = "saveTransactionDetails('1,2');" id="proceed" value="Proceed to Payment Gateway">
              <span style= "margin:15px"></span>
              <button type="button" onclick = "return cancel();" >Cancel</button>
            </td>
          </tr> -->
        <!-- </table> -->
      <!-- </div> -->

      </form>
    </body>
   

</html>




  <?    echo '</div>
    </div>
  </div>
  </div></div>
            ';
}


 function secToHR($seconds) {
      $hours = floor($seconds / 3600);
      $minutes = floor(($seconds / 60) % 60);
      $seconds = $seconds % 60;
      return $hours > 0 ? "$hours hours, $minutes minutes" : ($minutes > 0 ? "$minutes minutes, $seconds seconds" : "$seconds seconds");

    }




?>




  

