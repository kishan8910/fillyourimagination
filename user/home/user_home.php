<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="<color-code>" bolt-logo="<image path>"></script>

<!-- <script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="<color-
code>" bolt-logo="<image path>"></script> -->

<script type="text/javascript">
    
    function saveTransactionDetails(user_files)
    {


        var txnid = $("#txnid").val();
        var amount = $("#amount").val();

        var data = "txnid="+txnid+"&amount="+amount+"&user_files="+user_files;
        
        $.ajax({
                type: "POST",
                url: "home/ajax_save_transaction_details.php",
                data: data,
                success: function(response)
                {
                    
                    if (response == 1) 
                    {
                        Materialize.toast('Some error has been occured. Please try again', 2000,'');
                        return false;
                    }
                    else if (response == 0) 
                    {
                        // proceedPayment();
                        $("#payuForm").submit();
                    
                        return true;
                    } 
                }
        });
    }

    function proceedPayment()
    {
        var merchant_key = $("#key").val();
        var calc_txnid = $("#txnid").val();
        var calc_hash = $("#hash").val();
        // var calc_amount = $("#amount").val();
        var user_name = $("#user_name").val();
        var user_email = $("#user_email").val();
        var user_mobile = $("#user_mobile").val();
        var info = "INFILLCUBE";


        var calc_amount = $("#amount").val();
        var service_provider = $("#service_provider").val();

        console.log(calc_amount);
        // console.log(calc_hash);

        bolt.launch({
            key: merchant_key,
            txnid: calc_txnid, hash: calc_hash,
            amount: calc_amount,
            firstname: user_name,
            email: user_email,
            phone: user_mobile,
            productinfo: info,
            surl : '<?=$local_success_url_model?>',
            furl: '<?=$local_failure_url_model?>'

            },{ responseHandler: function(response){
            // your payment response Code goes here
            },
            catchException: function(response){
            // the code you use to handle the integration errors goes here
            }
        });
    }

    function cancelPayment()
    {
        window.location.reload();
    }

    function showPaymentDetails()
    {
        var user_files = "";
        $(".reviewed:checked").each(function () {
            var user_files_id = $(this).val();
            user_files = user_files+user_files_id+",";
        });

        if (user_files == "") 
        {
            Materialize.toast('Please select atleast one model !', 2000,'');
        }
        else
        {
            var data = "user_files="+user_files;
            $.ajax({
                    type: "POST",
                    url: "home/ajax_confirm_payment.php",
                    data: data,
                    success: function(response)
                    {
                        if (response == 1) 
                        {
         
                            Materialize.toast('Error occurred ! Please try again', 1000,'');
                        }
                        else
                        {
                            $("#response").html(response);
                        }
                    }
                  });  
            return false;
        }
    }

</script>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >

</head>
<?

function secToHR($seconds) {
          $hours = floor($seconds / 3600);
          $minutes = floor(($seconds / 60) % 60);
          $seconds = $seconds % 60;
          return $hours > 0 ? "$hours hours, $minutes minutes" : ($minutes > 0 ? "$minutes minutes, $seconds seconds" : "$seconds seconds");
        }

$sql = "SELECT * FROM user_files where user_id = '$_SESSION[user_id]'";
        // echo $sql;
        $result = sql_query($sql, $connect);
        if(sql_num_rows($result))
        {

echo "
<div id='response'>
<div class='container'><div class='row'><div class='col s11 offset-s2'><table class='bordered striped' style='width:100%;margin-top:30px;' >
                <tr>
                <th>Sl.No</th>
                <th>File</th>   

                <th>Layer Height</th>
                <th>Material</th>

                <th>Estimated Time</th>
                
                <th>";
                    echo "<input type='button' class='btn' style='background-color:#02547D;' value='Make Payment' onclick=\"showPaymentDetails();\">";

                echo "</th>
            </tr>";
            while($row = sql_fetch_array($result))
            {
                $user_files_id = $row['id'];
                $estimated_hr = secToHR($row['totalTime']);

                echo "<tr align=\"center\" class=\"\" id=\"\">
                <td style='text-align:center;'>".(++$start)."</td>
                <td>".$row['file_title']."</td>

                <td>".$row['layerHeight']." mm</td>
                <td>".$row['material']."</td>

                <td>".$estimated_hr."</td>
                <td style='text-align:center;'>";
                $sql = "select * from reviewed_estimation where user_files_id = '$user_files_id'";
                $res = sql_query($sql,$connect);

                if (sql_num_rows($res)) {
                    $query = "SELECT user_files_id FROM user_model_online_payment WHERE user_id = '$_SESSION[user_id]' AND status = 'success'";
                    $res_success = sql_query($query,$connect);
                    if (sql_num_rows($res_success)) 
                    {
                        $user_files_ids = "";
                        while ($row_success = sql_fetch_array($res_success)) {
                            $user_files = $row_success['user_files_id'];
                            $user_files_ids = $user_files_ids.$user_files.",";
                        }
                        $user_files_ids = substr($user_files_ids, 0,-1);
                        
                        $user_files_ids_arr = explode(',', $user_files_ids);
                        
                        if (in_array($user_files_id, $user_files_ids_arr)) {
                            echo "Already Paid";
                        }
                        else
                        {
                            echo "

                                <div class='switch'>
                                <label>
                                  <div style='margin:2px;'>Add to Cart</div>
                                  <input style='padding:5px;' type='checkbox' onclick='showMsg(".$user_files_id.")' class='reviewed' id='checkbox".$user_files_id."' value='".$user_files_id."'>
                                  <span class='lever'></span>
                                  
                                </label>
                              </div>

                               ";  
                        }
                    }
                    else
                    {
                        echo "<input type='checkbox' class='reviewed' id='checkbox".$user_files_id."' value='".$user_files_id."'>

                        <label for='checkbox".$user_files_id."'></label>
                        ";    
                    }
                    
                }
                else
                {
                    echo "Under Review";
                }

                echo "</td>
                 </tr>";
            }
            echo"</table>";
        }
        else
        {
            echo "<div class='container'><div class='row'><div class='col s10 offset-s2'><h4 style=\"text-align:center; margin:5% 5%; color:#F00;\">No Files Found</h4></div></div></div>";
        }

    echo "</div>";

    ?>