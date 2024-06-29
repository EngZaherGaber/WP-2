<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="./css/home.css" />
  <link rel="stylesheet" href="./css/global.css" />

  <!-- Bootstrap CDN's -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="../assets/logo.png" width="70" alt="Logo" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
          </li>
        </ul>
        <div class="d-flex align-items-center">
          <span class="navbar-text me-3" id="username-display">User Name</span>

          <button class="btn me-2" type="button" id="login-logout-button">
            <a class="link" id="login-logout-link" href="login.php">Login</a>
          </button>
          <button class="btn" type="button">
            <a href="cart.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 6H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 15H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zM4.415 14h8.17l1.28-6.875-9.463-.375L4.415 14zm1.63-8l-1-5h7.961l-1 5H6.045z" />
              </svg>
            </a>
          </button>
        </div>
      </div>
    </div>
  </nav>
  <!-- Carousel -->
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://via.placeholder.com/1200x400" class="d-block w-100" alt="..." />
      </div>
      <div class="carousel-item">
        <img src="https://via.placeholder.com/1200x400" class="d-block w-100" alt="..." />
      </div>
      <div class="carousel-item">
        <img src="https://via.placeholder.com/1200x400" class="d-block w-100" alt="..." />
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- About Us -->
  <div class="container about-us">
    <h2>About Us</h2>
    <p>
      Welcome to our store! We offer a wide range of products to meet your
      needs. Our mission is to provide the best quality products at affordable
      prices. We are committed to excellent customer service and making your
      shopping experience enjoyable.
    </p>
  </div>

  <!-- Main Content -->
  <div class="container mt-5">
    <!-- Featured Products -->
    <h2 class="mb-4">Featured Products</h2>
    <div class="row">
      <div class="col-md-4 featured-product">
        <div class="card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product 1" />
          <div class="card-body">
            <h5 class="card-title">Product 1</h5>
            <p class="card-text">
              This is a description of Product 1. It's an amazing product that
              you'll love.
            </p>
            <p class="card-text">$20.00</p>
            <button class="btn add-to-cart" data-name="Product 1" data-price="20.00">
              Add to Cart
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-4 featured-product">
        <div class="card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product 2" />
          <div class="card-body">
            <h5 class="card-title">Product 2</h5>
            <p class="card-text">
              This is a description of Product 2. It's an amazing product that
              you'll love.
            </p>
            <p class="card-text">$30.00</p>
            <button class="btn add-to-cart" data-name="Product 2" data-price="30.00">
              Add to Cart
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-4 featured-product">
        <div class="card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product 3" />
          <div class="card-body">
            <h5 class="card-title">Product 3</h5>
            <p class="card-text">
              This is a description of Product 3. It's an amazing product that
              you'll love.
            </p>
            <p class="card-text">$25.00</p>
            <button class="btn add-to-cart" data-name="Product 3" data-price="25.00">
              Add to Cart
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Promotions -->
    <h2 class="mt-5 mb-4">Promotions</h2>
    <div class="row">
      <div class="col-md-6 promotion">
        <h4>Summer Sale</h4>
        <p>Get up to 50% off on selected items!</p>
        <a href="#" class="btn">Shop Now</a>
      </div>
      <div class="col-md-6 promotion">
        <h4>New Arrivals</h4>
        <p>Check out the latest products in our store.</p>
        <a href="#" class="btn">Explore</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer mt-5">
    <p>&copy; 2024 HexaShop. All rights reserved.</p>
  </div>
</body>
<script>
  function getCookie(name) {
    let cookieArr = document.cookie.split(";");

    for (let i = 0; i < cookieArr.length; i++) {
      let cookiePair = cookieArr[i].split("=");

      if (name === cookiePair[0].trim()) {
        return decodeURIComponent(cookiePair[1]);
      }
    }
    return null;
  }

  document.addEventListener('DOMContentLoaded', (event) => {
    let userName = getCookie('user');
    const loginLogoutLink = document.getElementById('login-logout-link');
    const loginLogoutButton = document.getElementById('login-logout-button');

    if (userName) {
      document.getElementById('username-display').textContent = userName;
      loginLogoutLink.textContent = 'Logout';
      loginLogoutLink.href = '#'; // Prevent default link behavior

      loginLogoutButton.addEventListener('click', (e) => {
        e.preventDefault();
        var cookies = document.cookie.split("; ");
        for (var c = 0; c < cookies.length; c++) {
          var d = window.location.hostname.split(".");
          while (d.length > 0) {
            var cookieBase = encodeURIComponent(cookies[c].split(";")[0].split("=")[0]) + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; domain=' + d.join('.') + ' ;path=';
            var p = location.pathname.split('/');
            document.cookie = cookieBase + '/';
            while (p.length > 0) {
              document.cookie = cookieBase + p.join('/');
              p.pop();
            };
            d.shift();
          }
        }
        document.cookie = 'user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        window.location.href = 'logout.php';
      });
    } else {
      loginLogoutLink.textContent = 'Login';
      loginLogoutLink.href = 'login.php';
    }
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.js"></script>

</html>