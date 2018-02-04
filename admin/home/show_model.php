<script type="text/javascript">
    
function saveReview(user_files_id)
{
    var reviewed_price = $("#reviewed_price"+user_files_id).val();
    var reviewed_time = $("#reviewed_time"+user_files_id).val();
    var data = "user_files_id="+user_files_id+"&reviewed_price="+reviewed_price+"&reviewed_time="+reviewed_time;
    if (reviewed_time == "" || reviewed_price == "") 
    {
        Materialize.toast('Error occurred ! Please enter both price and time ', 3000,'');
    }
    else
    {
        $.ajax({
                type: "POST",
                url: "home/ajax_save_review.php",
                data: data,
                success: function(response)
                {
                    if (response == 1) 
                    {
     
                        Materialize.toast('Error occurred ! Please try again', 1000,'');
                    }
                    else
                    {
                        Materialize.toast('Saved Successfully !', 1000,'');
                    }
                }
              });  
        return false;
    }
}

</script>


<?

$sql = "SELECT uf.id,uf.user_id,uf.filepath,uf.file_title,uf.infill,uf.layerHeight,uf.material,uf.filamentUsed,uf.totalTime,u.name,re.reviewed_time,re.reviewed_price,uf.lithophane_models_id,fc.color FROM user_files uf inner join user u on u.id = uf.user_id inner join filament_color fc on fc.id = uf.filament_color_id left join reviewed_estimation re on re.user_files_id = uf.id where user_id = '$_GET[user_id]'";
    
        $result = sql_query($sql, $connect);
        if(sql_num_rows($result))
        {

            $username = sql_fetch_array($result)[name];

echo "
<div class='container'><div class='row'><div class='col s12 offset-s1'><table class='bordered' width='100%'>
                <tr>
                <th colspan='11' style='text-align:center;'>User : ".$username."</th>
                </tr>
                <tr>
                <th>Sl.No</th>
                <th>File</th>
                <th>Color</th> 
                <th>Infill</th>
                <th>Layer Height</th>
                <th>Material</th>
                <th>Filament Used</th>
                <th>Estimated Time</th>
                <th>Reviewed Price</th>
                <th>Reviewed Time</th>
                <th>Save</th>
                <th>Download</th>
            </tr>";
            mysql_data_seek($result, 0);
            while($row = sql_fetch_array($result))
            {
                $user_files_id = $row['id'];
                $lithophane_models_id = $row['lithophane_models_id'];
                echo "<tr align=\"center\" class=\"\" id=\"\">
                <td>".(++$start)."</td>
                <td>".$row['file_title']."</td>
                <td>".$row['color']."</td>
                <td>".$row['infill']." %</td>
                <td>".$row['layerHeight']." mm</td>
                <td>".$row['material']."</td>
                <td>".$row['filamentUsed']." gms</td>
                <td>".$row['totalTime']." seconds</td>

                <td><input type='text' value='".$row[reviewed_price]."' id='reviewed_price".$user_files_id."'></td>
                <td><input type='text' value='".$row[reviewed_time]."' id='reviewed_time".$user_files_id."'></td>

                <td>";               
                    echo "<input type='button' class='btn' value='Save' onclick=\"saveReview('".$user_files_id."');\" >";
                echo "</td>
                <td>";
                    if ($lithophane_models_id) 
                    {
                        echo "<a href='?u=home&b=lithophane_details&user_files_id=".$user_files_id."'><input type='button' class='btn' value='Show' ></a>";
                    }
                    else
                    {
                        echo "<a href='../user/".$row[filepath]."'><input type='button' class='btn' value='Download' ></a>";
                    }
                    
                    
                echo "</td>
                 </tr>";
            }
            echo"</table>";
        }
        else
        {
            echo "<div class='container'><div class='row'><div class='col s10 offset-s2'><h4 style=\"text-align:center; margin:5% 5%; color:#F00;\">No Users Found</h4></div></div></div>";
        }

    

    ?>