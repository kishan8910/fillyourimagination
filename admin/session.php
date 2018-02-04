<?
if(!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) ) {?>
	<script type="text/javascript">
	window.location.href="index.php";
	// alert();
	</script>
<?	
//$URL = "index.php";
//	print "<meta http-equiv='refresh' content='1;URL=$URL'>";
}
?>
