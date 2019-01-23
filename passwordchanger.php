<?php 
	include 'inc/config.php';
	include 'inc/mysql.class.php'; 



	if ($_POST["newpassword"] && $_POST["user_id"] && $_POST["currentpage"]) {
		$user_id = $_POST["user_id"];
		$newpassword = $_POST["newpassword"];
		$page = $_POST["currentpage"];

		$password           = sha1(md5(mysqli_real_escape_string($connect, $newpassword)));   

		if($page == "users" || $page == "profile"){
			$query1_string      = "UPDATE users SET password = '$password' WHERE id = '$user_id'";
	        // echo $query1_string;
		}
		else if ($page == "writers") {
			$query1_string      = "UPDATE writers SET password = '$password' WHERE id = '$user_id'";
	       // echo $query1_string;
		}
		else if($page == "reporters"){
			$query1_string      = "UPDATE reporters SET password = '$password' WHERE id = '$user_id'";
	        // echo $query1_string;
		}
        $query1_string_calistir = mysqli_query($connect, $query1_string);
	}
?>
