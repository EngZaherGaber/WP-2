<?php
session_start();

// Check if product_id is provided via GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'add_to_cart') {
    if (isset($_SESSION['user_id'])) {
        $product_id = $_GET['product_id'];
        $user_id = $_SESSION['user_id'];

        // Retrieve product details from database
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Insert into orders table in database
            $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, isSubmitted) VALUES (?, ?, ?, 0)");
            $stmt->execute([$user_id, $product_id, 1]); // Assuming initial quantity is 1

            // Prepare response
            $response = [
                'success' => true,
                'message' => 'Item added to cart and database successfully.'
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    } else {
        // Handle case where user is not logged in or session is not set
        $response = [
            'success' => false,
            'message' => 'Please login to add items to your cart.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}
