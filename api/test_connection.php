<?php
$host = 'sql305.infinityfree.com';
$username = 'if0_41695663';
$password = 'T5Gv8tJrwk';

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("FAIL: " . $conn->connect_error);
}

echo "LOGIN OK (chưa check DB)";
?>