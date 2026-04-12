const path = require('path');
const express = require('express');
const bodyParser = require('body-parser');

// Import Classes
const ProductModel = require('./models/product');
const CartModel = require('./models/cart');
const ShopController = require('./controllers/shop.controller');
const shopRoutes = require('./routes/shop.routes');

const app = express();

app.set('view engine', 'ejs');
app.set('views', 'views');

// Paths
const productsPath = path.join(__dirname, 'data', 'products.json');
const cartPath = path.join(__dirname, 'data', 'cart.json');

// Dependency Injection
const productService = new ProductModel(productsPath);
const cartService = new CartModel(cartPath);
const shopController = new ShopController(productService, cartService);

app.use(express.urlencoded({ extended: false }));
app.use(express.static(path.join(__dirname, 'public')));

// Routing
app.use(shopRoutes(shopController));

app.use((req, res, next) => {
    res.status(404).render('404', { pageTitle: 'Page Not Found', path: '' });
});

app.listen(3000, () => {
    console.log('Server is running on http://localhost:3000');
});
