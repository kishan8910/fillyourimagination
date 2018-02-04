<?

$sql = "SELECT * FROM user where userType = 'customer'";
    
        $result = sql_query($sql, $connect);
        if(sql_num_rows($result))
        {

echo "
<div class='container'><div class='row'><div class='col s12 offset-s1'><table class='bordered' width='100%'>
                <tr>
                <th>Sl.No</th>
                <th>User Name</th>   
                <th>User Email</th>
                <th>User Mobile</th>
                <th>User Address</th>
                <th>User Pincode</th>
                <th>Show Models</th>
                
            </tr>";
            while($row = sql_fetch_array($result))
            {
                $user_id = $row['id'];
                echo "<tr align=\"center\" class=\"\" id=\"\">
                <td>".(++$start)."</td>
                <td>".$row['name']."</td>
                <td>".$row['email']."</td>
                <td>".$row['mobile']."</td>
                <td>".$row['address']."</td>
                <td>".$row['pincode']."</td>
                <td>";

                        echo "<a href='?u=home&b=show_model&user_id=".$user_id."'><input type='button' class='btn-floating' value='M'></a>";

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