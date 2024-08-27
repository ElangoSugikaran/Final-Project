<?php
// Start the session
include '../includes/session.php'; // Ensure this is included only once
include("../database/dbconnection.php");

// Check if the user is logged in
$is_logged_in = isset($_SESSION['customer_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
/* Modal Content (Default: Small Search Bar) */
.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 10px;
    width: 300px; /* Start with a small width */
    max-width: 300px; /* Limit the maximum width */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

/* Expanded Modal Content (When Results are Shown) */
.modal-content.expanded {
    width: 80%; /* Expand to a larger width */
    max-width: 900px; /* Limit the maximum width */
    height: auto;
    padding: 30px;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal.show {
    display: block;
    opacity: 1;
}

/* Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}

/* Search Input */
#searchInput {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

/* Search Button */
#searchButton {
    background-color: #2a4dab;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

#searchButton:hover {
    background-color: #1a3490;
}

/* Search Results */
#searchResults {
    margin-top: 20px;
    overflow-y: auto;
}

.search-result-item {
    margin-bottom: 15px;
}

.search-result-item img {
    max-width: 100px;
    height: auto;
    display: block;
}

/* Hover effect */
.nav-link {
    transition: background-color 0.3s, color 0.3s;
  }

  .nav-link:hover {
    background-color: #050C9C; /* Slightly darker background on hover */
    color: #fff; /* Change text color to gold on hover */
    /* text-decoration: underline; Underline text on hover */
  }

  /* Click effect */
  .nav-link:active,
  .nav-link:focus {
    background-color: #14315e; /* Darker background when active */
    color: #ffffff; /* Keep text color white on click */
  }

  </style>
</head>
<body>

<header>
  <!-- Jumbotron -->
  <div class="p-3 text-center bg-white border-bottom">
    <div class="container">
      <div class="row gy-3">
        <!-- Left elements -->
        <div class="col-lg-2 col-sm-4 col-4">
          <a href="home.php" class="float-start">
            <img src="../image/1689353687836-removebg-preview (1).png" class="logo"/>
          </a>
        </div>
        <!-- Left elements -->

        <!-- Center elements -->
        <div class="col-8 d-flex align-items-center">
          <div class="nav-items">
            <!-- Search icon -->
            <a href="#" class="nav-link d-flex align-items-center" id="searchIcon"> 
              <i class="fas fa-search m-1 me-md-2"></i>
            </a>

            <!-- Search modal -->
              <div id="searchModal" class="modal">
                <div class="modal-content">
                  <span class="close" id="closeSearch">&times;</span>
                  <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <input type="text" id="searchInput" placeholder="Search products..." onkeypress="handleKeyPress(event)" style="flex-grow: 1;">
                    <button id="searchButton" onclick="searchProducts()">Search</button>
                  </div>
                  <div id="searchResults"></div>
                </div>
              </div>


            <a href="wishlist.php" class="nav-link d-flex align-items-center"> 
              <i class="fas fa-heart m-1 me-md-2"></i>
            </a>

            <a href="shopping-cart.php" class="nav-link d-flex align-items-center"> 
              <i class="fas fa-shopping-cart m-1 me-md-2"></i>
            </a>


            <!-- Display different content based on login status -->
            <?php if ($is_logged_in): ?>
              <!-- User is logged in: show dropdown with Logout option -->
              <a href="#" class="nav-link d-flex align-items-center dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                <i class="fas fa-user-alt m-1 me-md-2"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="client-dashboard.php">Profile</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              </ul>
            <?php else: ?>
              <!-- User is not logged in: show Login link -->
              <a href="login.php" class="nav-link d-flex align-items-center"> 
                <i class="fas fa-user-alt m-1 me-md-2"></i>
              </a>
            <?php endif; ?>

          </div>
        </div>
        <!-- Center elements -->
      </div>
    </div>
  </div>
  <!-- Jumbotron -->

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background: #2a4dab;">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarCenteredExample"
      aria-controls="navbarCenteredExample"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarCenteredExample">
      <!-- Left links -->
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-white" href="../Presentation/home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../Presentation/frames.php">Frames</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../Presentation/sunglasses.php">SunGlasses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../Presentation/contact-lenes.php">Contact Lenses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../Presentation/brands.php">Brands</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../Presentation/Appointment.php">Appointment</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../Presentation/contact-us.php">Contact us</a>
        </li>      
      </ul>
      <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->
  </div>
  <!-- Container wrapper -->
</nav>
</header>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('searchIcon').addEventListener('click', function() {
    document.getElementById('searchModal').classList.add('show');
    document.querySelector('.modal-content').classList.remove('expanded'); // Start small
});

document.getElementById('closeSearch').addEventListener('click', function() {
    document.getElementById('searchModal').classList.remove('show');
    document.querySelector('.modal-content').classList.remove('expanded');
});

window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('searchModal')) {
        document.getElementById('searchModal').classList.remove('show');
        document.querySelector('.modal-content').classList.remove('expanded');
    }
});

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        searchProducts();
    }
}

function searchProducts() {
    var query = document.getElementById('searchInput').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../Presentation/search-bar.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('searchResults').innerHTML = xhr.responseText;
            document.querySelector('.modal-content').classList.add('expanded'); // Expand when results are shown
        }
    };
    xhr.send('query=' + encodeURIComponent(query));
}

</script>
</body>
</html>
