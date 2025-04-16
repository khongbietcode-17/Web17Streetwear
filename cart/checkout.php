<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Vui lòng đăng nhập để thanh toán.'); window.location.href = '../login.php';</script>";
    exit;
}

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Giỏ hàng trống.'); window.location.href = '../index.php';</script>";
    exit;
}

// Khi người dùng bấm nút "Xác nhận đặt hàng"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $user_id = $_SESSION['user_id'];
    $cart = $_SESSION['cart'];

    // Tính tổng tiền đơn hàng
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Lưu đơn hàng vào bảng orders
    $sql_order = "INSERT INTO orders (user_id, total, name, phone, address, created) 
                  VALUES ('$user_id', '$total', '$name', '$phone', '$address', NOW())";

    if (mysqli_query($conn, $sql_order)) {
        $order_id = mysqli_insert_id($conn); // Lấy ID đơn hàng vừa tạo

        // Lưu từng sản phẩm vào bảng order_items
        foreach ($cart as $item) {
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $size =$item['size'];

            $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price, size)
                         VALUES ('$order_id', '$product_id', '$quantity', '$price','$size')";

            if (!mysqli_query($conn, $sql_item)) {
                echo "Lỗi khi lưu chi tiết đơn hàng: " . mysqli_error($conn);
                exit;
            }
        }

        // Xóa giỏ hàng sau khi đặt
        unset($_SESSION['cart']);

        echo "<script>alert('Đặt hàng thành công!'); window.location.href = '../index.php';</script>";
        exit;
    } else {
        echo "Lỗi khi lưu đơn hàng: " . mysqli_error($conn);
    }
}
?>

<link rel="stylesheet" href="../css/checkout.css"> <!-- THÊM LINK CSS -->

<div class="container">
    <div class="checkout-container">
      
        <div class="checkout-image">
        <video autoplay muted loop>
    <source src="../video/ship.mp4" type="video/mp4">
    Trình duyệt không hỗ trợ video.
</video>
        </div>

        <!-- BÊN PHẢI: FORM THANH TOÁN -->
        <div class="checkout-form">
            <h3>🧾 Thông tin giao hàng</h3>
            <form method="POST" class="row g-3">
                <div class="col-12">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-12 text-end">
                    <button type="submit">Xác nhận đặt hàng</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>
