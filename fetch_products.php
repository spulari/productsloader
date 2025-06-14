<?php
// fetch_products.php
require_once 'config.php';

header('Content-Type: application/json');

$category = $_GET['category'] ?? '';
$offset = (int)($_GET['offset'] ?? 0);
$limit = (int)($_GET['limit'] ?? 10);

$products = [];
$hasMore = false;

if (in_array($category, ['new', 'old'])) {
    $count_sql = "SELECT COUNT(*) FROM product_data WHERE available = true and category = ? ";
    if ($stmt_count = $mysqli->prepare($count_sql)) {
        $stmt_count->bind_param("s", $category);
        $stmt_count->execute();
        $stmt_count->bind_result($total_products);
        $stmt_count->fetch();
        $stmt_count->close();
    } else {
        error_log("Failed to prepare count statement: " . $mysqli->error);
        echo json_encode(['products' => [], 'hasMore' => false]);
        $mysqli->close();
        exit();
    }

    // Removed 'image_url' from SELECT statement
    $sql = "SELECT id, name, small_description, description, type, size, color, available
            FROM product_data
            WHERE available = true and category = ?
            LIMIT ? OFFSET ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sii", $category, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $row['available'] = (bool)$row['available'];
            $products[] = $row;
        }
        $stmt->close();

        $hasMore = ($offset + count($products)) < $total_products;

    } else {
        error_log("Failed to prepare statement: " . $mysqli->error);
    }
} else {
    error_log("Invalid category requested: " . $category);
}

$mysqli->close();

echo json_encode(['products' => $products, 'hasMore' => $hasMore]);
?>