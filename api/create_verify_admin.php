<?php
require_once '../config/db.php';
$username = 'verify_admin';
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
$fullName = 'Verification Admin';
$role = 'Admin';

try {
    // Delete if exists
    $stmt = $pdo->prepare("DELETE FROM Users WHERE Username = ?");
    $stmt->execute([$username]);

    $stmt = $pdo->prepare("INSERT INTO Users (Username, PasswordHash, FullName, UserRole) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $hash, $fullName, $role]);
    echo json_encode(["success" => true, "username" => $username, "password" => $password]);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
