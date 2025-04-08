<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Tạo giỏ nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Nếu đã có sản phẩm này thì tăng số lượng
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id] = array(
                'id'       => $product['id'],
                'name'     => $product['name'],
                'price'    => $product['price'],
                'image'    => $product['image'],
                'quantity' => 1
            );
        }

        $_SESSION['message'] = "Đã thêm <strong>{$product['name']}</strong> vào giỏ hàng!";
    }
}

header("Location: ../pages/product_detail.php?id=$id");
exit;
