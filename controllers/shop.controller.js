module.exports = class ShopController {
    constructor(productService, cartService) {
        this.productService = productService;
        this.cartService = cartService;
    }

    getProducts = async (req, res, next) => {
        try {
            const products = await this.productService.fetchAll();
            res.render('shop/product-list', {
                prods: products,
                pageTitle: 'All Products',
                path: '/products'
            });
        } catch (err) {
            console.log(err);
        }
    };

    getProduct = async (req, res, next) => {
        try {
            const prodId = req.params.productId;
            const product = await this.productService.findById(prodId);
            res.render('shop/product-detail', {
                product: product,
                pageTitle: product.title,
                path: '/products'
            });
        } catch (err) {
            console.log(err);
        }
    };

    getIndex = async (req, res, next) => {
        try {
            const products = await this.productService.fetchAll();
            res.render('shop/index', {
                prods: products,
                pageTitle: 'Shop',
                path: '/'
            });
        } catch (err) {
            console.log(err);
        }
    };

    getCart = async (req, res, next) => {
        try {
            const cart = await this.cartService.getCart();
            const products = await this.productService.fetchAll();
            const cartProducts = [];
            if (cart && cart.products) {
                for (const product of products) {
                    const cartProductData = cart.products.find(
                        prod => prod.id === product.id
                    );
                    if (cartProductData) {
                        cartProducts.push({
                            productData: product,
                            qty: cartProductData.qty
                        });
                    }
                }
            }
            res.render('shop/cart', {
                path: '/cart',
                pageTitle: 'Your Cart',
                products: cartProducts,
                totalPrice: cart ? cart.totalPrice : 0
            });
        } catch (err) {
            console.log(err);
        }
    };

    postCart = async (req, res, next) => {
        try {
            const prodId = req.body.productId;
            const product = await this.productService.findById(prodId);
            await this.cartService.addProduct(prodId, product.price);
            res.redirect('/cart');
        } catch (err) {
            console.log(err);
        }
    };

    postCartDecrement = async (req, res, next) => {
        try {
            const prodId = req.body.productId;
            const product = await this.productService.findById(prodId);
            await this.cartService.decrementProduct(prodId, product.price);
            res.redirect('/cart');
        } catch (err) {
            console.log(err);
        }
    };

    postCartDeleteProduct = async (req, res, next) => {
        try {
            const prodId = req.body.productId;
            const product = await this.productService.findById(prodId);
            await this.cartService.deleteProduct(prodId, product.price);
            res.redirect('/cart');
        } catch (err) {
            console.log(err);
        }
    };

    postCartUpdateQuantity = async (req, res, next) => {
        try {
            const prodId = req.body.productId;
            const newQty = +req.body.quantity;
            const product = await this.productService.findById(prodId);
            await this.cartService.updateQuantity(prodId, newQty, product.price);
            res.redirect('/cart');
        } catch (err) {
            console.log(err);
        }
    };
};
