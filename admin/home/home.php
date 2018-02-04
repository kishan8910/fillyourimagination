<?php

if ($_GET['b'] == "admin_home") {
	
	include 'admin_home.php';
}

if ($_GET['b'] == "list_users") {
	
	include 'list_users.php';
}

if ($_GET['b'] == "show_model") {
	
	include 'show_model.php';
}

if ($_GET['b'] == "show_lithophane") {
	
	include 'show_lithophane.php';
}

if ($_GET['b'] == "lithophane_details") {
	
	include 'show_lithophane.php';
}




?>