<?php 
	include 'inc/config.php';
	include 'inc/mysql.class.php'; 

	if ($_POST["shape"]) {
		$shape = $_POST["shape"];
		echo '<option value="0" selected disabled>Reklam alanı seçiniz...</option>';
		
		$query2_string       = "SELECT * FROM ad_areas WHERE status = 1 AND shape = $shape ORDER BY title";
	    $query2_string_calistir   = mysqli_query($connect, $query2_string);
	    while ($query2 = mysqli_fetch_object($query2_string_calistir)) {
	    	if ($query2->availability == 1) {
	      		echo '<option value="'.$query2->id.'">'.$query2->title.'</option>';
	        }
	        else{
	      		echo '<option value="'.$query2->id.'" disabled >'.$query2->title.' (Bu alana daha fazla reklam girilemez!..)</option>';
	        }
		}
	}
?>
