<?

session_start();
include "../../libcommon/conf.php";
include "../../libcommon/classes/sql.cls.php";
include "../../libcommon/classes/db_mysql.php";
include "../../libcommon/db_inc.php";
//include "../../session.php";
include "../../libcommon/functions.php";

 $old_password = trim(sql_real_escape_string($_POST["old_password"]));
 $new_password = trim(sql_real_escape_string($_POST["new_password"]));
$confirm_new_password = trim(sql_real_escape_string($_POST["confirm_new_password"]));

$query = "SELECT password FROM user WHERE id = '$_SESSION[user_id]'";
$result = sql_query($query,$connect);

$existing_password = sql_fetch_array($result)[0];	

if (($new_password == $confirm_new_password) && (md5($old_password) == $existing_password)) {

	$password = md5($confirm_new_password);
	$query = "UPDATE user SET password = '".$password."' where id = ".$_SESSION['user_id'];	
	sql_query($query,$connect);

}
else
{
	echo "1";
}







 ?>