<?
// session_start();
include "../libcommon/conf.php";
include "../libcommon/classes/db_mysql.php";
include "../libcommon/functions.php";
include "../libcommon/db_inc.php";

include "header.php";
?>
<script src="../libcommon/javascripts/jquery.badBrowser.js" type="text/javascript"></script>
<body>

  <header id="header">
    <hgroup>
      <h1 class="site_title"><a href="#"></a></h1>         
    </hgroup>
  </header> <!-- end of header bar -->  
  
  <!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>

    <body>

<div class="container">
    <div class="row">
        <div class="col s3"></div>
        <div class="col s6">
          <div class="card grey lighten-3 z-depth-5" style="padding: 15px;">
            
            <div class="card-content black-text">
              <span class="card-title center">Choose your option</span>
            </div>
            
            <span class="card-action">
                <a href="index_login.php"><button type='button' name='btn_login' class='btn waves-effect teal lighten-1'>Login</button></a>
            </span>
           
            <span class="card-action">
               <a href="api-caller.php"><button type='button' name='btn_login' class='btn waves-effect teal lighten-1'>Estimate</button></a>
            </span>
 
          </div>
        </div>
        <div class="col s3"></div>
      </div>
</div>

</body>

    
</html>
  
<?php
include "../libcommon/db_close.php";
?>