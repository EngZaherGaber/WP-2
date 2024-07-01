<?php
session_start();

// Include database connection or configuration file
include('includes/config.php'); // Adjust path as per your file structure

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted for order confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    $user_id = $_SESSION['user_id'];
    $cart_items = $_SESSION['cart'];

    try {
        // Start transaction
        $conn->beginTransaction();

        // Insert each cart item into orders table
        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, isSubmitted) VALUES (?, ?, ?, 0)");
            $stmt->execute([$user_id, $product_id, $quantity]);
        }

        // Commit transaction if all queries succeed
        $conn->commit();

        // Clear session cart after successful order confirmation
        unset($_SESSION['cart']);

        // Redirect to a success page or back to cart with success message
        header("Location: cart.php?order_success=1");
        exit();
    } catch (PDOException $e) {
        // Rollback transaction if any query fails
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect back to cart page if accessed without form submission
    header("Location: cart.php");
    exit();
}
