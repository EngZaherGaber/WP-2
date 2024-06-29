<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/cart.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-custom">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Brand</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
          <form class="d-flex">
            <button class="btn btn-outline-light me-2" type="button">
              Login
            </button>
            <button
              class="btn btn-outline-light"
              type="button"
              id="cart-button"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-cart"
                viewBox="0 0 16 16"
              >
                <path
                  d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 6H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 15H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zM4.415 14h8.17l1.28-6.875-9.463-.375L4.415 14zm1.63-8l-1-5h7.961l-1 5H6.045z"
                />
              </svg>
              <span id="cart-count" class="badge bg-danger">0</span>
            </button>
          </form>
        </div>
      </div>
    </nav>

    <!-- Cart Content -->
    <div class="container mt-5">
      <h2 class="mb-4">Shopping Cart</h2>
      <div id="cart-items" class="mb-5"></div>
      <div id="cart-total" class="text-end"></div>
      <div class="text-end">
        <button class="btn" onclick="clearCart()">Clear Cart</button>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer mt-5">
      <p>&copy; 2024 Brand. All rights reserved.</p>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        updateCartCount();
        displayCartItems();
      });

      function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        document.getElementById('cart-count').innerText = cart.length;
      }

      function displayCartItems() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = '';

        let total = 0;

        cart.forEach((item) => {
          total += item.price;
          cartItemsContainer.innerHTML += `
                  <div class="card mb-3">
                      <div class="row g-0">
                          <div class="col-md-4">
                              <img src="${
                                item.image
                              }" class="img-fluid rounded-start" alt="${
            item.name
          }">
                          </div>
                          <div class="col-md-8">
                              <div class="card-body">
                                  <h5 class="card-title">${item.name}</h5>
                                  <p class="card-text">${item.description}</p>
                                  <p class="card-text"><small class="text-muted">$${item.price.toFixed(
                                    2
                                  )}</small></p>
                              </div>
                          </div>
                      </div>
                  </div>
              `;
        });

        document.getElementById(
          'cart-total'
        ).innerHTML = `<h4>Total: $${total.toFixed(2)}</h4>`;
      }

      function clearCart() {
        localStorage.removeItem('cart');
        updateCartCount();
        displayCartItems();
      }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
