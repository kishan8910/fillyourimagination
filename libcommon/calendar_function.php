
<?
function showMonth($month, $year)
{
    global $connect;
    $sql = "select timestart from lms_calender where (deptID=\"$deptID\" or deptID=0)";
    $result = sql_query($sql, $connect);
    $row = sql_fetch_row($result);
    $date = mktime(12, 0, 0, $month, 1, $year);
    $daysInMonth = date("t", $date);
    // calculate the position of the first day in the calendar (sunday = 1st column, etc)
    $offset = date("w", $date);
    $rows = 1;


    /* navigate between months */
    $tmp_next_month =  mktime(0,0,0,$month+1,1,$year);
    $next_month =  date("m", $tmp_next_month);
    $next_year =  date("Y", $tmp_next_month);
    $tmp_prev_month = mktime(0,0,0,$month-1,1,$year);
    $prev_month = date("m", $tmp_prev_month);
    $prev_year = date("Y", $tmp_prev_month);
	
    /********************************************************/

    echo "<table class=\"maincalendar\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";   
    echo "<tr><th colspan=\"7\">
		  
		  <span class=\"leftarr\">
	      <a href=\"#\" onClick=\"change_month($prev_month,$prev_year,'calendar','ajax_change_month.php'); return false;\">
		  <img src=\"../libcommon/images/common/spacer.png\" style=\"width:25px; height:16px; display:block;\" border=\"0\" />
		  </a>
		  </span>
		  
		  <span class=\"calendarHead\">".date("F Y", $date)."</span>
		  
		  <span class=\"rightarr\">
	      <a href=\"#\" onClick=\"change_month($next_month,$next_year,'calendar','ajax_change_month.php'); return false;\">
		  <img src=\"../libcommon/images/common/spacer.png\" style=\"width:25px; height:16px; display:block;\" border=\"0\" />
		  </a>
		  </span>
		  
		  </th></tr>";
    echo "\t<tr><td>Su</td><td>Mo</td><td>Tu</td><td>We</td><td>Th</td><td>Fr</td><td>Sa</td></tr>";
    echo "\n\t<tr>";

    for($i = 1; $i <= $offset; $i++)
    {
        echo "<td></td>";
    }
    for($day = 1; $day <= $daysInMonth; $day++)
    {
        if( ($day + $offset - 1) % 7 == 0 && $day != 1)
        {
            echo "</tr>\n\t<tr>";
            $rows++;
       	    echo "<td id=\"holi\">" . $day . "</td>"; //for holidays
        }
	else {
     
   	     echo "<td>" . $day . "</td>";
	}
		
		//echo "<td id=\"holi\">" . $day . "</td>"; //for holidays
    }
    while( ($day + $offset) <= $rows * 7)
    {
        echo "<td></td>";
        $day++;
    }
    echo "</tr>\n";
    echo "</table>\n"; 
}
?>
