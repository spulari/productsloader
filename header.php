<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulari's Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        /* Header specific styles */
        .main-header {
            background-color: #007bff; /* Primary blue for main header */
            padding: 10px 0;
            color: white;
        }
        .main-header .navbar-brand {
            color: white;
            font-weight: bold;
            font-size: 1.8rem;
        }
        .main-header .nav-link {
            color: white;
            margin-left: 15px;
        }
        .main-header .nav-link:hover {
            color: #e0e0e0;
        }

        /* Sub-header (Navigation) specific styles */
        .sub-header {
            background-color: #343a40; /* Dark grey for sub-header */
            padding: 8px 0;
        }
        .sub-header .nav-link {
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.2s ease-in-out;
        }
        .sub-header .nav-link:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .sub-header .navbar-nav .nav-item {
            margin-right: 5px; /* Small space between nav items */
        }

        /* Product card styles (from previous iterations) */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }
        .product-card:hover {
            transform: translateY(-3px);
        }
        .product-card img {
            width: 100%;
            height: 200px; /* Fixed height for consistency */
            object-fit: cover; /* Ensures image covers the area, might crop */
            border-bottom: 1px solid #eee;
        }
        .product-info {
            padding: 15px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .product-info h3 {
            font-size: 1.4rem;
            margin-bottom: 5px;
            color: #333;
        }
        .product-info .small-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
        }
        .product-info .description {
            font-size: 0.85rem;
            color: #555;
            line-height: 1.4;
            margin-bottom: 15px;
            flex-grow: 1;
        }
        .add-to-cart-btn-wrapper {
            margin-top: auto;
            text-align: left;
        }
        .add-to-cart-btn {
            width: auto;
            padding: 8px 15px;
            font-size: 0.9rem;
            display: inline-block;
        }
        .category-section {
            display: none;
        }
        #loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        #loading-spinner .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        .end-of-products {
            display: none;
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-style: italic;
        }
        .not-available-msg {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Main Header -->
<header class="main-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark p-0">
            <a class="navbar-brand" href="#">Pulari's Logo</a>
            <div class="ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<!-- Sub-Header (Navigation) -->
<nav class="sub-header navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Pulari</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">My Rx</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">My Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">My Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>