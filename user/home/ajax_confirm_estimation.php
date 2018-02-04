<?

	session_start();
include "../../libcommon/conf.php";
include "../../libcommon/classes/db_mysql.php";

include "../../libcommon/db_inc.php";
include "../../libcommon/functions.php";


$layerHeight = $_SESSION[layerHeight] + 0.05;

$query = "INSERT INTO user_files (user_id,filepath,file_title,infill,layerHeight,material,filamentUsed,totalTime,estimated_price,filament_color_id) VALUES ($_SESSION[user_id],'$_SESSION[file_path]','$_SESSION[file_title]','$_SESSION[infillPercentage]','$layerHeight','$_SESSION[material]',$_SESSION[filamentUsed],$_SESSION[totalTime],$_SESSION[estimated_price],$_SESSION[filament_color])";

        $result = sql_query($query,$connect);
        if(sql_error($result))
        	{
        		echo "1";
        	}
        	else
        	{
        		$query = "SELECT email,name FROM user WHERE id = '$_SESSION[user_id]'";
        		$res = sql_query($query,$connect);
        		$detail = sql_fetch_array($res);
        		$name = $detail[name];
        		$email = $detail[email];
        		$msgBody = "
        		Dear ".$name.",<br> Your 3d model is successfully uploaded and infillcube is very happy to review your order and confirm the estimation process as quickly as possible. Check your email and infillcube web login for further updations.
        		";

        		sendEmail('Estimation Processed Successfully',$msgBody,0,$email);
        	}
        	unset($_SESSION['file_path']);
				unset($_SESSION['infillPercentage']);
				unset($_SESSION['layerHeight']);
				unset($_SESSION['filamentUsed']);
				unset($_SESSION['totalTime']);
				unset($_SESSION['estimated_price']);
				unset($_SESSION['material']);
				unset($_SESSION['file_title']);
                                unset($_SESSION['filament_color']);



?>