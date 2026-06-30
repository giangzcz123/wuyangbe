<?php
require_once '../config/db.php';
$stmt = $pdo->prepare('SELECT * FROM Users WHERE UserRole = "Admin" LIMIT 1');
$stmt->execute();
$admin = $stmt->fetch();
if (!$admin) {
    $hash = password_hash('123456', PASSWORD_DEFAULT);
    $pdo->query("INSERT INTO Users (Username, PasswordHash, FullName, UserRole) VALUES ('admin', '$hash', 'Administrator', 'Admin')");
    echo "Tài khoản admin chưa có, đã tự động tạo mới:\nUsername: admin\nPassword: 123456";
} else {
    echo "Tài khoản Admin đang có trong hệ thống là:\nUsername (Tên đăng nhập): " . $admin['Username'] . "\n(Mật khẩu đã bị mã hóa, nếu bạn quên có thể tạo thủ công mật khẩu mới trong phpMyAdmin)";
}
?>
