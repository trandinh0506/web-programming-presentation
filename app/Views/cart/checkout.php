<div class="app-container">
    <div class="page-wrapper">
        <h1>Checkout Confirmation</h1>
        <div class="checkout-summary">
            <h3>Order Summary</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($p['name']); ?></strong></td>
                        <td>$<?php echo number_format($p['price'], 2); ?></td>
                        <td><?php echo $p['quantity']; ?></td>
                        <td>$<?php echo number_format($p['subtotal'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="font-lg font-bold">
                        <td colspan="3" class="text-right">Total:</td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-2">
            <h3>Shipping Information</h3>
            <p>We'll shipping to you as soon as possible.</p>
        </div>

        <form action="/checkout" method="POST" class="mt-2 text-right">
            <a href="/cart" class="btn">Back to Cart</a>
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    </div>
</div>
