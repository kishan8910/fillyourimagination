<?php

session_start();
include "../libcommon/conf.php";
include "../libcommon/classes/db_mysql.php";

include "../libcommon/db_inc.php";
include "../libcommon/functions.php";


$input_errors = array();

$name = trim(sql_real_escape_string($_POST['name']));

$email = trim(sql_real_escape_string($_POST['email']));

$mobile = trim(sql_real_escape_string($_POST['mobile']));
if(!preg_match( "/^[0-9]+$/", $mobile)) 
{
    array_push($input_errors, "Mobile number not valid.");
}


$address_delivery = trim(sql_real_escape_string($_POST['address_delivery']));

$postcode = trim(sql_real_escape_string($_POST['postcode']));

if(!preg_match( "/^[0-9]+$/", $postcode)) 
{
    array_push($input_errors, "Postcode not valid");
}

$password = md5(trim(sql_real_escape_string($_POST['password'])));



 $query = "INSERT INTO user (name,email,mobile,address,pincode,userType,password) VALUES ('$name','$email','$mobile','$address_delivery','$postcode','customer','$password') ";
$res = sql_query($query,$connect);

if (sql_error($res) || !empty($input_errors)) {

	unset($_SESSION['file_path']);
	unset($_SESSION['infillPercentage']);
	unset($_SESSION['layerHeight']);
	unset($_SESSION['filamentUsed']);
	unset($_SESSION['totalTime']);
	unset($_SESSION['filament_color']);

	session_unset();
	session_destroy();
	echo "1";
}
else
{
	$user_id = mysql_insert_id();
	if ($user_id != 0) 
	{        

		$layerHeight = $_SESSION[layerHeight] + 0.05;
        $query = "INSERT INTO user_files (user_id,filepath,file_title,infill,layerHeight,material,filamentUsed,totalTime,estimated_price,filament_color_id) VALUES ('$user_id','$_SESSION[file_path]','$_SESSION[file_title]','$_SESSION[infillPercentage]','$layerHeight','$_SESSION[material]',$_SESSION[filamentUsed],$_SESSION[totalTime],$_SESSION[estimated_price],$_SESSION[filament_color])";

        $result = sql_query($query,$connect);
        if(sql_error($result))
        	{

				unset($_SESSION['file_path']);
				unset($_SESSION['infillPercentage']);
				unset($_SESSION['layerHeight']);
				unset($_SESSION['filamentUsed']);
				unset($_SESSION['totalTime']);
				unset($_SESSION['filament_color']);

				session_unset();
				session_destroy();
        		echo "2";
        	}
	}
	
	unset($_SESSION['file_path']);
	unset($_SESSION['infillPercentage']);
	unset($_SESSION['layerHeight']);
	unset($_SESSION['filamentUsed']);
	unset($_SESSION['totalTime']);
	unset($_SESSION['filament_color']);

	session_unset();
	session_destroy();
}



?>