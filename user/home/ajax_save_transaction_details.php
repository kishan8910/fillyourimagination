<?

	session_start();
include "../../libcommon/conf.php";
include "../../libcommon/classes/db_mysql.php";

include "../../libcommon/db_inc.php";
include "../../libcommon/functions.php";

$user_files = trim(sql_real_escape_string($_POST['user_files']));
$txnid = trim(sql_real_escape_string($_POST['txnid']));
$amount = trim(sql_real_escape_string($_POST['amount']));
$user_id = $_SESSION['user_id'];

$query = "INSERT INTO user_model_online_payment (user_files_id,txnID,status,amount,user_id) VALUES ('$user_files','$txnid','pending','$amount','$_SESSION[user_id]')";

$res = sql_query($query,$connect);

if (sql_error($res)) {
	echo "1";
}
else
{
	echo "0";
}

?>