<?php
$mysqli = new mysqli("localhost", "root", "", "product");

$productId = intval($_GET['id'] ?? 0);
$query = "SELECT image_url FROM product_images WHERE product_id = ? LIMIT 1";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $productId);
$stmt->execute();
$stmt->bind_result($imageUrl);
$stmt->fetch();
$stmt->close();

echo $imageUrl ?: 'assets/images/placeholder.jpg';
?>
