<?
session_start();
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
  <?php
    // echo "<form action='' method='post'>";
    include "login.php";
    // echo "</form>";

  ?>
  
</body>
</html>
<?php
include "../libcommon/db_close.php";
?>