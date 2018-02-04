
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>



    <div  class="container">
<div class="row">
<div class="col s12">
    <div id="invoice" class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img  src="../libcommon/images/infillcube_icon.png" style="width:100%; max-width:70px;">
                            </td>
                            
                            <td>
                                Invoice Date
                                <br>
                                    <?php 
                                        echo date('d-m-Y');
                                    ?>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Infillcube<br>
                                Kakkanad<br>
                                Kochi
                            </td>
                            
                            <td>
                                <?=$firstname?><br>
                                <?=$email?><br>
                                <?=$user_mobile?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            
            
            <tr>
            <td colspan="2">
            <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td style='width:25%;text-align:center;'>Item</td>
                <td style='width:25%;text-align:center;'>Price</td>
                <td style='width:25%;text-align:center;'>Tax</td>
                <td style='width:25%;text-align:center;'>Amount</td>
            </tr>
            <?
                $total_sum = 0;
                $total_gst_sum = 0;


                foreach ($user_files_title as $user_files_id => $file_title) {
                $tax_amount = null;
                $amount = null;
                $model_rate = $user_files_amount_arr[$user_files_id];
                echo "
                
                <tr class='item'>
                  <td style='width:25%;text-align:center;'>".$file_title."</td>
                  <td style='width:25%;text-align:center;'>".$model_rate."</td>
                  <td style='width:25%;text-align:center;'>";
                      $tax_amount = ($model_rate*$printing_tax)/100;
                      echo $printing_tax." %";
                  echo "</td>
                  <td style='width:25%;text-align:center;'>";
                      $amount = $tax_amount + $model_rate;
                      echo $amount = round($amount,2);
                  echo "</td>
                </tr>";
                $total_sum = $total_sum + $amount;
                $total_gst_sum = $total_gst_sum + $tax_amount;
            }
            
            echo "<tr class='total'><td colspan='3' style='text-align:right;'> GST </td><td style='text-align:center;'>";
           
            $total_gst_sum = round($total_gst_sum,2);
            echo "Rs.".$total_gst_sum."</td></tr>";

            echo "<tr class='total'><td colspan='3' style='text-align:right;'>Total  </td><td style='text-align:center;'>";
           
            $total_sum = round($total_sum,2);
            echo "Rs.".$total_sum."</td></tr>";



            ?>
            </table>
            </td>
            </tr>
        
           
        </table>
    </div>
    </div>
    </div>
