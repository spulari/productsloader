<?php
// fetch_product_image.php
require_once 'config.php'; // Include your database configuration file

header('Content-Type: application/json');

$product_id = $_GET['product_id'] ?? null;
$image_url = null;

if ($product_id !== null && is_numeric($product_id)) {
    // Query to get the image_url for the given product_id
    // Adjust 'is_thumbnail = 1' if you have a different primary image logic
    $sql = "SELECT image_url FROM product_images WHERE product_id = ? AND is_thumbnail = 1 LIMIT 1";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->bind_result($fetched_image_url);
        if ($stmt->fetch()) {
            $image_url = $fetched_image_url;
        }
        $stmt->close();
    } else {
        error_log("Failed to prepare image fetch statement: " . $mysqli->error);
    }
}

$mysqli->close();

// Return the image URL. If not found, it will be null.
echo json_encode(['product_id' => (int)$product_id, 'image_url' => $image_url]);
?>