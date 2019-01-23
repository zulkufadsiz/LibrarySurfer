<?php
$con = mysqli_connect("localhost","turkosan_dbuser","Turkosan2017!","turkosan");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>