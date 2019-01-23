<?php 
session_start();
ob_start();
include 'inc/session.php';
include 'inc/config.php';
include 'inc/mysql.class.php'; 
include 'inc/functions.php';

    $query1_string       = "UPDATE contact_messages SET notify_viewed = '1' WHERE notify_viewed = 0";
    $query1_string_calistir   = mysqli_query($connect, $query1_string);

    $query2_string       = "UPDATE human_resources_messages SET notify_viewed = '1' WHERE notify_viewed = 0";
    $query2_string_calistir   = mysqli_query($connect, $query2_string);

    $query3_string       = "UPDATE surveys SET notify_viewed = '1' WHERE notify_viewed = 0";
    $query3_string_calistir   = mysqli_query($connect, $query3_string);

    $query4_string       = "UPDATE appointment_messages SET notify_viewed = '1' WHERE notify_viewed = 0";
    $query4_string_calistir   = mysqli_query($connect, $query4_string);

    $query5_string       = "UPDATE cancelled_appointment_messages SET notify_viewed = '1' WHERE notify_viewed = 0";
    $query5_string_calistir   = mysqli_query($connect, $query5_string);

    $query6_string       = "UPDATE result_messages SET notify_viewed = '1' WHERE notify_viewed = 0";
    $query6_string_calistir   = mysqli_query($connect, $query6_string);
?>