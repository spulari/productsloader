<footer class="bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container text-center text-md-left">
        <div class="row text-center text-md-left">

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Contact</h5>
                <p>
                    <i class="fas fa-home mr-3"></i> 123 Product Lane, Suite 100, City, State 12345
                </p>
                <p>
                    <i class="fas fa-envelope mr-3"></i> info@pulari.com
                </p>
                <p>
                    <i class="fas fa-phone mr-3"></i> +01 234 567 88
                </p>
                <p>
                    <i class="fas fa-print mr-3"></i> +01 234 567 89
                </p>
            </div>

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Legal</h5>
                <p>
                    <a href="#" class="text-white" style="text-decoration: none;"> Privacy Policy</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration: none;"> Terms of Service</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration: none;"> Rules and Regulations</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration: none;"> Disclaimer</a>
                </p>
            </div>

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">My Account</h5>
                <p>
                    <a href="#" class="text-white" style="text-decoration: none;"> My Orders</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration: none;"> My Profile</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration: none;"> Wishlist</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration: none;"> Returns & Refunds</a>
                </p>
            </div>

        </div>
        <hr class="mb-4">
        <div class="row align-items-center">
            <div class="col-md-7 col-lg-8">
                <p class="text-center text-md-left">© 2023 Pulari's Products. All rights reserved.</p>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="text-center text-md-right">
                    </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // --- Configuration ---
        const PRODUCTS_PER_LOAD = 7;
        const SCROLL_THRESHOLD = 80; // Pixels from bottom of page to trigger load

        // --- State Variables ---
        let currentCategory = 'new';
        let newProductsOffset = 0;
        let oldProductsOffset = 0;
        let isLoading = false;
        let allNewLoaded = false;
        let allOldLoaded = false;

        // --- DOM Elements ---
        const $newProductsSection = $('#new-products-section');
        const $newProductsContainer = $('#new-products-container');
        const $loadingSpinnerNew = $('#loading-spinner-new');
        const $endOfNewProducts = $('#end-of-new-products');

        const $oldProductsSection = $('#old-products-section');
        const $oldProductsContainer = $('#old-products-container');
        const $loadingSpinnerOld = $('#loading-spinner-old');
        const $endOfOldProducts = $('#end-of-old-products');


        // --- Helper Functions ---

        // Function to render a single product card
        function renderProduct(product) {
            // Use a placeholder image initially
            const placeholderImageUrl = 'https://via.placeholder.com/200?text=Loading...';

            let actionButtonHtml = '';
            if (product.available) {
                actionButtonHtml = `<a href="example.com/addtocart?product_id=${product.id}" class="btn btn-primary add-to-cart-btn">Add to Cart</a>`;
            } else {
                actionButtonHtml = `<span class="not-available-msg">Out of Stock</span>`;
            }

            return `
                <div class="col-12 mb-3 product-card-container">
                    <div class="product-card d-flex align-items-stretch">
                        <div class="row g-0 w-100">
                            <div class="col-sm-4">
                                <img src="${placeholderImageUrl}" class="img-fluid rounded-start product-image-placeholder" alt="${product.name}" data-product-id="${product.id}">
                            </div>
                            <div class="col-sm-8">
                                <div class="product-info">
                                    <h3>${product.name}</h3>
                                    <p class="small-description">${product.small_description}</p>
                                    <p class="description">${product.description}</p>
                                    <div class="add-to-cart-btn-wrapper">
                                        ${actionButtonHtml}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Function to load images one by one after products are rendered
        function loadProductImages(container) {
            // Select all image placeholders within the given container that still have the 'Loading...' placeholder
            const $imagePlaceholders = container.find('.product-image-placeholder[src*="Loading..."]');
            let index = 0;

            function fetchNextImage() {
                if (index < $imagePlaceholders.length) {
                    const $imgElement = $($imagePlaceholders[index]);
                    const productId = $imgElement.data('productId'); // Get product ID from data attribute

                    if (productId) {
                        $.ajax({
                            url: 'fetch_product_image.php', // Call the new image fetch endpoint
                            method: 'GET',
                            data: { product_id: productId },
                            dataType: 'json',
                            success: function(response) {
                                if (response.image_url) {
                                    $imgElement.attr('src', response.image_url); // Update image src
                                } else {
                                    // Fallback if no image found for this product
                                    $imgElement.attr('src', 'https://via.placeholder.com/200?text=No+Image');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching image for product " + productId + ":", status, error);
                                $imgElement.attr('src', 'https://via.placeholder.com/200?text=Error'); // Show error placeholder
                            },
                            complete: function() {
                                index++;
                                // Call next image fetch after a short delay
                                // This delay helps prevent overwhelming the server with too many requests at once.
                                setTimeout(fetchNextImage, 50); // Adjust delay as needed (e.g., 50ms)
                            }
                        });
                    } else {
                        // If no product ID was found for some reason, just move to the next image
                        index++;
                        setTimeout(fetchNextImage, 0);
                    }
                }
            }
            fetchNextImage(); // Start the sequence of fetching images
        }


        // Function to load products
        function loadProducts() {
            if (isLoading) return;

            let offsetToLoad;
            let containerToAppend;
            let spinnerToShow;
            let allLoadedFlag;

            if (currentCategory === 'new') {
                if (allNewLoaded) {
                    currentCategory = 'old';
                    $endOfNewProducts.fadeIn();
                    if (allOldLoaded) {
                         // All products (new and old) are loaded
                         return;
                    }
                    $oldProductsSection.fadeIn(); // Show the old products section once new are exhausted
                }
                offsetToLoad = newProductsOffset;
                containerToAppend = $newProductsContainer;
                spinnerToShow = $loadingSpinnerNew;
                allLoadedFlag = allNewLoaded;
            } else if (currentCategory === 'old') {
                if (allOldLoaded) {
                    $endOfOldProducts.fadeIn();
                    return; // No more products to load
                }
                offsetToLoad = oldProductsOffset;
                containerToAppend = $oldProductsContainer;
                spinnerToShow = $loadingSpinnerOld;
                allLoadedFlag = allOldLoaded;
            } else {
                console.error("Unknown category:", currentCategory);
                return;
            }

            if (allLoadedFlag) return;

            isLoading = true;
            spinnerToShow.removeClass('d-none'); // Show loading spinner

            $.ajax({
                url: 'fetch_products.php',
                method: 'GET',
                data: {
                    category: currentCategory,
                    offset: offsetToLoad,
                    limit: PRODUCTS_PER_LOAD
                },
                dataType: 'json',
                success: function(response) {
                    const products = response.products;
                    const hasMore = response.hasMore;

                    if (products && products.length > 0) {
                        let productsHtml = '';
                        $.each(products, function(index, product) {
                            productsHtml += renderProduct(product);
                        });
                        // Append product cards first (with placeholders)
                        containerToAppend.append(productsHtml);

                        if (currentCategory === 'new') {
                            newProductsOffset += products.length;
                        } else {
                            oldProductsOffset += products.length;
                        }

                        // THEN trigger image loading for the newly added products
                        // Use a short timeout to ensure new elements are in DOM before querying them
                        setTimeout(() => loadProductImages(containerToAppend), 100);

                    } else {
                        // No products returned for this batch, or initial load found nothing
                    }

                    if (!hasMore) {
                        // All products for this category have been loaded
                        if (currentCategory === 'new') {
                            allNewLoaded = true;
                            $endOfNewProducts.fadeIn(); // Show 'End of New Products' message
                            loadProducts(); // Immediately try to load old products if new are exhausted
                        } else {
                            allOldLoaded = true;
                            $endOfOldProducts.fadeIn(); // Show 'End of Old Products' message
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error loading products:", status, error, xhr.responseText);
                    containerToAppend.append('<div class="col-12"><p class="text-danger">Failed to load ' + currentCategory + ' products.</p></div>');
                },
                complete: function() {
                    isLoading = false;
                    spinnerToShow.addClass('d-none'); // Hide loading spinner
                }
            });
        }

        // --- Event Listener for Scrolling ---
        $(window).scroll(function() {
            // Check if user is near the bottom of the page
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - SCROLL_THRESHOLD) {
                // If not currently loading and there are more products to load
                if (!isLoading) {
                    // Determine which category to load next
                    if (currentCategory === 'new' && !allNewLoaded) {
                        loadProducts();
                    } else if (currentCategory === 'new' && allNewLoaded && !allOldLoaded) {
                        // If new products are all loaded, but old haven't started/finished
                        currentCategory = 'old';
                        $oldProductsSection.fadeIn(); // Make old section visible when switching
                        loadProducts();
                    } else if (currentCategory === 'old' && !allOldLoaded) {
                        loadProducts();
                    }
                }
            }
        });

        // --- Initial Load on Document Ready ---
        // Display the "New Products" section title and initiate the first load
        $newProductsSection.fadeIn(function() {
            loadProducts();
        });
    });
</script>
</body>
</html>