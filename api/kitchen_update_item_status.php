<?php
require_once '../config/db.php';

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$itemId) {
    http_response_code(400);
    echo json_encode(['error' => 'Item ID is required']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$newStatus = $data['ItemStatus'] ?? null;
if (!in_array($newStatus, ['Waiting', 'Cooking', 'Served'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid status']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Lấy thông tin trạng thái hiện tại, ProductID và Quantity của OrderItem
    $stmt = $pdo->prepare('SELECT ItemStatus, ProductID, Quantity FROM orderitems WHERE OrderItemID = ?');
    $stmt->execute([$itemId]);
    $orderItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$orderItem) {
        throw new Exception("OrderItem not found");
    }

    $currentStatus = $orderItem['ItemStatus'];

    // Cập nhật trạng thái mới
    $stmtUpdate = $pdo->prepare('UPDATE orderitems SET ItemStatus = ? WHERE OrderItemID = ?');
    $stmtUpdate->execute([$newStatus, $itemId]);

    // Nếu trạng thái mới là 'Served' và trước đó chưa phải 'Served', tiến hành trừ kho
    if ($newStatus === 'Served' && $currentStatus !== 'Served') {
        $productId = $orderItem['ProductID'];
        $quantity = $orderItem['Quantity'];

        // Lấy công thức định mức (Recipes) cho sản phẩm này
        $stmtRecipe = $pdo->prepare('SELECT IngredientID, AmountRequired FROM recipes WHERE ProductID = ?');
        $stmtRecipe->execute([$productId]);
        $recipes = $stmtRecipe->fetchAll(PDO::FETCH_ASSOC);

        // Trừ số lượng tồn kho theo số lượng món * định mức
        if (!empty($recipes)) {
            $stmtDeduct = $pdo->prepare('UPDATE ingredients SET StockQuantity = StockQuantity - ? WHERE IngredientID = ?');
            foreach ($recipes as $recipe) {
                $totalToDeduct = $recipe['AmountRequired'] * $quantity;
                $stmtDeduct->execute([$totalToDeduct, $recipe['IngredientID']]);
            }
        }
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update item status: ' . $e->getMessage()]);
}
?>
