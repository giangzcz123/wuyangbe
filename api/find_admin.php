<?php
require_once '../config/db.php';
try {
    $stmt = $pdo->query("SELECT Username, UserRole FROM users WHERE UserRole = 'Admin'");
    $admins = $stmt->fetchAll();
    echo json_encode($admins);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
