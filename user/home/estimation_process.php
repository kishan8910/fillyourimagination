<?php

function buildMultipartPost($fields, $files, $boundary=""){
    
        $output = "";
        $disallowedChars = array("\0", "\"", "\r", "\n");
        foreach($fields as $key => $value){
            $key = str_replace($disallowedChars, "_", $key);
            $value = str_replace($disallowedChars, "_", $value);
            $output .= $boundary . "\n" . "Content-Disposition: form-data; name=\"".$key."\"\n\n".$value."\n";
        }
        
        foreach($files as $key => $value){
            $key = str_replace($disallowedChars, "_", $key);
            
            if (is_array($value["name"]) == false){
                $value['name'] = str_replace($disallowedChars, "_", $value['name']);
                $value['type'] = str_replace($disallowedChars, "_", $value['type']);
                $output .= $boundary . "\n" . "Content-Disposition: form-data; name=\"".$key."\"; filename=\"".$value['name']."\"\n" . "Content-Type: ".$value['type']."\n\n".file_get_contents($value['tmp_name'])."\n";
            }
            else{
                // print_r($value);
                for($i=0; $i<count($value["name"]); $i++){
                    // echo $value['tmp_name'][0];
                    
                    if ($value["error"][$i] != 0)
                        continue;
                    $value['name'][$i] = str_replace($disallowedChars, "_", $value['name'][$i]);
                    $value['type'][$i] = str_replace($disallowedChars, "_", $value['type'][$i]);
                    $output .= $boundary . "\n" . "Content-Disposition: form-data; name=\"".$key."[]\"; filename=\"".$value['name'][$i]."\"\n" . "Content-Type: ".$value['type'][$i]."\n\n".file_get_contents($value['tmp_name'][$i])."\n";
                    

                }
            }
        }
        
        return $output.$boundary."--";
   
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    

   

    // print_r($_FILES);
    // var_dump($_POST);
    $_POST['layerHeight'] = $_POST['layerHeight'] - 0.05;
    $boundary = "------WebKitFormBoundary".substr(md5(microtime(true)),0,16);
    
    $ch = curl_init("http://api.3dpartprice.com");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data; boundary=".substr($boundary,2)));
    curl_setopt($ch, CURLOPT_POST, true);
    $_POST["configFile"] = urlencode(base64_encode(serialize(get_class_vars("partPriceConfig"))));
    $_POST["density"] = partPriceConfig::$materials[$_POST["material"]]["density"]["amount"];
    // print_r($_FILES['stlFiles']['tmp_name'][0]);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, buildMultipartPost($_POST, $_FILES, $boundary));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    
    // $query = "INSERT INTO user (userType) VALUES ('customer')";
    // $result = sql_query($query,$connect);
    // $user_id = mysql_insert_id();

    // $_SESSION['user_id'] = $user_id;

    // if ($user_id != 0) {
    //     $query = "INSERT INTO user_files (user_id,filepath,file_title,infill,layerHeight,material) VALUES ('$user_id','$file_path','','$_POST[infillPercentage]','$_POST[layerHeight]','$_POST[material]')";
    //     $result = sql_query($query,$connect);
    // }



    $allowed =  array('stl','STL');
    $filename = $_FILES['stlFiles']['name'][0];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $size = $_FILES['stlFiles']['size'][0];
    $file_extension_error = null;
    if(!in_array($ext,$allowed) || $size > 10485760) { //10mb
        $file_extension_error = 1;
        include '../error_message.php';
        break;
    }

    $response = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($httpCode != 200){
        // echo "http code: ".$httpCode.", error occured!";
        // echo "<pre>".print_r(unserialize($response),true)."</pre>";

        include '../error_message.php';


    }
    else{
        $responseArray = unserialize($response);
        $totalWeight = 0;
        $totalTime = 0;
        
        foreach($responseArray as $model){
            $totalWeight += $model["filamentUsed"]["amount"];
            $totalTime += $model["printDuration"]["amount"];
        }
        
        $summary = array();
        
        $summary["metadata"]["material"] = $_POST["material"];
        $summary["metadata"]["color"] = $_POST["color"];
        $summary["metadata"]["infillPercentage"] = $_POST["infillPercentage"];
        $summary["metadata"]["layerHeight"] = $_POST["layerHeight"];
        $summary["metadata"]["supportRemoval"] = isset($_POST["supportRemoval"])?"true":"false";
        $summary["metadata"]["vaporPolishing"] = isset($_POST["vaporPolishing"])?"true":"false";
        $summary["metadata"]["shipping"] = $_POST["shipping"];
        $summary["metadata"]["rushPrinting"] = isset($_POST["shipping"])?"true":"false";
        
        $summary["totalWeight"]["amount"] = $totalWeight;
        $summary["totalWeight"]["unit"] = "grams";
        
        $summary["totalTime"]["amount"] = $totalTime;
        $summary["totalTime"]["unit"] = "seconds";
        
        //$summary["material"] = partPriceConfig::$materials[$_POST["material"]];
        
        $summary["costs"]["printTime"]["amount"] = number_format($totalTime*1/(60*60)*partPriceConfig::$printingCost["amount"],2);
        $summary["costs"]["printTime"]["calculation"] = $totalTime." seconds * (1 hour)/(60*60 seconds) * \$".partPriceConfig::$printingCost["amount"].' '.partPriceConfig::$printingCost["unit"];
        $summary["costs"]["printTime"]["unit"] = "USD";
        
        $summary["costs"]["material"]["amount"] = number_format($totalWeight * partPriceConfig::$materials[$_POST["material"]]["price"]["amount"],2);
        $summary["costs"]["material"]["calculation"] = number_format($totalWeight,2)." grams * ".number_format(partPriceConfig::$materials[$_POST["material"]]["price"]["amount"],2). ' '.partPriceConfig::$materials[$_POST["material"]]["price"]["unit"];
        $summary["costs"]["material"]["unit"] = "USD";
        
        if (isset($_POST["supportRemoval"])){
            $summary["costs"]["supportRemoval"]["amount"] = number_format($summary["costs"]["material"]["amount"] * (partPriceConfig::$addOns["supportRemovalMultiplier"]-1),2);
            $summary["costs"]["supportRemoval"]["calculation"] = number_format($summary["costs"]["material"]["amount"],2)." USD * (".partPriceConfig::$addOns["supportRemovalMultiplier"]."-1) supportRemovalMultiplier";
            $summary["costs"]["supportRemoval"]["unit"] = "USD";
        }
        
        if (isset($_POST["vaporPolishing"])){
            $summary["costs"]["vaporPolishing"]["amount"] = number_format($summary["costs"]["material"]["amount"] * (partPriceConfig::$addOns["vaporPolishingMultiplier"]-1),2);
            $summary["costs"]["vaporPolishing"]["calculation"] = number_format($summary["costs"]["material"]["amount"],2)." USD * (".partPriceConfig::$addOns["vaporPolishingMultiplier"]."-1) vaporPolishingMultiplier";
            $summary["costs"]["vaporPolishing"]["unit"] = "USD";
        }
        
        if ($_POST["shipping"] == "delivery"){
            $summary["costs"]["delivery"]["amount"] = number_format(partPriceConfig::$deliveryCosts["base"]["amount"] + $totalWeight*partPriceConfig::$deliveryCosts["weightPrice"]["amount"],2);
            $summary["costs"]["delivery"]["calculation"] = number_format(partPriceConfig::$deliveryCosts["base"]["amount"],2) . " ".partPriceConfig::$deliveryCosts["base"]["unit"].' base + '.number_format($totalWeight,2).' grams * '.number_format(partPriceConfig::$deliveryCosts["weightPrice"]["amount"],2).' '.partPriceConfig::$deliveryCosts["weightPrice"]["unit"];
            $summary["costs"]["delivery"]["unit"] = "USD";
        }
        
        $summary["subtotal"]["amount"] = 0;
        $summary["subtotal"]["calculation"] = "";
        foreach($summary["costs"] as $costName => $costArray){
            $summary["subtotal"]["amount"] += $costArray["amount"];
            $summary["subtotal"]["calculation"] .= $costArray["amount"]." ". $costArray["unit"]." ".$costName." + ";
        }
        $summary["subtotal"]["calculation"] = substr($summary["subtotal"]["calculation"],0,-3);
        $summary["subtotal"]["unit"] = "USD";
        
        if (isset($_POST["rushPrinting"])){
            $summary["total"]["amount"] = number_format($summary["subtotal"]["amount"]*partPriceConfig::$addOns["rushPrintingMultiplier"],2);
            $summary["total"]["calculation"] = $summary["subtotal"]["amount"]." ".$summary["subtotal"]["unit"]." subtotal * ".partPriceConfig::$addOns["rushPrintingMultiplier"].' rushDeliveryMultiplier';
        }
        else{
            $summary["total"]["amount"] = number_format($summary["subtotal"]["amount"],2);
            $summary["total"]["calculation"] = $summary["subtotal"]["amount"].' subtotal';
        }
        $summary["total"]["unit"] = "INR";
        
        // echo "<pre><h2>Total Costs</h2>".print_r($summary,true)."</pre>";
        
        $name =  basename($_FILES['stlFiles']['name'][0]);
        $file_path = 'usermodels/'.substr(md5(microtime(true)),0,16).$name;
        
        if(move_uploaded_file($_FILES['stlFiles']['tmp_name'][0], $file_path))
        {

            $printTimeHr = secToHR($totalTime);
            $printTimeHrCalc = $totalTime*(1/3600);
            $totalAmt = round(($printTimeHrCalc * 150),2);

            // echo "<pre><h2>API Response</h2>".print_r($responseArray,true)."</pre>";

            $_SESSION['file_path'] = $file_path;
            $_SESSION['infillPercentage'] = $_POST[infillPercentage];
            $_SESSION['layerHeight'] = $_POST[layerHeight];
            $_SESSION['material'] = $_POST[material];
            $_SESSION['filamentUsed'] = $responseArray[0][filamentUsed][amount];
            $_SESSION['totalTime'] = $totalTime;
            $_SESSION['estimated_price'] = $totalAmt;
            $_SESSION['file_title'] = $name;
            $_SESSION['filament_color'] = $_POST[color];

            echo " <script type=\"text/javascript\">
                window.location.href=\"user.php?u=home&b=confirm_estimation\";
                </script>";
        }
        else
        {
            echo "Error in uploading file";
        }
        
    }
    
    //echo "<pre>".print_r($response,true)."</pre>";
}   


function secToHR($seconds) {
  $hours = floor($seconds / 3600);
  $minutes = floor(($seconds / 60) % 60);
  $seconds = $seconds % 60;
  return $hours > 0 ? "$hours hours, $minutes minutes" : ($minutes > 0 ? "$minutes minutes, $seconds seconds" : "$seconds seconds");
}