<?php 
session_start();
ob_start();
include 'inc/session.php';
include 'inc/config.php';
include 'inc/mysql.class.php'; 
include 'inc/functions.php';
ini_set('display_errors', 0);

    if ($_POST["message_id"]) {
        $message_id = $_POST["message_id"];
        
        $query2_string       = "SELECT * FROM appointment_messages WHERE id = $message_id";
        $query2_string_calistir   = mysqli_query($connect, $query2_string);
        $query2 = mysqli_fetch_object($query2_string_calistir);
       
        if ($query2->status == 0) {
            $query1_string       = "UPDATE appointment_messages SET status = '1' WHERE id = $message_id";
            $query1_string_calistir   = mysqli_query($connect, $query1_string);
            $query1 = mysqli_fetch_object($query1_string_calistir);
        }

        $cats = "SELECT * FROM categories WHERE id = $query2->department";
        $cat_que = mysqli_query($connect,$cats);
        $cat = mysqli_fetch_object($cat_que);


        $docs = "SELECT * FROM products WHERE id = $query2->doctor";
        $doc_que = mysqli_query($connect, $docs);
        $doc = mysqli_fetch_object($doc_que);

            echo '<div class="message-body">
            <div class="p-a-1">
                <div class="overflow-hidden">
                    <h2>E-Randevu Talep Formu</h2>
                    <div class="date">'.dateformat4($query2->create_date).'</div>
                    <h4 class="lead m-t-0">'.$query2->subject.'</h4>
                    <div class="message-sender">
                        <p><b>'.$query2->name.' ('.$query2->email.')'.'</b></p>
                        <p><b>Telefon : </b>'.$query2->phone.'</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="p-a-1">
                <h4>Kişisel Bilgiler</h4>
                <div class="row">
                    <div class="col-xs-12"><label>T.C. Kimlik No :</label> <span>'.$query2->tc.'</span></div>
                    <div class="col-xs-12"><label>Ad :</label> <span>'.$query2->name.'</span></div>
                    <div class="col-md-12"><label>Soyad :</label> <span>'.$query2->lname.'</span></div>
                    <div class="col-md-12"><label>E-Posta :</label> <span>'.$query2->email.'</span></div>
                    <div class="col-md-12"><label>Telefon :</label> <span>'.$query2->phone.'</span></div>
                </div>
                <h4>Randevu Bilgileri</h4>
                 <div class="row">
                    <div class="col-md-12"><label>Bölüm :</label> <span>'.$cat->title_tr.'</span></div>
                    <div class="col-md-12"><label>Doktor :</label> <span>'.$doc->title_tr.'</span></div>
                    <div class="col-md-12"><label>Randevu Tarihi :</label> <span>'.$query2->appointment_date.'</span></div>
                    
                </div>
            </div>
        </div>';
           
        }
?>


