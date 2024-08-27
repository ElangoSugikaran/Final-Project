<?php
include ("../includes/session.php");
include("../database/dbconnection.php");

$brands = isset($_POST['brands']) ? $_POST['brands'] : [];
$shapes = isset($_POST['shapes']) ? $_POST['shapes'] : [];
$genders = isset($_POST['genders']) ? $_POST['genders'] : [];
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$items_per_page = 9;
$offset = ($page - 1) * $items_per_page;

$query = "SELECT * FROM product WHERE category_name = 3";

if (!empty($brands)) {
  $brand_filter = implode("','", array_map([$conn, 'real_escape_string'], $brands));
  $query .= " AND brands IN ('" . $brand_filter . "')";
}

if (!empty($shapes)) {
  $shape_filter = implode("','", array_map([$conn, 'real_escape_string'], $shapes));
  $query .= " AND shape IN ('" . $shape_filter . "')";
}

if (!empty($genders)) {
  $gender_filter = implode("','", array_map([$conn, 'real_escape_string'], $genders));
  $query .= " AND gender IN ('" . $gender_filter . "')";
}

$query .= " LIMIT $items_per_page OFFSET $offset";

$result = $conn->query($query);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '<div class="col-lg-4 col-md-6 col-sm-6 d-flex">';
    echo '<a href="../Presentation/product-details.php?product_id=' . $row['product_id'] . '">';
    echo '<div class="card w-100 my-2 shadow-2-strong">';
    echo '<img src="../Uploads/' . $row['image_1'] . '" class="card-img-top" style="aspect-ratio: 1 / 1"/>';
    echo '<div class="card-body d-flex flex-column">';
    echo '<div class="d-flex flex-row">';
    echo '<h5 class="mb-1 me-1">Rs' . $row['price'] . '</h5>';
    echo '</div>';
    echo '<p class="card-text">' . $row['product_name'] . '</p>';
    echo '<div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">';
    echo '<a href="../Presentation/product-details.php?product_id=' . $row['product_id'] . '" class="btn btn-primary shadow-0 me-1">Add to cart</a>';
    echo '<a href="../Presentation/wishlist.php?action=add&product_id=' . $row['product_id'] . '" class="btn btn-light border icon-hover px-2 pt-2"><i class="fas fa-heart fa-lg text-secondary px-1"></i></a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }

  // Pagination controls
  $result_total = $conn->query("SELECT COUNT(*) as total FROM product WHERE category_name = 3");
  $total_rows = $result_total->fetch_assoc()['total'];
  $total_pages = ceil($total_rows / $items_per_page);

  echo '<nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">';
  echo '<ul class="pagination">';
  for ($i = 1; $i <= $total_pages; $i++) {
    echo '<li class="page-item ' . (($i == $page) ? 'active' : '') . '">
    <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
    </li>';
  }
  echo '</ul>';
  echo '</nav>';
} else {
  echo '<div class="text-center mb-3">
  No products found.
  </div>';
}
?>
<hr/>