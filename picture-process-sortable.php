<?php
session_start();
ob_start();
include 'inc/session.php';
include 'inc/config.php';
include 'inc/mysql.class.php'; 

if( isset($_POST) ){ // secure script, works only if POST was made

	/*
	* Connect to Your databes
	*/
	$array_items = $_POST['item']; //array of items in the Unordered List
	$order = 0; //order number set to 0; 

	
	    foreach ( $array_items as $item) {

	    	$update = "UPDATE product_pictures SET picture_ordering = '$order' WHERE picture_id='$item' "; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.
			$perform = mysqli_query($connect, $update ); //perform the update

		    $order++; //increment order value by one;
		    echo mysqli_error();
		}
	mysqli_close(); //close database connection
}

?>
<? ob_end_flush(); ?>
