<?php
require_once("../Controllers/Controller.php");
require_once '../model/product.php';
require_once '../model/cart.php';

class ShopController
{
    private $productModel;
    private $cart;

    public function __construct($conn, $user)
    {
        // Initialize the product model and cart
        $this->productModel = new Product($conn);
        $this->cart = new Cart($user);
    }

    /**
     * Get all products for display in the shop.
     *
     * @return array The list of products.
     */
    public function getAllProducts()
    {
        return $this->productModel->getAllProducts();
    }

    /**
     * Add a product to the user's cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return bool|string
     */
    public function addProductToCart($productId, $quantity = 1)
    {
        return $this->cart->addItem($productId, $quantity);
    }

    /**
     * Remove a product from the user's cart.
     *
     * @param int $productId
     * @return bool|string
     */
    public function removeProductFromCart($productId)
    {
        return $this->cart->removeItem($productId);
    }

    /**
     * Update the quantity of a product in the user's cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return bool|string
     */
    public function updateCartItemQuantity($productId, $quantity)
    {
        return $this->cart->updateItemQuantity($productId, $quantity);
    }

    /**
     * Get all items in the user's cart.
     *
     * @return array|string The list of cart items.
     */
    public function getCartItems()
    {
        return $this->cart->getCartItems();
    }

    /**
     * Clear the user's cart.
     *
     * @return bool|string
     */
    public function clearCart()
    {
        return $this->cart->clearCart();
    }
}

?>
