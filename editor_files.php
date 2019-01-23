<?php
include 'inc/session.php';

copy($_FILES['file']['tmp_name'], 'images/upload/'.$_FILES['file']['name']);
					
$array = array(
    'filelink' => 'images/upload/'.$_FILES['file']['name'],
    'filename' => $_FILES['file']['name']
);
 
echo stripslashes(json_encode($array));	
?>