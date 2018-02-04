<?
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name']) ) {?>
	<script type="text/javascript">
	window.location.href="index_login.php";
	</script>
<?	
//$URL = "index.php";
//	print "<meta http-equiv='refresh' content='1;URL=$URL'>";
}
?>
