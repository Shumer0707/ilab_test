<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/css/my_styles/my_styles.css">
    <link rel="stylesheet" href="app/views/css/my_styles/form_styles.css">
    <title>Template</title>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <form action="/search" method="GET" class="search-form">
                <input type="number" name="product_id" placeholder="Search by Product ID" required>
                <button type="submit">Search</button>
            </form>
            <div class="header-buttons">
                <button onclick="location.href='logout'">Logout</button>
                <button onclick="location.href='product-form'">Add Product</button>
            </div>
        </div>
    </header>
    <!-- Footer -->

