<?php
require_once __DIR__ . '/model.php';
class Cart extends Model
{
    private $user;

    public function __construct($user)
    {
        // Call the parent constructor to initialize database connection
        $this->connect();
        $this->user = $user;
    }

    /**
     * Add an item to the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return bool|string
     */
    public function addItem($productId, $quantity = 1)
    {
        try {
            // Check if the item already exists in the cart
            $sql = "SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $this->user->getId(), $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update the quantity if the item exists
                $row = $result->fetch_assoc();
                $newQuantity = $row['quantity'] + $quantity;
                $updateSql = "UPDATE cart_items SET quantity = ? WHERE id = ?";
                $updateStmt = $this->conn->prepare($updateSql);
                $updateStmt->bind_param("ii", $newQuantity, $row['id']);
                return $updateStmt->execute();
            } else {
                // Insert a new item if it doesn't exist
                $insertSql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)";
                $insertStmt = $this->conn->prepare($insertSql);
                $insertStmt->bind_param("iii", $this->user->getId(), $productId, $quantity);
                return $insertStmt->execute();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove an item from the cart.
     *
     * @param int $productId
     * @return bool|string
     */
    public function removeItem($productId)
    {
        try {
            $sql = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $this->user->getId(), $productId);
            return $stmt->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the quantity of an item in the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return bool|string
     */
    public function updateItemQuantity($productId, $quantity)
    {
        try {
            $sql = "UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $quantity, $this->user->getId(), $productId);
            return $stmt->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get all items in the user's cart.
     *
     * @return array|string
     */
    public function getCartItems()
    {
        try {
            $sql = "SELECT cart_items.product_id, cart_items.quantity, products.name, products.price 
                    FROM cart_items 
                    JOIN products ON cart_items.product_id = products.id 
                    WHERE cart_items.user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $this->user->getId());
            $stmt->execute();
            $result = $stmt->get_result();

            $items = [];
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }

            return $items;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Clear all items from the cart.
     *
     * @return bool|string
     */
    public function clearCart()
    {
        try {
            $sql = "DELETE FROM cart_items WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $this->user->getId());
            return $stmt->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
?>
