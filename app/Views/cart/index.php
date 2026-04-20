<div class="app-container">
    <div class="page-wrapper">
        <h1>Your Shopping Cart</h1>
        <?php if (empty($products)): ?>
            <p>Your cart is empty. <a href="/">Go shopping!</a></p>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($p['name']); ?></strong>
                        </td>
                        <td>$<?php echo number_format($p['price'], 2); ?></td>
                        <td><?php echo $p['quantity']; ?></td>
                        <td>$<?php echo number_format($p['subtotal'], 2); ?></td>
                        <td>
                            <a href="/cart/remove?id=<?php echo $p['id']; ?>" class="text-danger">Remove</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="font-lg font-bold">
                        <td colspan="3" class="text-right">Total:</td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="mt-2 text-right">
                <a href="/" class="btn">Continue Shopping</a>
                <a href="/checkout" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</div>
