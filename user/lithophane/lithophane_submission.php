
<div class="container">
<div class="row">
<div class="col s6 offset-s4">
<?php

if ($_SERVER['REQUEST_METHOD'] == "POST")
{

	// print_r($_POST);
	// echo "<br>";
	// print_r($_FILES);

	$error_arr = array();

	$lithophane_models_id = $_POST['lithophane_models_id'];
	$file_title = $_POST['lithophane_model_filetitle'];
	$lithophane_model_price = $_POST['lithophane_model_price'];

	if(!isValid($lithophane_models_id))
    {   
        array_push($error_arr, "Error Occurred. Please try again");
    }

    foreach ($_POST[lithophane_models_addons] as $lithophane_addons_id) {
    	
    	$input_name = null;
    	if(!isValid($lithophane_addons_id))
	    {   
	        array_push($error_arr, "Error Occurred. Please try again");
	    }
	    $input_name = 'text_name'.$lithophane_models_id.$lithophane_addons_id;
	    
	    $text_input = $_POST[$input_name];

	    if (!isValid($text_input)) {
	    	array_push($error_arr, "Text input error.Try with different value!");	
	    }

	    $allowed_file_types =  array('jpg','png','JPG','PNG');
	    $input_name_file = 'image_name'.$lithophane_models_id.$lithophane_addons_id;

	    $file = $_FILES[$input_name_file];

	    if ($file) 
	    {
	    	if ((($file['type'] == 'image/png') || ($file['type'] == 'image/jpeg') || ($file['type'] == 'image/jpg')) && ($file['size'] < 2097152)) {
	    		// echo $file['type']."<br>".$file['size'];
		    }
		    else
		    {
		    	array_push($error_arr, "File Input Error!");
		    }	
	    }

	    

	    
    
    }

    if (!empty($error_arr)) {
    	
    	echo '
		  <div class="collection">';

		  	foreach ($error_arr as $error_msg) {
	    		
	    	echo '

	    		<div class="collection-item">
			  		
			  		<span><h5>'.$error_msg.'</h5></span>	
			  		
	          	</div>
	    	';

    		}
    		echo '

	    		<div class="collection-item">
			  		
			  		<a href="?u=lithophane&b=lithophane" class="collection-item"><span class="badge"></span>Try Again</a>
			  		
	          	</div>
	    	';

    	echo '</div>
    	
    	';
    }
    else
    {

    		$file_title = preg_replace('/\s+/', '', $file_title);
    		$query = "INSERT INTO user_files (user_id,file_title,infill,layerHeight,material,estimated_price,filament_color_id,lithophane_models_id) VALUES ('$_SESSION[user_id]','$file_title','30','0.237','PLA','$lithophane_model_price','1','$lithophane_models_id')";

    		$res = sql_query($query,$connect);

    		$user_files_id = mysql_insert_id();

    		if (sql_error($res)) {
	    			echo '

		    		<div class="collection-item">
				  		
				  		<span><h5>Error in saving data! Please try again.</h5></span>	
				  		
		          	</div>
		    	';

		    	echo '

	    		<div class="collection-item">
			  		
			  		<a href="?u=lithophane&b=lithophane" class="collection-item"><span class="badge"></span>Try Again</a>
			  		
	          	</div>
	    	';
    		}
    		else
    		{


		    	foreach ($_POST[lithophane_models_addons] as $lithophane_addons_id) {
		    	
			    	$input_name = null;
			    	
				    $input_name = 'text_name'.$lithophane_models_id.$lithophane_addons_id;
				    
				    $text_input = $_POST[$input_name];

				    if ($text_input) {

				    	$query = "INSERT INTO user_lithophane_inputs (user_files_id,lithophane_models_addons_id,path_or_text) VALUES ('$user_files_id','$lithophane_addons_id','$text_input')";
				    	sql_query($query,$connect);
				    
				    }

				    $input_name_file = 'image_name'.$lithophane_models_id.$lithophane_addons_id;

				    $file = $_FILES[$input_name_file];

				    if ($file) 
				    {
				    	$name =  basename($file['name']);
        				$file_path = 'user_lithophane_models/'.substr(md5(microtime(true)),0,16).$name;
        				if(move_uploaded_file($file['tmp_name'], $file_path))
        				{
        					$query = "INSERT INTO user_lithophane_inputs (user_files_id,lithophane_models_addons_id,path_or_text) VALUES ('$user_files_id','$lithophane_addons_id','$file_path')";
        					sql_query($query,$connect);
        				}
				    }
		    
		    }
		}
    }

}

?>

</div>
</div>
</div>
