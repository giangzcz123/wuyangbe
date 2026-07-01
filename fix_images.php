<?php
require_once 'config/db.php';

// ===== IP hiện tại của máy chủ BE =====
$CORRECT_IP = '192.168.2.18';

try {
    $stmt = $pdo->query("SELECT ProductID, ImageURL FROM products WHERE ImageURL IS NOT NULL AND ImageURL != ''");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $updated = 0;
    $skipped = 0;

    echo "<pre>\n";
    echo "Tổng số sản phẩm có ImageURL: " . count($products) . "\n\n";

    foreach ($products as $p) {
        $url    = $p['ImageURL'];
        $newUrl = $url;

        // 1. Fix các dạng localhost cũ
        $newUrl = preg_replace('#https?://localhost(:\d+)?/#', "http://{$CORRECT_IP}/", $newUrl);

        // 2. Fix IP cũ (192.168.1.x, 192.168.0.x, v.v.)
        $newUrl = preg_replace('#https?://192\.168\.\d+\.\d+(:\d+)?/#', "http://{$CORRECT_IP}/", $newUrl);

        // 3. Fix path dư thừa (wuyang_be/public -> public, hadilaoPHP/public -> public)
        $newUrl = str_replace('/wuyang_be/public/', '/public/', $newUrl);
        $newUrl = str_replace('/hadilaoPHP/public/', '/public/', $newUrl);

        // 4. Đảm bảo path uploads đúng
        $newUrl = str_replace('/public/uploads/products/', '/public/uploads/products/', $newUrl); // no-op nhưng giữ để rõ logic

        if ($newUrl !== $url) {
            $update = $pdo->prepare("UPDATE products SET ImageURL = ? WHERE ProductID = ?");
            $update->execute([$newUrl, $p['ProductID']]);
            $updated++;
            echo "✅ ID {$p['ProductID']}: {$url}\n   → {$newUrl}\n\n";
        } else {
            $skipped++;
        }
    }

    echo "============================\n";
    echo "Đã fix: $updated URL\n";
    echo "Bỏ qua (đã đúng): $skipped URL\n";
    echo "</pre>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
