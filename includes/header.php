<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '/vertrigo/banquanao/');
}

// Lấy tên trang hiện tại
$current_page = basename($_SERVER['PHP_SELF']);
$hidden_cart_pages = array('login.php', 'register.php', 'add_product.php', 'orders.php');

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Shop Streetwear</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">SEVENTEEN STREETWEAR SHOP</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>admin/add_product.php">➕ Thêm sản phẩm</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>admin/orders.php">📦 Đơn hàng</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>admin/list_product.php">Danh sách sản phẩm</a>
          </li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto align-items-center">
        <?php if (!in_array($current_page, $hidden_cart_pages)): ?>
        <li class="nav-item">
          <a class="nav-link position-relative" href="<?php echo BASE_URL; ?>cart/view.php">
            🛒 Giỏ hàng
            <?php 
              if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                echo '<span class="badge bg-danger">'.count($_SESSION['cart']).'</span>';
              }
            ?>
          </a>
        </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item">
            <span class="nav-link">👤 Xin chào, <strong><?php echo $_SESSION['username']; ?></strong></span>
          </li>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] != 'admin'): ?>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo BASE_URL; ?>pages/order_history.php">🧾 Lịch sử đặt hàng</a>
  </li>
<?php endif; ?>

          <li class="nav-item">
            <a class="nav-link text-danger" href="<?php echo BASE_URL; ?>logout.php">Đăng xuất</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Đăng ký</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Đăng nhập</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
