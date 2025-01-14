<?php
$host = 'localhost'; 
$dbname = 'nah661'; 
$username = 'nah661';
$password = '25Thfeb2023'; 

try {
    $db = new mysqli($host, $username, $password, $dbname);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>