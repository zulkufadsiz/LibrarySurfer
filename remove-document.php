<?php 
	include 'inc/config.php';
	include 'inc/mysql.class.php'; 

	if ($_POST["item_id"]) {
		$item_id = $_POST["item_id"];
		
	    $query2_string      = "UPDATE news set catalog_tr = '' where id = '$item_id'";
	    $query2_string_calistir   = mysqli_query($connect, $query2_string);
	}
?>
