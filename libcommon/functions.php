<?php
function input_error_reporting( $input_errors) {?>
	
<div style="width:59%; height:auto; margin: 15px 0 10px 0; border: 1px solid #09F;">	
<h3 style="margin-left:25px; text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;">Error(s)!!</h3>
<?	$count = 0;
	foreach( $input_errors as $error) {
		echo "<p style=\"margin:10px 0 10px 50px; text-align:left; color:#f00; font-family:Arial, Helvetica, sans-serif; font-size:12px;\">".++$count.") $error. </p>";
	}
?>
</div>	
<?
}


function success_messagetoconfirm($message)
{
	if($message)
	{
		echo "<h2 class=\"alert_success\" style=\"margin:50px auto; text-align:center;display:block;\">";					
		echo $message;
		echo "</h2>";
	}
	else
	{
		echo "<h2 class=\"alert_success\" style=\"margin:50px auto; text-align:center;display:block;\">";					
		echo "Added Successfully";
		echo "</h2>";
	}	 	
}


function input_error_reporting_feedback($input_errors) 
{
?>
<div style="width:59%; height:auto; margin: 15px 0 50px 0;">	
<h3 style="margin-left:25px; text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;">Error(s)!!</h3>
<?	
	$count = 0;
	foreach( $input_errors as $error) 
	{
		echo "<p style=\"margin:10px 0 10px 50px; text-align:left; color:#f00; font-family:Arial, Helvetica, sans-serif; font-size:12px;\">".++$count.") $error. </p>";
	}
	echo "</div>";	
}
?>

<?php
function input_error_reporting_library( $input_errors) {?>
	
<div style="width:600px; height:auto; margin: 15px 0 10px 0; border: 1px solid #09F;">	
<h3 style="margin-left:25px; text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;">Error(s)!!
</h3>
<?	$count = 0;
	foreach( $input_errors as $error) {
		echo "<p style=\"margin:10px 0 10px 50px; text-align:left; color:#f00; font-family:Arial, Helvetica, sans-serif; font-size:12px;\">".++$count.") $error. </p>";
	}
?>
</div>	
<?
}
?>
<?
function nextDay($date) 
{
        $arr = explode("-", $date);
        return date("Y-m-d",(mktime(0,0,0,$arr[1],$arr[2], $arr[0]) + (24*60*60)));
}
function nextNDay($date, $N, $incHoliday = true)
{
    $i = 0;
    while ($i<$N)
    {   
      $date = nextDay($date);
      $arr = explode("-", $date);
      $i++;
    }   
  return $date;
}
function staffIsAllowed($groupID, $menu, $action)
{   
        global $connect;
        global $l_error;

        if($action) $fileName = $menu;
        else  $fileName = $menu;

        $sql            = "SELECT * FROM library_privileges WHERE stafftypeID='$groupID' AND menuItems='$fileName'";
        $result = sql_query($sql, $connect);
        if(!sql_num_rows($result)) return 0;
	else 
		return 1;
}
function adminIsAllowed($groupID, $menu, $action)
{   
        global $connect;
        global $l_error;

        if($action) $fileName = $menu;
        else  $fileName = $menu;

        $sql  = "SELECT * FROM admin_privileges WHERE admintypeID='$groupID' AND menuItems='$fileName'";
        $result = sql_query($sql, $connect);
        if(!sql_num_rows($result)) return 0;
	else 
		return 1;
}


/*
   Page:           _drawrating.php
   Created:        Aug 2006
   Last Mod:       Oct 27 2009
   modfied by bstinthomas
   The function that draws the rating bar.
   --------------------------------------------------------- 
   ryan masuga, masugadesign.com
   ryan@masugadesign.com 
   Licensed under a Creative Commons Attribution 3.0 License.
   http://creativecommons.org/licenses/by/3.0/
   See readme.txt for full credit details.
   --------------------------------------------------------- */
function rating_bar($id,$units='',$userID='', $tableName='',$userType='') { 

	global $connect, $rating_unitwidth;
	//set some variables
	if (!$units) {$units = 10;}
	if (!$static) {$static = FALSE;}

	$sql = "select sum(rateValue), count(studentID) from $tableName where docID='$id'";
	$query=sql_query($sql,$connect);

	$numbers=sql_fetch_array($query);

	if ($numbers['count(studentID)'] < 1) {
		$count = 0;
	} else {
		$count = $numbers['count(studentID)']; //how many votes total
	}

	
	$current_rating	= $numbers['sum(rateValue)']; //total number of rating added together and stored
	$tense = ($count == 1) ? "vote" : "votes"; //plural form votes/vote

	$sql = "select $userType from $tableName where docID='$id' and $userType=$userID";
	$query=sql_query($sql, $connect);
	if(sql_num_rows($query) ) {
		$voted = 1;
	}
	else {
	
		$voted = 0;
	}
	$rating_width = @number_format($current_rating/$count,2)*$rating_unitwidth;
	$rating1 = @number_format($current_rating/$count,1);
	$rating2 = @number_format($current_rating/$count,2);
	if ($static == 'static') {

		$static_rater = array();
		$static_rater[] .= "\n".'<div class="ratingblock">';
		$static_rater[] .= '<div id="unit_long'.$id.'">';
		$static_rater[] .= '<ul id="unit_ul'.$id.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
		$static_rater[] .= '<li class="current-rating" style="width:'.$rating_width.'px;">Currently '.$rating2.'/'.$units.'</li>';
		$static_rater[] .= '</ul>';
		$static_rater[] .= '<p class="static">Rating: <strong> '.$rating1.'</strong>/'.$units.' ('.$count.' '.$tense.' cast) <em>This is \'static\'.</em></p>';
		$static_rater[] .= '</div>';
		$static_rater[] .= '</div>'."\n\n";

		return join("\n", $static_rater);


	} else {

		$rater ='';
		$rater.='<div class="ratingblock">';

		$rater.='<div id="unit_long">';
		$rater.='  <ul id="unit_ul'.$id.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
		$rater.='     <li class="current-rating" style="width:'.$rating_width.'px;">Currently'.$rating2.'/'.$units.'</li>';

		for ($ncount = 1; $ncount <= $units; $ncount++) { // loop from 1 to the number of units
				$rater.='<li><a onClick="rateAction(\'j='.$ncount.'&amp;q='.$id.'&amp;t='.$userID.'&amp;c='.$units.'&table='.$tableName.'&type='.$userType.'\')" title="'.$ncount.' out of '.$units.'" class="r'.$ncount.'-unit rater" rel="nofollow">'.$ncount.'</a></li>';
		}
		$ncount=0; // resets the count

		$rater.='  </ul>';
		$rater.='  <p';
		$rater.='>Rating: <strong> '.$rating1.'</strong>/'.$units.' ('.$count.' '.$tense.' cast)';
		$rater.='  </p>';
		$rater.='</div>';
		$rater.='</div>';
		return $rater;
	}
}

function write_php_ini($array, $file)
{
    $res = array();
    foreach($array as $key => $val)
    {
        if(is_array($val))
        {   
            $res[] = "[$key]";
            foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }   
        else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
    }   
    safefilerewrite($file, implode("\r\n", $res));
}
function safefilerewrite($fileName, $dataToSave)
{    if ($fp = fopen($fileName, 'w'))
    {   
        $startTime = microtime();
        do  
        {            $canWrite = flock($fp, LOCK_EX);
           // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
           if(!$canWrite) usleep(round(rand(0, 100)*1000));
        } while ((!$canWrite)and((microtime()-$startTime) < 1000));

        //file was locked so now we can store information
        if ($canWrite)
        {            fwrite($fp, $dataToSave);
            flock($fp, LOCK_UN);
        }   
        fclose($fp);
    }
}
function isEmail($email){
  return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

function isName($name){
  return preg_match('/^([\w\d\s\&\-\_\+\.\:\|]+)$/iU', $name) ? TRUE : FALSE;
}

function assignmentView($batchID,$subjectID,$staffID, $assignmentID='') {

	global $connect;
	if($assignmentID) {
		
		$sql = "select assignmentID, question, description, submissionDate, submissionTime,assiNu,docPath from batch_assigment where assignmentID=$assignmentID order by assignmentID DESC";
	}
	else {
		$sql = "select assignmentID, question, description, submissionDate, submissionTime,assiNu,docPath from batch_assigment where batchID=$batchID AND subjectID=$subjectID AND staffID=".$_SESSION['staffID']." order by assignmentID DESC";
	}
	$result = sql_query($sql, $connect);
	if(sql_num_rows($result))
	{
	while($row = sql_fetch_row($result)) {
?>

<div id="div<?=$row[0]?>">
	<table class="assign_tab" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td colspan="2" id="head">
				Assignment you given
			</td>
		</tr>
        <tr>
			<td id="left">
				Question: 		
			</td>
			<td id="right">
			 	<?= nl2br($row[1])?>&nbsp;		
			</td>
		</tr>
        <tr>
			<td id="left">
				Assignment number: 		
			</td>
			<td id="right">
			 	<?=$row[5]?>&nbsp;		
			</td>
		</tr>
		<tr>
			<td id="left">
				Description: 		
			</td>
			<td id="right">
			 	<?= nl2br($row[2])?>&nbsp; 		
			</td>
		</tr>
		<tr>
			<td id="left">
				Attachment: 		
			</td>
			<td id="right">
		<?
			if($row[6] != '') {
				echo "<a href='".$row[6]."' target=\"_blank\"><button class=\"nodoc_down\">Download</button></a> ";
			}
			else
				echo "Nill";
		?>
			</td>
		</tr>
        <tr>
			<td id="left">
				Date: 		
			</td>
			<td id="right">
			 	<?=$row[3]?>&nbsp; 		
			</td>
		</tr>
        <tr>
			<td id="left">
				Time: 		
			</td>
			<td id="right">
			 	<?=$row[4]?>&nbsp; 		
			</td>
		</tr>
		<tr>
			<th colspan='2' id="head">
				<input name="upload" type="submit" class="box" id="upload" value="Delete" onclick="deleteassignment('ajax_delete_assinments.php', 'batchID=<?=$batchID?>&subjectID=<?=$subjectID?>&staffID=<?=$_SESSION['staffID']?>&assignmentID=<?=$row[0]?>')">
				<input name="upload" type="submit" class="box" id="upload" value="Edit" onclick="editassignment('ajax_edit_assinments.php', 'batchID=<?=$batchID?>&subjectID=<?=$subjectID?>&staffID=<?=$_SESSION['staffID']?>&assignmentID=<?=$row[0]?>', 'div'+'<?=$row[0]?>')">
			</th>
		</tr>
	</table>
  </div>
<?
	}
	}else
	{
		echo "<br /><br /><br /><span style=\"margin-top:20px; color:#f00; font-size:14px\">Sorry! there is no records.</span>";	
	}

}
function markListView($batchID, $subjectID, $examID, $action) {

	global $connect;
	if( $examID ) {
		echo "<table class=\"assign_tab\"  cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
		echo "<tr>";
		echo "<td id=\"left\">ExamName: </td>";
		echo "<td>";
		echo "$examName";
		echo "</td>";
		echo "</tr>";
		$sql = "select markID from student_marks where batchID=$batchID and subjectID=$subjectID  and examID=$examID";
		$result = sql_query($sql, $connect);
		if( !sql_num_rows($result)) {
		
			$sql = "select t1.studentID, t1.studentAccount from  studentaccount t1 where t1.batchID=$batchID";
		}
		else {
			$sql = "select t2.studentID, t2.studentAccount,t1.markID, t1.marksObtained, t1.studentID from student_marks t1, studentaccount t2 where t1.studentID=t2.studentID and t1.batchID=$batchID and t1.subjectID=$subjectID and examID=$examID";
			echo "<input type=\"hidden\" value=\"1\" name=\"edit\">";
		}
		$result = sql_query($sql, $connect);
		while($row = sql_fetch_row($result)) {
		
		        $studentID = $row[0];
		        echo "<tr>";
		        echo "<td id=\"left\">".$row[1].": </td>";
		        echo "<td id=\"right\">$row[3]</td>";
		        echo "</tr>";
		
		}
		echo "</table>";
		?>
	<?
    }
	else {
		echo "No exam assign for this test";
	}
}
function no_fo_subjects_in_ass($assNo,$batchID,$semID) {

        global $connect;
        $sql = "select count(distinct(subjectID)) from assinment_marks where batchID=$batchID and semID=$semID and assiNu=\"$assNo\"";
        $result = sql_query($sql, $connect);
        $row = sql_fetch_row($result);
        return $row[0];
}

//Functions for library section//

function get_menuhead($userType) // For leftside menu in library
{
	global $connect;
    global $l_error;
	global $GroupPrivileges;
	$userPrivileges = $GroupPrivileges;
	if(is_array($userPrivileges))
	{
		foreach($userPrivileges as $item)	
		{						
			$sql = "SELECT menuItems FROM library_privileges WHERE stafftypeID='$userType' AND menuItems='$item'";
			$result = sql_query($sql, $connect);
			while($row = sql_fetch_array($result))
			{
				$data_db[] = $row[0]; 
			}
		}
	}
	return $data_db;
}

function calculating_studentreturndate($ret_date, $deptID, $batchID)
{
                        global $connect;
    
                        $sql ="select holiday from library_studentcalendar where deptID = ".$deptID." AND batchID = ".$batchID." AND holiday >=\"".$ret_date."\" ORDER BY holiday";     
                        $result = sql_query($sql, $connect);
                        $b=0;
                        while($row = sql_fetch_row($result)) 
                        {
                                if($row[0] == $ret_date)
                                {    
                                        $ret_date = nextNDay($ret_date, 1); 
                                        $b++;
                                        //echo $date;
                                }
                                else if($b!=0)
                                {
                                        break;
                                }
                        }
                        $find_holiday['ret_date'] = $ret_date;
                        $find_holiday['count_day'] = $b; 
                        return $find_holiday;
}

function calculating_staffreturndate($ret_date, $deptID)
{
                        global $connect;
    
                        $sql ="select holiday from library_staffcalendar where deptID = ".$deptID." AND holiday >=\"".$ret_date."\" ORDER BY holiday";  
                        $result = sql_query($sql, $connect);
                        $b=0;
                        while($row = sql_fetch_row($result))
                        {
                                if($row[0] == $ret_date)
                                {
                                        $ret_date = nextNDay($ret_date, 1);
                                        $b++;
                                        //echo $date;
                                }
                                else if($b!=0)
                                {
                                        break;
                                }
                        }
                        $find_holiday['ret_date'] = $ret_date;
                        $find_holiday['count_day'] = $b;
                        return $find_holiday;
}
function revers_dateformat($date) {

	$date = preg_split("/[\-]/", $date);
	
	$day = $date[2];
	$month = $date[1];
	$year = $date[0];
	return "$day-$month-$year";
}

function getDesignation($isStaff, $isHOD, $isPrincipal)
{
	if($isStaff == 1) 
	{		
       	return "Faculty";
   }   
   if($isStaff == 2) 
   {
       	return "Others";
   }   
   if($isHOD == 1) 
   {
       	return "HOD";
   }   
   if($isHOD == 2) 
   {
       	return "HOD In Charge";
   }   
   if($isPrincipal == 1) 
   {
			return "Principal";
   }
   if($isPrincipal == 2) 
   {
			return "Vice Principal";
   }
   if($isPrincipal == 3) 
   {
			return "Assistant Manager";
   }
}


function assign_rand_value($num)
{
// accepts 1 - 36
  switch($num)
  {
    case "1":
     $rand_value = "A";
    break;
    case "2":
     $rand_value = "B";
    break;
    case "3":
     $rand_value = "C";
    break;
    case "4":
     $rand_value = "D";
    break;
    case "5":
     $rand_value = "E";
    break;
    case "6":
     $rand_value = "F";
    break;
    case "7":
     $rand_value = "G";
    break;
    case "8":
     $rand_value = "H";
    break;
    case "9":
     $rand_value = "B";
    break;
    case "10":
     $rand_value = "J";
    break;
    case "11":
     $rand_value = "K";
    break;
    case "12":
     $rand_value = "L";
    break;
    case "13":
     $rand_value = "M";
    break;
    case "14":
     $rand_value = "N";
    break;
    case "15":
     $rand_value = "A";
    break;
    case "16":
     $rand_value = "P";
    break;
    case "17":
     $rand_value = "Q";
    break;
    case "18":
     $rand_value = "R";
    break;
    case "19":
     $rand_value = "S";
    break;
    case "20":
     $rand_value = "T";
    break;
    case "21":
     $rand_value = "U";
    break;
    case "22":
     $rand_value = "V";
    break;
    case "23":
     $rand_value = "W";
    break;
    case "24":
     $rand_value = "X";
    break;
    case "25":
     $rand_value = "Y";
    break;
    case "26":
     $rand_value = "Z";
    break;
    case "27":
     $rand_value = "0";
    break;
    case "28":
     $rand_value = "1";
    break;
    case "29":
     $rand_value = "2";
    break;
    case "30":
     $rand_value = "3";
    break;
    case "31":
     $rand_value = "4";
    break;
    case "32":
     $rand_value = "5";
    break;
    case "33":
     $rand_value = "6";
    break;
    case "34":
     $rand_value = "7";
    break;
    case "35":
     $rand_value = "8";
    break;
    case "36":
     $rand_value = "9";
    break;
  }
return $rand_value;
}


function get_rand_id($length)
{
  if($length>0)
  {
    $rand_id="";
    for($i=1; $i<=$length; $i++)
    {
        mt_srand((double)microtime() * 1000000);
        $num = mt_rand(1,36);
        $rand_id .= assign_rand_value($num);
    }
  }
return $rand_id;
}

/*
 *  Xpress SMS provider


function sendSMS($phonNo, $msg) 
{
	global $SMS_USERNAME, $SMS_PASSWORD, $SMS_DOMAIN, $SMS_FROM;
	$request =""; //initialise the request variable
	
	$param[username] = $SMS_USERNAME;
	$param[api_password] = $SMS_PASSWORD;
	$param[to] = $phonNo;
	$param[priority] = 2;
	$param[sender] = $SMS_FROM;
	$param[message] = $msg;
	//Have to URL encode the values
	
	foreach($param as $key=>$val) 
	{
       $request.= $key."=".urlencode($val);
       //we have to urlencode the values
       
       $request.= "&";
       //append the ampersand (&) sign after each parameter/value pair
	
	}
	$request = substr($request, 0, strlen($request)-1);
	//remove final (&) sign from the request
	
	$url = "$SMS_DOMAIN".$request;
	echo "$url";
	
	$fp = fopen($url, "r", false);
	$response = @stream_get_contents($fp);
	$tmp = explode("|",$response);
	//echo "$tmp[0]";
	
	fpassthru($fp);
	fclose($fp);
	return trim($tmp[0]);
}
 */

function sendSMS($phonNo, $msg) 
{
	global $SMS_USERNAME, $SMS_PASSWORD, $SMS_DOMAIN, $SMS_FROM;
	
	define('TYPE_NORMAL','1');
	define('ROUTE_TRANSACTIONAL','2');
	
    $login_name=$SMS_USERNAME;
    $api_password=$SMS_PASSWORD;
    $ver='1';
    
    $url= $SMS_DOMAIN.'ver='.$ver;
    $url.='&login_name='.$login_name;
    $url.='&api_password='.$api_password;
    
    $action='push_sms';
    
    $data=array(
       
        'message'=>$msg,
        'number'=>$phonNo,
		'type' => TYPE_NORMAL,
		'route' => ROUTE_TRANSACTIONAL,
		'sender' => 'AISATk'

    );
    
    $url.='&action='.$action;
    $json_data= urlencode(json_encode($data));
    $url.='&data='.$json_data;
   
    $result=  @file_get_contents($url);
    if($result === FALSE) 
    {
		echo "<h3 style=\"color:red; font-size:12px;\">Failed to deliver SMS to ".$phonNo.".</h3>";
	}
    else
    {
		return 1;
	}
}

function sendEmail($msgSubject,$msgBody,$addAddressFlag,$to)
	{
		include "phpmailer/class.phpmailer.php";
		$mail = new PHPMailer();
		$mail->SetLanguage("en", 'mailer/language/');

		$mail->IsSMTP();   
		$mail->SMTPSecure = "ssl";                                     // set mailer to use SMTP
		$mail->Host = "smtp.gmail.com";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "fillyourimagination@gmail.com";  // SMTP username
		$mail->Password = "kishan8910"; // SMTP password
		$mail->Port = 465;

		$mail->From = "";
		$mail->FromName = $name;

		if ($addAddressFlag == 1) 
		{
			
			$mail->AddAddress('infillcube@gmail.com',$to);
		}
		else
		{
			$mail->AddAddress($to,"");
			$mail->AddAddress("infillcube@gmail.com");
		}
		
		                 // name is optional
		$mail->AddReplyTo("info@infillcube.com", "Information");
		$mail->SetFrom('info@infillcube.com', 'Infillcube');
		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $msgSubject;
		$mail->Body    = $msgBody;
		$mail->AltBody = $msgBody;

		if(!$mail->Send())
		{
		   echo "Message could not be sent. <p>";
		   echo "Mailer Error: " . $mail->ErrorInfo;
		   exit;
		}
		else
		{
			return 1;
		}
		$mail->ClearAddresses();	
	}

	function isValid($input_text)
	{
		if( !preg_match( "/^[A-Za-z0-9\s.\-\/]{0,30}$/", $input_text))
        {   
            return false;
        }
        else
        {
        	return true;
        }
	}

?>

