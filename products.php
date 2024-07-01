<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'add_to_cart') {
  if (isset($_SESSION['user_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the product already exists in the cart for the user
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? AND product_id = ? AND isSubmitted = 0");
    $stmt->execute([$user_id, $product_id]);
    $existing_order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_order) {
      $response = [
        'success' => false,
        'message' => 'Item already exists in your cart.'
      ];
    } else {
      // Retrieve product details from database
      $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
      $stmt->execute([$product_id]);
      $product = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($product) {
        // Insert into orders table in database
        $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, isSubmitted) VALUES (?, ?, ?, 0)");
        $stmt->execute([$user_id, $product_id, 1]); // Assuming initial quantity is 1

        // Prepare success response
        $response = [
          'success' => true,
          'message' => 'Item added to cart and database successfully.'
        ];
      } else {
        $response = [
          'success' => false,
          'message' => 'Product not found.'
        ];
      }
    }
  } else {
    // Handle case where user is not logged in or session is not set
    $response = [
      'success' => false,
      'message' => 'Please login to add items to your cart.'
    ];
  }

  header('Content-Type: application/json');
  echo json_encode($response);
  exit();
}
// Fetch products from the database
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$isLoggedIn = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Products</title>
  <link rel="stylesheet" href="./css/global.css" />

  <!-- Bootstrap CDN's -->
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


  <div class="container mt-5">
    <!-- Featured Products -->
    <h2 class="mb-4">Featured Products</h2>
    <h2 class="mb-4"><?php echo $_SESSION['user_id'] ?></h2>
    <div class="row">
      <?php foreach ($products as $product) : ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $product['name']; ?></h5>
              <p class="card-text"><?php echo $product['description']; ?></p>
              <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>
              <?php if ($isLoggedIn) : ?>
                <button type="button" class="btn btn-primary add-to-cart" id="product_<?php echo $product['product_id']; ?>" onclick="addToCart(<?php echo htmlspecialchars(json_encode($product)); ?>)" data-product-id="<?php echo $product['product_id']; ?>" data-name="<?php echo htmlspecialchars($product['name']); ?>" data-price="<?php echo $product['price']; ?>">
                  Add to Cart
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>



  <!-- Footer -->
  <div class="footer mt-5">
    <p>&copy; 2024 HexaShop. All rights reserved.</p>
  </div>
</body>





<script>
  // Function to handle adding to cart via AJAX
  function addToCart(product) {
    fetch(`index.php?action=add_to_cart&product_id=${product.product_id}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Add item to localStorage (client-side cart)
          let item = {
            product_id: product.product_id,
            name: product.name,
            description: product.description,
            price: product.price,
            image_url: product.image_url,
            quantity: 1 // Assuming initial quantity is 1
          };

          let cart = JSON.parse(localStorage.getItem('cart')) || [];
          cart.push(item);
          localStorage.setItem('cart', JSON.stringify(cart));

          // Update UI (optional)
          alert('Item added to cart successfully!');
          updateCartCount();
        } else {
          alert(data.message); // Display error message
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let length = parseInt(document.getElementById('cart-count').innerText);
    document.getElementById('cart-count').innerText = length + 1;
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>