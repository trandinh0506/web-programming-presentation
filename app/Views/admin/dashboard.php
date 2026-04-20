<div class="app-container flex-column">
    <div class="page-wrapper mb-2">
        <h1>Admin Dashboard</h1>
        <h3>Add New Product</h3>
        <form action="/admin/products/store" method="POST" enctype="multipart/form-data">
            <div class="filter-group">
                <label>Name:</label>
                <input type="text" name="name" required class="filter-input">
            </div>
            <div class="filter-group">
                <label>Price:</label>
                <input type="number" step="0.01" name="price" required class="filter-input">
            </div>
            <div class="filter-group">
                <label>Category:</label>
                <input type="text" name="category" required class="filter-input">
            </div>
            <div class="filter-group">
                <label>Description:</label>
                <textarea name="description" class="filter-input" rows="4"></textarea>
            </div>
            <div class="filter-group">
                <label>Image:</label><br>
                <input type="file" name="image" required>
            </div>
            <button type="submit" class="btn">Save Product</button>
        </form>
    </div>

    <div class="page-wrapper">
        <h3>Manage Products</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td>$<?php echo number_format($p['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($p['category']); ?></td>
                    <td>
                        <a href="/admin/products/edit?id=<?php echo $p['id']; ?>">Edit</a> | 
                        <a href="/admin/products/delete?id=<?php echo $p['id']; ?>" class="text-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
