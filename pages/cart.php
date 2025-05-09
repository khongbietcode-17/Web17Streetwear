<?php
session_start();
include '../includes/db.php'; // đường dẫn nếu cart.php nằm trong /pages

$user_id = 1; // giả sử đã đăng nhập với user_id = 1

// Cập nhật số lượng nếu có post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    foreach ($_POST['qty'] as $cart_id => $quantity) {
        $quantity = (int)$quantity;
        mysqli_query($conn, "UPDATE cart SET quantity = $quantity WHERE id = $cart_id AND user_id = $user_id");
    }
}

// Xoá sản phẩm khỏi giỏ
if (isset($_GET['delete'])) {
    $cart_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id");
    header("Location: cart.php");
}

// Lấy sản phẩm trong giỏ
$query = "SELECT cart.id AS cart_id, products.*, cart.quantity 
          FROM cart 
          JOIN products ON cart.product_id = products.id 
          WHERE cart.user_id = $user_id";
$result = mysqli_query($conn, $query);
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Giỏ hàng của bạn</h2>
    <form method="POST">
        <table class="table table-bordered">
            <tr>
                <th>Hình ảnh</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
                <th>Xoá</th>
            </tr>
            <?php
            $total = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
                echo "<tr>
                        <td><img src='../img/{$row['image']}' width='60'></td>
                        <td>{$row['name']}</td>
                        <td>".number_format($row['price'])." VND</td>
                        <td>
                            <input type='number' name='qty[{$row['cart_id']}]' value='{$row['quantity']}' min='1' class='form-control' style='width: 80px;'>
                        </td>
                        <td>".number_format($subtotal)." VND</td>
                        <td><a href='cart.php?delete={$row['cart_id']}' class='btn btn-danger btn-sm'>Xoá</a></td>
                      </tr>";
            }
            session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

            ?>
        </table>
        <div class="text-end">
            <h4>Tổng cộng: <?= number_format($total) ?> VND</h4>
            <button type="submit" name="update" class="btn btn-primary">Cập nhật giỏ hàng</button>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
