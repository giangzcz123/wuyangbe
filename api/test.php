<?php
// Giả sử mật khẩu bạn muốn đặt là "2005"
$password = "2005";
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Chuỗi hash để lưu vào code/DB: " . $hash;
// Kết quả sẽ dạng như: $2y$10$xyz... (chuỗi này thay đổi mỗi lần chạy nhưng vẫn hợp lệ)
?>