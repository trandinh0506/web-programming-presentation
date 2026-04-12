const fs = require('fs').promises;

module.exports = class Cart {
    constructor(filePath) {
        this.filePath = filePath;
    }

    async addProduct(id, productPrice) {
        let cart = { products: [], totalPrice: 0 };
        try {
            const fileContent = await fs.readFile(this.filePath);
            cart = JSON.parse(fileContent);
        } catch (err) { }

        const existingProductIndex = cart.products.findIndex(
            prod => prod.id === id
        );
        const existingProduct = cart.products[existingProductIndex];
        let updatedProduct;
        if (existingProduct) {
            updatedProduct = { ...existingProduct };
            updatedProduct.qty = updatedProduct.qty + 1;
            cart.products = [...cart.products];
            cart.products[existingProductIndex] = updatedProduct;
        } else {
            updatedProduct = { id: id, qty: 1 };
            cart.products = [...cart.products, updatedProduct];
        }
        cart.totalPrice = cart.totalPrice + +productPrice;
        await fs.writeFile(this.filePath, JSON.stringify(cart));
    }

    async decrementProduct(id, productPrice) {
        try {
            const fileContent = await fs.readFile(this.filePath);
            const cart = JSON.parse(fileContent);
            const productIndex = cart.products.findIndex(prod => prod.id === id);
            const product = cart.products[productIndex];
            if (!product) {
                return;
            }
            if (product.qty > 1) {
                product.qty = product.qty - 1;
                cart.products[productIndex] = product;
            } else {
                cart.products = cart.products.filter(prod => prod.id !== id);
            }
            cart.totalPrice = cart.totalPrice - +productPrice;
            await fs.writeFile(this.filePath, JSON.stringify(cart));
        } catch (err) { }
    }

    async deleteProduct(id, productPrice) {
        try {
            const fileContent = await fs.readFile(this.filePath);
            const updatedCart = JSON.parse(fileContent);
            const product = updatedCart.products.find(prod => prod.id === id);
            if (!product) {
                return;
            }
            const productQty = product.qty;
            updatedCart.products = updatedCart.products.filter(
                prod => prod.id !== id
            );
            updatedCart.totalPrice =
                updatedCart.totalPrice - productPrice * productQty;

            await fs.writeFile(this.filePath, JSON.stringify(updatedCart));
        } catch (err) { }
    }

    async updateQuantity(id, newQty, productPrice) {
        try {
            const fileContent = await fs.readFile(this.filePath);
            const cart = JSON.parse(fileContent);
            const productIndex = cart.products.findIndex(prod => prod.id === id);
            const product = cart.products[productIndex];
            if (!product) {
                return;
            }
            const oldQty = product.qty;
            const diff = newQty - oldQty;
            product.qty = newQty;
            cart.products[productIndex] = product;
            cart.totalPrice += diff * productPrice;

            await fs.writeFile(this.filePath, JSON.stringify(cart));
        } catch (err) { }
    }

    async getCart() {
        try {
            const fileContent = await fs.readFile(this.filePath);
            return JSON.parse(fileContent);
        } catch (err) {
            return { products: [], totalPrice: 0 };
        }
    }
};
