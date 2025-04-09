<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] == 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/db.php';
include '../includes/header.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY created DESC";
$result = mysqli_query($conn, $sql);

// Kiểm tra lỗi truy vấn
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
?>

<div class="container mt-4">
    <h3>🧾 Lịch sử đơn hàng của bạn</h3>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    <?php else: ?>
        <?php while ($order = mysqli_fetch_assoc($result)) : ?>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Đơn hàng #<?php echo $order['id']; ?> - Ngày: <?php echo $order['created']; ?>
                </div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> <?php echo $order['name']; ?></p>
                    <p><strong>SĐT:</strong> <?php echo $order['phone']; ?></p>
                    <p><strong>Địa chỉ:</strong> <?php echo $order['address']; ?></p>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Size</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $order_id = $order['id'];
                            $items = mysqli_query($conn, "
                                SELECT oi.*, p.name
                                FROM order_items oi
                                JOIN products p ON oi.product_id = p.id
                                WHERE oi.order_id = $order_id
                            ");
                            while ($item = mysqli_fetch_assoc($items)) :
                            ?>
                                <tr>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['size']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['price'], 0); ?> VND</td>
                                    <td><?php echo number_format($item['price'] * $item['quantity'], 0); ?> VND</td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <div class="text-end fw-bold">
                        Tổng tiền: <?php echo number_format($order['total'], 0); ?> VND
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
