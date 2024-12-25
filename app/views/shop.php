<?php
session_start();
require_once '../Controllers/ShopController.php';
include_once("../model/product.php");
require_once '../DB/DB.php';

// Instantiate the Product class
$product = new Product($conn);

// Fetch all products
$products = $product->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WEB-FIT Shop</title>
  <link rel="stylesheet" href="../../public/css/Shop-Style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include('partials/Navigation-Index.php'); ?>
  <header>
    <h1>WEB-FIT</h1>
    <div class="cart-info">
      <span class="cart-count">0</span> items
      <div id="cart-Btn"><i class="fas fa-shopping-cart"></i></div>
    </div>
  </header>
 
  <main>
    <section id="products">
      <h2>Our Products</h2>
      <div class="product-list">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $product): ?>
            <div class="product-card">
              <div class="product-image">
                <img src="../public/images/default-product.jpg" alt="<?php echo htmlspecialchars($product['productname']); ?>">
              </div>
              <h3 class="product-title"><?php echo htmlspecialchars($product['productname']); ?></h3>
              <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
              <button class="add-to-cart-btn" data-id="<?php echo $product['id']; ?>" 
                      data-name="<?php echo htmlspecialchars($product['productname']); ?>" 
                      data-price="<?php echo $product['price']; ?>">Add to Cart</button>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No products available at the moment.</p>
        <?php endif; ?>
      </div>
    </section>
    <div class="cart-overlay" id="cart-overlay">
      <div class="cart-container">
        <div class="cart-header">
          <h2>Your Cart</h2>
          <span class="cart-close" id="cart-close">&times;</span>
        </div>
        <div class="cart-items" id="cart-items">
        </div>
        <div class="cart-total" id="cart-total">Total: $0.00</div>
        <button id="checkout-btn-cart" class="checkout-btn">Checkout</button>
      </div>
    </div>
  </main>
  <footer>
    <p>&copy; 2024 Web Shop. All rights reserved.</p>
  </footer>
  <script src="../../public/js/Shop-JavaScript.js"></script>
</body>
</html>
