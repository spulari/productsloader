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
?>
<div class="container my-5">

 <h3>New Prescriptions</h3>
 <div class="row" id="new-prescriptions">
 <?php foreach ($new as $p): ?>
 <div class="card d-flex flex-row p-3 align-items-center mb-3">
 <div class="image-wrapper me-3" 
 style="width: 150px; height: 100px; flex-shrink: 0; position: relative; overflow: hidden; border-radius: 8px;">
 <div class="skeleton-image" 
 data-product-id="<?= htmlspecialchars($p['id']) ?>" 
 data-loaded="false"
 style="width: 150px; height: 100px; background-color: #ddd;">
 </div>
 </div>
 <div class="flex-grow-1">
 <h5><?= htmlspecialchars($p['title']) ?></h5>
 <p style="margin-bottom: 0;"><?= htmlspecialchars($p['description']) ?></p>
 <div class="mt-2">
 <?php if ($p['eligible']): ?>
 <button class="btn btn-primary btn-sm me-2">Add to Cart</button>
 <?php endif; ?>
 <?php if ($p['autorefilleligible']): ?>
 <button class="btn btn-secondary btn-sm">Auto Refill</button>
 <?php endif; ?>
 </div>
 </div>
 </div>
 <?php endforeach; ?>
 </div>

 <h3 class="mt-5">Old Prescriptions</h3>
 <div class="row" id="old-prescriptions">
 <?php foreach ($old as $p): ?>
 <div class="card d-flex flex-row p-3 align-items-center mb-3">
 <div class="image-wrapper me-3" 
 style="width: 150px; height: 100px; flex-shrink: 0; position: relative; overflow: hidden; border-radius: 8px;">
 <div class="skeleton-image" 
 data-product-id="<?= htmlspecialchars($p['id']) ?>" 
 data-loaded="false"
 style="width: 150px; height: 100px; background-color: #ddd;">
 </div>
 </div>
 <div class="flex-grow-1">
 <h5><?= htmlspecialchars($p['title']) ?></h5>
 <p style="margin-bottom: 0;"><?= htmlspecialchars($p['description']) ?></p>
 <div class="mt-2">
 <?php if ($p['eligible']): ?>
 <button class="btn btn-primary btn-sm me-2">Add to Cart</button>
 <?php endif; ?>
 <?php if ($p['autorefilleligible']): ?>
 <button class="btn btn-secondary btn-sm">Auto Refill</button>
 <?php endif; ?>
 </div>
 </div>
 </div>
 <?php endforeach; ?>
 </div>
</div>

