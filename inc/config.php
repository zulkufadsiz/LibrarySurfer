<?php

include 'conf.php';

// Address
$site_adi = "Library Surfer";
$site_adresi = "localhost";
$panel_adi = $site_adi." Yönetim Paneli";

/* If it has many language support */

// if (isset($_GET[lang]) ) {
// 	if ($_GET[lang] == 'en'){
// 		$base = '<base href="localhost/en/" />';
// 		$base_url= "localhost/en/index.php";
// 		$pic_get = "../images/upload"; //Demodan çıkartınca siteyi ../ kaldır
// 	}
// }
// else {
// 	$base = '<base href="localhost/" />';
// 	$base_url= "localhost/index.php";
// 	$pic_get = "images/upload"; //Demodan çıkartınca siteyi ../ kaldır
// };

$logo_url= "images/logo.png";

// User ID 
$user_id = $_SESSION['user_session'];

// Ana Ayarlar
$phpserv   = $_SERVER['PHP_SELF'];

// Resim Upload
$fiup = "assets/images/upload";
$pic_url = "assets/images/upload";

// Site İçi Resim Upload //
$inner_fiup = "images/upload";


?>