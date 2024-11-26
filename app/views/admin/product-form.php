
<?php include 'static/header.php'; ?>

<main>
    <section class="add-product-section">
        <form action="add-product" method="POST" class="add-product-form">
            <h2>Add Product</h2>
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" placeholder="Enter price" min="0" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Discount:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="discount" value="0" checked> No Discount
                    </label>
                    <label>
                        <input type="radio" name="discount" value="10"> 10%
                    </label>
                    <label>
                        <input type="radio" name="discount" value="20"> 20%
                    </label>
                    <label>
                        <input type="radio" name="discount" value="30"> 30%
                    </label>
                </div>
            </div>
            <button type="submit">Add Product</button>
        </form>
    </section>
</main>

<?php include 'static/footer.php'; ?>