<?php
    
    $user_files_id = $_GET['user_files_id'];

    $query = "select uf.file_title,uf.material,uli.path_or_text,lma.title,lma.is_image,lma.is_text from user_files uf inner join user_lithophane_inputs uli on uli.user_files_id = uf.id inner join lithophane_models_addons lma on lma.id = uli.lithophane_models_addons_id where uf.id = '$user_files_id'";


?>