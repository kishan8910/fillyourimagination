<?php

session_start();
include "../../libcommon/conf.php";
include "../../libcommon/classes/db_mysql.php";

include "../../libcommon/db_inc.php";
include "../../libcommon/functions.php";


$user_files_id = trim(sql_real_escape_string($_POST['user_files_id']));

$reviewed_price = trim(sql_real_escape_string($_POST['reviewed_price']));

$reviewed_time = trim(sql_real_escape_string($_POST['reviewed_time']));


$query = "SELECT id FROM reviewed_estimation WHERE user_files_id = '$user_files_id'";

$result = sql_query($query,$connect);

if (sql_num_rows($result)) {
	$sql = "UPDATE reviewed_estimation SET reviewed_price = '$reviewed_price', reviewed_time = '$reviewed_time' WHERE user_files_id = '$user_files_id'";
}
else
{
	$sql = "INSERT INTO reviewed_estimation (user_files_id,reviewed_time,reviewed_price) VALUES ('$user_files_id','$reviewed_time','$reviewed_price')";
}


$res = sql_query($sql,$connect);

if (sql_error($res)) {
	echo "1";
}

?>