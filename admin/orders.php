<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/db.php';
include '../includes/header.php';

// Lấy dữ liệu đơn hàng
$sql = "SELECT orders.*, users.username, products.name AS product_name 
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        JOIN products ON orders.product_id = products.id 
        ORDER BY orders.created DESC";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

?>

<div class="container mt-4">
    <h3>Danh sách đơn hàng</h3>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Mã đơn</th>
                <th>Người mua</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Tổng tiền (VND)</th>
                <th>Ngày đặt</th>
            </tr>
        </thead>
        <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['total'], 0); ?></td>
            <td><?php echo $row['created']; ?></td>
        </tr>
    <?php endwhile; ?>
</tbody>

    </table>
</div>

<?php include '../includes/footer.php'; ?>
