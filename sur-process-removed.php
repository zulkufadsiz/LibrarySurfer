<?php
session_start();
ob_start();
include 'inc/session.php';
include 'inc/config.php';
include 'inc/mysql.class.php'; 
include 'inc/functions.php'; 

if( isset($_POST) ){ // secure script, works only if POST was made

	/*
	* Connect to Your databes
	*/
	$array_items = $_POST['item']; //array of items in the Unordered List
	    foreach ( $array_items as $item) {

		    $select_item = "SELECT item_id , category_type from featured_pool WHERE id = '$item'";
			$select_run = mysqli_query($conenct, $select_item ); //perform the update
			$selected = mysqli_fetch_object($select_run ); //perform the update

            remove_featured_pool($selected->item_id, $selected->category_type);
		    echo mysqli_error();

		}
	mysqli_close(); //close database connection
}
?>
<? ob_end_flush(); ?>
