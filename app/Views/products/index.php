<div class="app-container">
    <aside class="filter-sidebar">
        <h3>Filter</h3>
        <form action="/" method="GET">
            <div class="filter-group">
                <label>Category:</label>
                <select name="cat" class="filter-input">
                    <option value="">All</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?php echo htmlspecialchars($c['category']); ?>" <?php echo ($cat ?? '') === $c['category'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($c['category']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label>Max Price:</label>
                <input type="number" name="price" value="<?php echo $price ?? ''; ?>" class="filter-input">
            </div>
            <button type="submit" class="btn btn-block">Apply</button>
        </form>
    </aside>

    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <img src="/uploads/<?php echo $product['image'] ?: 'placeholder.png'; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p class="price-tag">$<?php echo number_format($product['price'], 2); ?></p>
                <a href="/product?id=<?php echo $product['id']; ?>" class="btn">View Details</a>
                <form action="/cart/add" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
