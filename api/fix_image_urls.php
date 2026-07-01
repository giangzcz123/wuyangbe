<?php
// Script chạy 1 lần để fix toàn bộ ImageURL trong DB
// Truy cập: http://192.168.2.18/api/fix_image_urls.php

require_once '../config/db.php';

$CORRECT_IP = '172.20.10.4';

header('Content-Type: text/plain; charset=utf-8');

try {
    $stmt = $pdo->query("SELECT ProductID, ImageURL FROM products WHERE ImageURL IS NOT NULL AND ImageURL != ''");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $updated = 0;
    $skipped = 0;
    $log = [];

    foreach ($products as $p) {
        $url    = $p['ImageURL'];
        $newUrl = $url;

        // Bước 1: Chuẩn hoá host
        // localhost → IP đúng
        $newUrl = preg_replace('#https?://localhost(:\d+)?/#i', "http://{$CORRECT_IP}/", $newUrl);
        // IP bất kỳ khác → IP đúng
        $newUrl = preg_replace('#https?://\d+\.\d+\.\d+\.\d+(:\d+)?/#', "http://{$CORRECT_IP}/", $newUrl);

        // Bước 2: Loại bỏ prefix path cũ
        $newUrl = str_replace('/wuyang_be/public/', '/public/', $newUrl);
        $newUrl = str_replace('/hadilaoPHP/public/', '/public/', $newUrl);

        if ($newUrl !== $url) {
            $update = $pdo->prepare("UPDATE products SET ImageURL = ? WHERE ProductID = ?");
            $update->execute([$newUrl, $p['ProductID']]);
            $updated++;
            $log[] = "✅ ID {$p['ProductID']}:\n   Cũ: {$url}\n   Mới: {$newUrl}";
        } else {
            $skipped++;
            $log[] = "⏭ ID {$p['ProductID']}: OK ({$url})";
        }
    }

    echo "===== KẾT QUẢ FIX IMAGE URL =====\n";
    echo "Đã fix: $updated\n";
    echo "Bỏ qua (đúng rồi): $skipped\n\n";
    echo implode("\n", $log);

} catch (Exception $e) {
    echo "LỖI: " . $e->getMessage();
}
?>
