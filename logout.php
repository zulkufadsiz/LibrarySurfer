<?php
session_start();
unset($_SESSION['user_session']);
session_destroy();
header("Location: login.php");
?>