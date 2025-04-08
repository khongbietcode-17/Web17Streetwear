<?php
session_start();
include '../includes/header.php';
include '../includes/db.php'; // Kết nối CSDL

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

    foreach ($cart as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $total = $item['price'] * $quantity;

        $sql = "INSERT INTO orders (user_id, product_id, quantity, total, name, phone, address, created)
        VALUES ('$user_id', '$product_id', '$quantity', '$total', '$name', '$phone', '$address', NOW())";


        if (!mysqli_query($conn, $sql)) {
            echo "Lỗi khi lưu đơn hàng: " . mysqli_error($conn);
            exit;
        }
    }

    // Xóa giỏ hàng sau khi đặt
    unset($_SESSION['cart']);

    echo "<script>alert('Đặt hàng thành công!'); window.location.href = '../index.php';</script>";
    exit;
}
?>

<div class="container mt-4">
    <h3>🧾 Thông tin giao hàng</h3>
    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="col-12">
            <label class="form-label">Địa chỉ</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">✅ Xác nhận đặt hàng</button>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
