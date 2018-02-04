
<style type="text/css">
    
    .card-small {
        width: 400px;
    }

</style>


<div class="container">
<div class="row">
<div class="col s6 offset-s4">
            <blockquote>
                <h5>Select Model</h5>
            </blockquote>

<?php

    $query = "SELECT * FROM lithophane_models";

    $result = sql_query($query,$connect);

    if (sql_num_rows($result)) {
      while ($row = sql_fetch_array($result)) 
      {

        $lithophane_models_id = $row[id];
        $is_image = $row[is_image];
        $is_frame = $row[is_frame];
        $is_text  = $row[is_text];


        // echo "<form id='form_id".$lithophane_models_id."' action='?u=lithophane&b=lithophane_submission' >";

        echo '
             <div class="card">
              <div class="card-image">
                <img src="'.$row[filepath].'">
                
                <a href="?u=lithophane&b=lithophane_details&id='.$lithophane_models_id.'" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
              </div>
              <div class="card-content">
                <span class="card-title">'.$row[filetitle].'</span>
              <p>
                  
              </p>
            </div>';

            /*if ($is_frame == 1) 
            {
              $sql = "SELECT * FROM lithophane_models_addons WHERE lithophane_models_id = '$lithophane_models_id' AND is_image = 1";
              $res = sql_query($sql,$connect);
              if (sql_num_rows($res)) {

                echo '<div class="card-tabs">
                  <ul class="tabs tabs-fixed-width">';

                while ($row_addon = sql_fetch_array($res)) {
                  
                  echo '
                    <li class="tab addons'.$row[id].'" >


                      
                          <input type="radio" name="lithophane'.$row[id].'" id="lithophane_'.$row[id].$row_addon[id].'" value="'.$row_addon[id].'">
                          <a href="#'.$row_addon[id].'"><label for="lithophane_'.$row[id].$row_addon[id].'" >'.$row_addon[title].'</label></a>
                     

                    </li>
                    
                    ';
                  
                }
                echo '
               
                </ul>
                  </div>';
                  mysql_data_seek($res, 0);
                  echo '
                      <div class="card-content grey lighten-4">';

                        while ($row_addon = sql_fetch_array($res)) {


                          echo '<div id="'.$row_addon[id].'"><img src="'.$row_addon[filepath].'"></div>';

                       
                        }
                        
                      echo '</div>
                  ';
              }
            }
            if ($is_text == 1) {
              
              $sql = "SELECT * FROM lithophane_models_addons WHERE lithophane_models_id = '$lithophane_models_id' AND (is_text = 1 OR is_image = 1)";
              $res = sql_query($sql,$connect);
              if (sql_num_rows($res)) {

              echo '<div>';

                while ($row_addon = sql_fetch_array($res)) {
                  $is_image_addon = $row_addon[is_image];
                  $is_text_addon = $row_addon[is_text];
                  
                  if ($is_text_addon == 1) {
                      echo '
                        <div class="card">
                        <div class="card-image">
                         
                        </div>
                        <div class="card-content">
                        
                        <p>
                            <i class="material-icons prefix"></i>
                            <input type="text" id="text_id'.$row[id].$row_addon[id].'" placeholder="'.$row_addon[title].'" name="text_name'.$row[id].$row_addon[id].'" >
                            <label for="icon_prefix">'.$row_addon[title].'</label>    
                        </p>
                      </div></div>
                      ';
                      echo '
                      
                      
                    
                    ';  
                  }
                  
                  if ($is_image_addon == 1) {
                      echo '<div class="file-field input-field">
                      <div class="btn">
                        <span>'.$row_addon[title].'</span>
                        <span id="fileUploadElements"><input type="file" id="image_id'.$row[id].$row_addon[id].'" name="image_name'.$row[id].$row_addon[id].'" ></span>
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                      </div>
                    </div>';
                  }
                  
                }
                echo "</div>";
              }
            }
            if ($is_image == 1) {

                    $sql = "SELECT * FROM lithophane_models_addons WHERE lithophane_models_id = '$lithophane_models_id' AND  is_image = 1";
                  $res = sql_query($sql,$connect);
                  if (sql_num_rows($res)) {

                 

                    while ($row_addon = sql_fetch_array($res)) {

                        // $is_image_addon = $row_addon[is_image];
                        // $is_text_addon = $row_addon[is_text];

                         echo '<div class="file-field input-field">
                      <div class="btn">
                        <span>'.$row_addon[title].'</span>
                        <span id="fileUploadElements"><input type="file" id="image_id'.$row[id].$row_addon[id].'" name="image_name'.$row[id].$row_addon[id].'" ></span>
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                      </div>
                    </div>';
                    }

                }

            }

            echo '
            <div>
                  <input type="submit" class="btn" value="Save">          
            </div>
            </div>
        ';
        echo "</form>";*/

        echo "</div>";

      }
      
    }

?>

           
</div>
</div>
</div>

