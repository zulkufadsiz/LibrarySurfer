<?php
	
include 'inc/session.php';

header('Content-type: application/json');
$files = glob('images/upload/*.*');
$arr   = array();

foreach ($files as $file) {	
    $file = basename($file);
    $arr[] = array("thumb" => "images/upload/".$file, 'image'=> "images/upload/".$file);
}

exit(str_replace('\/','/',json_encode($arr)));
?>