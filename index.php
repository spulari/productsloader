<?php
// index.php
include 'header.php'; // Include the header template
?>

    <div class="container productcardlist mt-5">
        <h1 class="mb-3 text-primary text-start">My Prescriptions</h1>
        <p class="text-muted text-start">
            Browse and manage your prescription products below.
            Select a product to view more details or add it to your cart.
            Easily keep track of your current and previous prescriptions in one place.
             Browse and manage your prescription products below.
            Select a product to view more details or add it to your cart.
            Easily keep track of your current and previous prescriptions in one place.
        </p>

        <div id="new-products-section" class="category-section">
            <h2 class="mb-4 text-secondary">New Products</h2>
            <div id="new-products-container" class="row">
                </div>
            <div id="loading-spinner-new" class="d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading new products...</span>
                </div>
                <p class="text-muted mt-2">Loading new products...</p>
            </div>
            <p id="end-of-new-products" class="end-of-products">End of New Products</p>
        </div>

        <div id="old-products-section" class="category-section mt-5">
            <h2 class="mb-4 text-secondary">Old Products</h2>
            <div id="old-products-container" class="row">
                </div>
            <div id="loading-spinner-old" class="d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading old products...</span>
                </div>
                <p class="text-muted mt-2">Loading old products...</p>
            </div>
            <p id="end-of-old-products" class="end-of-products">End of Old Products</p>
        </div>
    </div>

<?php
include 'footer.php'; // Include the footer template
?>