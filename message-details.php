<?php 
session_start();
ob_start();
include 'inc/session.php';
include 'inc/config.php';
include 'inc/mysql.class.php'; 
include 'inc/functions.php';
    if ($_POST["message_id"]) {
        $message_id = $_POST["message_id"];
        $query2_string       = "SELECT * FROM contact_messages WHERE id = $message_id";
        $query2_string_calistir   = mysqli_query($connect, $query2_string);
        $query2 = mysqli_fetch_object($query2_string_calistir);

        if ($query2->status == 0) {

            $query1_string       = "UPDATE contact_messages SET status = '1' WHERE id = $message_id";
            $query1_string_calistir   = mysqli_query($connect, $query1_string);
            $query1 = mysqli_fetch_object($query1_string_calistir);
            
        }
            echo '<div class="message-body">
            <div class="p-a-1">
                <div class="overflow-hidden">
                    <div class="date">'.dateformat4($query2->create_date).'</div>
                    <h4 class="lead m-t-0">'.$query2->subject.'</h4>
                    <div class="message-sender">
                        <p><b>'.$query2->name.'</b>('.$query2->email.')'.'</p>
                        <p><b>Telefon : </b>'.$query2->phone.'</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="p-a-1">
                <p>'.$query2->message.'</p>
            </div>
           
        </div>';
           
        }
?>


