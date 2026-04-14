<div class="app-container">
    <div class="page-wrapper">
        <a href="/" style="text-decoration: none; color: #333;">&larr; Back to Products</a>
        <div class="product-detail-flex">
            <div class="product-detail-image">
                <img src="/uploads/<?php echo $product['image'] ?: 'placeholder.png'; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; border-radius: 8px;">
            </div>
            <div class="product-detail-info">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p style="font-size: 0.9rem; color: #666;">Category: <?php echo htmlspecialchars($product['category']); ?></p>
                <p class="price-tag">$<?php echo number_format($product['price'], 2); ?></p>
                <div style="margin: 1.5rem 0;">
                    <h3>Description</h3>
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
                <form action="/cart/add" method="POST">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn btn-primary btn-block" style="padding: 1rem;">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>
