<?php
require_once 'config/db.php';

try {
    $stmt = $pdo->query("SELECT ProductID, ImageURL FROM products WHERE ImageURL IS NOT NULL AND ImageURL != ''");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $updated = 0;

    foreach ($products as $p) {
        $url = $p['ImageURL'];
        $newUrl = $url;
        
        // Fix localhost -> 192.168.1.7
        $newUrl = str_replace('localhost:8088/hadilaoPHP', '192.168.1.7', $newUrl);
        $newUrl = str_replace('localhost:8088/wuyang_be', '192.168.1.7', $newUrl);
        $newUrl = str_replace('localhost', '192.168.1.7', $newUrl);
        
        // Fix /wuyang_be/public -> /public
        $newUrl = str_replace('/wuyang_be/public', '/public', $newUrl);

        if ($newUrl !== $url) {
            $update = $pdo->prepare("UPDATE products SET ImageURL = ? WHERE ProductID = ?");
            $update->execute([$newUrl, $p['ProductID']]);
            $updated++;
        }
    }
    echo "Fixed $updated image URLs.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
