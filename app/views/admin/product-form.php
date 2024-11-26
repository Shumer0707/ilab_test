
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
                <label>Discount(предполагаются разные группы скидок):</label>
                <div class="radio-group">
                    <?php foreach ($discount as $discount): ?>
                    <label><?php echo htmlspecialchars($discount['title']) ?>
                        <input  type="radio" 
                                name="discount" 
                                value="<?php echo htmlspecialchars($discount['id']) ?>"> 
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group">
                <label>Additional options (возможно толщина)</label>
                <div class="radio-group">
                    <?php foreach ($smallOption as $smallOption): ?>
                        <label><?php echo htmlspecialchars($smallOption['title']) ?>
                            <input type="checkbox" name="small_option[]" value="<?php echo htmlspecialchars($smallOption['id']) ?>">
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="submit">Add Product</button>
        </form>
    </section>
</main>

<?php include 'static/footer.php'; ?>