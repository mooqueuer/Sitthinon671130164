<?php
$servername = "localhost";
$username = "root";
$password = "12345678"; // **แก้รหัสผ่าน AppServ ของคุณตรงนี้**
$dbname = "my_website";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
date_default_timezone_set('Asia/Bangkok');
?>