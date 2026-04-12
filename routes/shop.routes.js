const express = require('express');

module.exports = (shopController) => {
    const router = express.Router();

    router.get('/', shopController.getIndex);

    router.get('/products', shopController.getProducts);

    router.get('/products/:productId', shopController.getProduct);

    router.get('/cart', shopController.getCart);

    router.post('/cart', shopController.postCart);

    router.post('/cart-decrement-item', shopController.postCartDecrement);

    router.post('/cart-delete-item', shopController.postCartDeleteProduct);

    router.post('/cart-update-quantity', shopController.postCartUpdateQuantity);

    return router;
};
