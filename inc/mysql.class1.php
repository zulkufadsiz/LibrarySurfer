<?php
// Veritabanı Bağlantısı
mysql_connect($host, $user, $password);
mysql_select_db($database);

mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

// // $_GET[id]
// if ($_GET['id'] AND is_numeric($_GET['id'])) {
// 	$id = mysql_real_escape_string($_GET['id']);
// }

?>