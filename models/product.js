const fs = require('fs').promises;

module.exports = class Product {
  constructor(filePath) {
    this.filePath = filePath;
  }

  async getProductsFromFile() {
    try {
      const fileContent = await fs.readFile(this.filePath);
      return JSON.parse(fileContent);
    } catch (err) {
      return [];
    }
  }

  async save(productData) {
    const products = await this.getProductsFromFile();
    if (productData.id) {
      const existingProductIndex = products.findIndex(
        prod => prod.id === productData.id
      );
      const updatedProducts = [...products];
      updatedProducts[existingProductIndex] = productData;
      await fs.writeFile(this.filePath, JSON.stringify(updatedProducts));
    } else {
      productData.id = Math.random().toString();
      products.push(productData);
      await fs.writeFile(this.filePath, JSON.stringify(products));
    }
  }

  async fetchAll() {
    return await this.getProductsFromFile();
  }

  async findById(id) {
    const products = await this.getProductsFromFile();
    return products.find(p => p.id === id);
  }
};
