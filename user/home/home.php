<?php
if ($_GET['b'] == "user_home") {
	
	include 'user_home.php';
}
if ($_GET['b'] == "confirm_estimation") {
	
	include 'confirm_estimation.php';
}


if ($_GET['b'] == "estimate") {
	
	include 'estimate_newmodel.php';
}

if ($_GET['b'] == "confirm_payment") {
	
	include 'confirm_payment.php';
}

if ($_GET['b'] == "online_payment_success") {
	
	include 'online_payment_success.php';
}


if ($_GET['b'] == "online_payment_failure") {
	
	include 'online_payment_failure.php';
}


if ($_GET['b'] == "invoice") {
	
	include 'invoice.php';
}

// if ($_GET['b'] == 'es') {

// 	$student_id = $_GET['id'];
// 	include 'fetch_student_details.php';
// 	echo '<form action="?u=home&b=update&id='.$student_id.'" method="POST" id="edit_details">';
// 	include 'enter_details.php';
// 	echo '</form>';
// }

// if ($_GET['b'] == 'update') {
// 	include 'update_details.php';
// }



?>