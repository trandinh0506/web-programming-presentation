<div class="app-container">
    <div class="page-wrapper">
        <h1>Edit Product</h1>
        <a href="/admin/dashboard" class="no-underline color-dark">&larr; Back to Dashboard</a>
        
        <form action="/admin/products/update" method="POST" enctype="multipart/form-data" class="mt-1-5">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            
            <div class="filter-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required class="filter-input">
            </div>
            
            <div class="filter-group">
                <label>Price:</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required class="filter-input">
            </div>
            
            <div class="filter-group">
                <label>Category:</label>
                <input type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required class="filter-input">
            </div>
            
            <div class="filter-group">
                <label>Description:</label>
                <textarea name="description" class="filter-input" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            
            <div class="filter-group">
                <label>Current Image:</label><br>
                <img src="/uploads/<?php echo $product['image'] ?: 'placeholder.png'; ?>" alt="Product Image" class="img-thumbnail rounded-sm mb-1"><br>
                <label>Change Image (optional):</label><br>
                <input type="file" name="image">
            </div>
            
            <button type="submit" class="btn">Update Product</button>
        </form>
    </div>
</div>
