<?php
$mysqli = new mysqli("localhost", "root", "", "product");

$query = "SELECT * FROM product_data WHERE active = 1";
$result = $mysqli->query($query);

$new = [];
$old = [];

while ($row = $result->fetch_assoc()) {
  $product = [
    "id" => $row['id'],
    "title" => $row['name'],
    "description" => $row['description'] ?? $row['small_description'],
    "image_url" => '', // Image will be fetched separately
    "eligible" => true, // Assume true
    "autorefilleligible" => (bool)($row['autorefilleligible'] ?? 0)
  ];

  if ($row['category'] === 'new') {
    $new[] = $product;
  } else {
    $old[] = $product;
  }
}

echo json_encode(['new' => $new, 'old' => $old]);
?>
