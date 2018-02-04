<?php

session_start();
include "../libcommon/conf.php";
include "../libcommon/classes/db_mysql.php";
include "../libcommon/functions.php";
include "../libcommon/db_inc.php";
include "session.php";
$PATH = $_GET["u"];
include 'header.php';
?>


<body>
	<header id="header">
		<hgroup>
			
			<?php
				if($_SESSION['user_id'] || $_SESSION['user_name'] )
				{										
					// echo "<a href=\"index.php?act=logout\">Logout</a>";
				} 	
			?>			
			
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
			<p>
			<?php
				if($_SESSION['user_id']  || $_SESSION['user_name'] )
				{					
					// echo "<a href=\"student.php\">Welcome ".$_SESSION['student_first_name']."!</a> ";
				}	
			?>		
			</p>			
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs">
			<div id="drillcrumb"></div>			
			</article>
			<div class="password">
			<p>
			<?php
				if($_SESSION['user_id']  || $_SESSION['user_name'] )
				{					
					// echo "<a href=\"student.php?u=cp&b=cpf\">Change Password</a> ";
				}	
			?>		
			</p>
			</div>
		</div>
	</section><!-- end of secondary bar -->

	
	<aside id="sidebar" class="column">
		<?php
			include "sidemenu.php";
			// include "genaratemenu.php";
		?>		
	</aside>	

	<!doctype html>

  
    <body>
    	<div class="flex-center position-ref full-height" style="margin-top: -245px;">
            <div class="content">
		<?php
			if($_GET["u"]) $filename = $_GET["u"].".php";
			if(is_file("$PATH/$filename")) 
			{
			      include "$PATH/$filename";
			}
			else
			{
				echo"<h3 class=\"welcometxt\" style=\"margin:0 auto;text-align:center;\"</h3>";
			}
		?>			
		</div>
		</div>
    </body>



</html>

	
<!-- 	</td>	
 </tr>
 <tr>
	<td>
		<footer>
			<hr />
			<p>
				<strong></strong>
				
			</p>
		</footer>
	</td>	
 </tr>
</table>
	

<?php
include "../libcommon/db_close.php";
?>
