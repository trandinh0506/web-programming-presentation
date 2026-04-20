<div class="app-container">
    <div class="page-wrapper">
        <a href="/" class="no-underline color-dark">&larr; Back to Products</a>
        <div class="product-detail-flex">
            <div class="product-detail-image">
                <img src="/uploads/<?php echo $product['image'] ?: 'placeholder.png'; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid rounded">
            </div>
            <div class="product-detail-info">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="text-muted">Category: <?php echo htmlspecialchars($product['category']); ?></p>
                <p class="price-tag">$<?php echo number_format($product['price'], 2); ?></p>
                <div class="m-y-1-5">
                    <h3>Description</h3>
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
                <form action="/cart/add" method="POST">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>
