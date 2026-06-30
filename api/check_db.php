<?php
require_once '../config/db.php';
$stmt = $pdo->query("SHOW COLUMNS FROM feedbacks");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
