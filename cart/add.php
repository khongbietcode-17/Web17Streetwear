<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;
    $size = isset($_POST['size']) ? $_POST['size'] : 'M'; // Mặc định là M nếu không chọn

    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Tạo key riêng biệt cho mỗi sản phẩm theo size
        $cartKey = $id . '_' . $size;

        if (isset($_SESSION['cart'][$cartKey])) {
            $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$cartKey] = array(
                'id'       => $product['id'],
                'name'     => $product['name'],
                'price'    => $product['price'],
                'image'    => $product['image'],
                'quantity' => $quantity,
                'size'     => $size
            );
        }

        $_SESSION['message'] = "✅ Đã thêm <strong>{$product['name']}</strong> (Size: $size - x$quantity) vào giỏ hàng!";
    }
}

header("Location: ../pages/product_detail.php?id=$id");
exit;
