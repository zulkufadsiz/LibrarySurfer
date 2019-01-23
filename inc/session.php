<?php 
// Kullanıcı oturumu
if (!$_SESSION['user_session'])
{
			header("Location: login.php");
}
?>