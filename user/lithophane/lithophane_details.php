<div class="container">
<div class="row">
<div class="col s8 offset-s3">


<?php
	$lithophane_models_id = $_GET[id];

    $query = "SELECT * FROM lithophane_models WHERE id = '$lithophane_models_id'";

    $result = sql_query($query,$connect);

    if (sql_num_rows($result)) {
      while ($row = sql_fetch_array($result)) 
      {

        $lithophane_models_id = $row[id];
        $is_image = $row[is_image];
        $is_frame = $row[is_frame];
        $is_text  = $row[is_text];
        $lithophane_model_filetitle = $row[filetitle];
        $lithophane_model_price = $row[lithophane_model_price];


        echo "<form method='POST' id='form_id".$lithophane_models_id."' action='?u=lithophane&b=lithophane_submission' enctype='multipart/form-data' >";

        echo "<input type='hidden' value='$lithophane_models_id' name='lithophane_models_id'>

        <input type='hidden' value='$lithophane_model_filetitle' name='lithophane_model_filetitle'>
        	<input type='hidden' value='$lithophane_model_price' name='lithophane_model_price'>
        ";

        echo '
             <div class="card card-small">
              <div class="card-image">
                <img src="'.$row[filepath].'">
          
              </div>
               <div class="card-content">
              <span class="card-title">'.$row[filetitle].'</span>
              <p>
                  '.$row[filedescription].'
              </p>
            </div>
             ';

            if ($is_frame == 1) 
            {
              $sql = "SELECT * FROM lithophane_models_addons WHERE lithophane_models_id = '$lithophane_models_id' AND is_image = 1";
              $res = sql_query($sql,$connect);
              if (sql_num_rows($res)) {

                echo '<div class="card-tabs">
                  <ul class="tabs tabs-fixed-width">';

                while ($row_addon = sql_fetch_array($res)) {
                  	
                  	$lithophane_addons_id = $row_addon[id];
                	echo "<input type='hidden' value='$lithophane_addons_id' name='lithophane_models_addons[]' >";

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
                  
                  $lithophane_addons_id = $row_addon[id];
                	echo "<input type='hidden' value='$lithophane_addons_id' name='lithophane_models_addons[]' >";

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
                        <span id="fileUploadElements'.$row[id].$row_addon[id].'"><input type="file" id="image_id'.$row[id].$row_addon[id].'" name="image_name'.$row[id].$row_addon[id].'" ></span>
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


                    	$lithophane_addons_id = $row_addon[id];
                	echo "<input type='hidden' value='$lithophane_addons_id' name='lithophane_models_addons[]' >";

                        // $is_image_addon = $row_addon[is_image];
                        // $is_text_addon = $row_addon[is_text];

                         echo '<div class="file-field input-field">
		                      <div class="btn">
		                        <span>'.$row_addon[title].'</span>
		                        <span id="fileUploadElements'.$row[id].$row_addon[id].'"><input type="file" id="image_id'.$row[id].$row_addon[id].'" name="image_name'.$row[id].$row_addon[id].'" ></span>
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
        echo "</form>";
      }
      echo "</div>";
    }

?>


</div>
</div>
</div>