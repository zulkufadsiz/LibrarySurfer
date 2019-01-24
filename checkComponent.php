<?php 

include 'inc/conf.php';

include 'inc/mysql.class.php'; 


if (isset($_POST['isbn'])) {
	$isbn = mysqli_real_escape_string($connect, $_POST['isbn']);
	$sql = "SELECT * FROM  sp_books WHERE isbn = '$isbn'";
	$query_run = mysqli_query($connect,$sql);
	$result = mysqli_num_rows($query_run);
	if ($result == 0){
	$valid = 'true';}
	else{
	$valid = 'false';
	}
	echo $valid;
}

if (isset($_POST['email'])) {
	$email = mysqli_real_escape_string($connect, $_POST['email']);
	//$email = "zulkufadsiz@gmail.com";
	$check_for_email = mysqli_query($connect,"SELECT email FROM sp_users WHERE email='$email'");

	$result = mysqli_num_rows($check_for_email);
	if ($result == 0){
	$valid = 'true';}
	else{
	$valid = 'false';
	}
	echo $valid;
}

 ?>