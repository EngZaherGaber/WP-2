<?php
include('config.php');


$response = ['success' => false, 'message' => 'Invalid request.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $product_id = $data['product_id'];
    $action = $data['action'];
    $user_id = $_SESSION['user_id'];

    // Retrieve the current quantity from the database
    $stmt = $conn->prepare("SELECT quantity FROM orders WHERE user_id = ? AND product_id = ? AND isSubmitted = 0");
    $stmt->execute([$user_id, $product_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        $quantity = $order['quantity'];
        if ($action === 'increment') {
            $quantity++;
        } elseif ($action === 'decrement' && $quantity > 1) {
            $quantity--;
        } else {
            $response['message'] = 'Quantity cannot be less than 1.';
            echo json_encode($response);
            exit();
        }

        // Update the quantity in the database
        $stmt = $conn->prepare("UPDATE orders SET quantity = ? WHERE user_id = ? AND product_id = ? AND isSubmitted = 0");
        $stmt->execute([$quantity, $user_id, $product_id]);

        $response['success'] = true;
        $response['message'] = 'Cart updated successfully.';
    } else {
        $response['message'] = 'Product not found in cart.';
    }
} else {
    $response['message'] = 'User not logged in.';
}

header('Content-Type: application/json');
echo json_encode($response);
