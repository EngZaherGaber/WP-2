<?php
include('config.php');


$response = ['success' => false, 'message' => 'Invalid request.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  $action = $data['action'];

  if ($action === 'update_cart') {
    if (isset($_SESSION['user_id'])) {
      $product_id = $data['product_id'];
      $action = $data['update_action'];
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
  } elseif ($action === 'clear_cart') {
    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $stmt = $conn->prepare("DELETE FROM orders WHERE user_id = ? AND isSubmitted = 0");
      $stmt->execute([$user_id]);

      $response['success'] = true;
      $response['message'] = 'Cart cleared successfully.';
    } else {
      $response['message'] = 'User not logged in.';
    }
  } elseif ($action === 'confirm_order') {
    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $stmt = $conn->prepare("UPDATE orders SET isSubmitted = 1 WHERE user_id = ? AND isSubmitted = 0");
      $stmt->execute([$user_id]);

      $response['success'] = true;
      $response['message'] = 'Order confirmed successfully.';
    } else {
      $response['message'] = 'User not logged in.';
    }
  }

  header('Content-Type: application/json');
  echo json_encode($response);
  exit();
}

// Fetch products from the database
$stmt = $conn->prepare("SELECT p.*, o.quantity FROM orders o JOIN products p ON o.product_id = p.product_id WHERE o.isSubmitted = 0 AND o.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cart</title>
  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/cart.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
  <!-- Navigation Menu -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Brand</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
          </li>
        </ul>
        <form class="d-flex">
          <?php if ($isLoggedIn) : ?>
            <span class="navbar-text me-2">Hello, <?php echo $_SESSION['username']; ?></span>
            <button class="btn btn-outline-light" type="button" id="cart-button">
              <a href="cart.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                  <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 6H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 15H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zM4.415 14h8.17l1.28-6.875-9.463-.375L4.415 14zm1.63-8l-1-5h7.961l-1 5H6.045z" />
                </svg>
                <li class="nav-item">
                  <a class="nav-link" href="cart.php">
                    <?php
                    // Count orders not submitted yet
                    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM orders WHERE user_id = ? AND isSubmitted = 0");
                    $stmt->execute([$_SESSION['user_id']]);
                    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                    echo "<span class='badge bg-danger' id='cart-count'>$count</span>";
                    ?>
                  </a>
                </li>
              </a>
            </button>
            <button class="btn btn-outline-light" type="button" onclick="location.href='logout.php'">Logout</button>
          <?php else : ?>
            <button class="btn btn-outline-light me-2" type="button" onclick="location.href='login.php'">Login</button>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </nav>

  <!-- Cart Content -->
  <div class="container mt-5">
    <h2 class="mb-4">Shopping Cart</h2>
    <div id="cart-items" class="mb-5">
      <?php foreach ($products as $product) : ?>
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="${item.image_url}" class="img-fluid rounded-start" alt="<?php echo $product['name']; ?>">
            </div>
            <div class="col-md-8">
              <div class="card-body" data-product-id="<?php echo $product['product_id']; ?>">
                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                <p class="card-text"><?php echo $product['description']; ?></p>
                <p class="card-text"><small class="text-muted">$<?php echo number_format($product['price'], 2); ?></small></p>
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-secondary" onclick="updateCartItem(<?php echo htmlspecialchars(json_encode($product['product_id'])); ?>, 'decrement')">-</button>
                  <span class="btn btn-light"><?php echo number_format($product['quantity'], 2); ?></span>
                  <button type="button" class="btn btn-secondary" onclick="updateCartItem(<?php echo htmlspecialchars(json_encode($product['product_id'])); ?>, 'increment')">+</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div id="cart-total" class="text-end"></div>
    <div class="text-end">
      <button class="btn btn-danger" onclick="clearCart()">Clear Cart</button>
      <button class="btn btn-success" onclick="confirmOrder()">Confirm Order</button>
    </div>
  </div>


  <!-- Footer -->
  <div class="footer mt-5">
    <p>&copy; 2024 Brand. All rights reserved.</p>
  </div>

  <script>
    function updateCartItem(productId, action) {
      debugger
      fetch('cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            action: 'update_cart',
            product_id: productId,
            update_action: action
          })
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            debugger
            // Find the product card element
            const productCard = document.querySelector(`[data-product-id="${productId}"]`);
            const quantitySpan = productCard.querySelector('.btn-light');
            const priceElement = productCard.querySelector('.card-text small');

            // Update the quantity and price in the DOM
            let quantity = parseInt(quantitySpan.innerText);
            const price = parseFloat(priceElement.innerText.replace('$', ''));

            if (action === 'increment') {
              quantity++;
            } else if (action === 'decrement' && quantity > 1) {
              quantity--;
            }

            quantitySpan.innerText = quantity;

            // Update the total price
            const totalElement = document.getElementById('cart-total');
            const currentTotal = parseFloat(totalElement.innerText.replace('Total: $', ''));
            const newTotal = action === 'increment' ? currentTotal + price : currentTotal - price;
            totalElement.innerText = `Total: $${newTotal.toFixed(2)}`;
          } else {
            console.error(data.message);
          }
        })
        .catch(error => {
          console.error('Failed to update cart item:', error);
        });
    }

    function clearCart() {
      fetch('cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            action: 'clear_cart'
          })
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            document.getElementById('cart-items').innerHTML = '';
            document.getElementById('cart-total').innerText = 'Total: $0.00';
          } else {
            console.error(data.message);
          }
        })
        .catch(error => {
          console.error('Failed to clear cart:', error);
        });
    }

    function confirmOrder() {
      fetch('cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            action: 'confirm_order'
          })
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            alert('Order confirmed!');
            document.getElementById('cart-items').innerHTML = '';
            document.getElementById('cart-total').innerText = 'Total: $0.00';
          } else {
            console.error(data.message);
          }
        })
        .catch(error => {
          console.error('Failed to confirm order:', error);
        });
    }
  </script>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>