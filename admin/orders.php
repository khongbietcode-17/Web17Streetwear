<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/db.php';
include '../includes/header.php';

// Truy vấn danh sách đơn hàng
$sql_orders = "SELECT * FROM orders ORDER BY created DESC";
$result_orders = mysqli_query($conn, $sql_orders);
?>

<div class="container mt-4">
    <h3>Danh sách đơn hàng</h3>

    <?php while ($order = mysqli_fetch_assoc($result_orders)) : ?>
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                🧾 Đơn hàng #<?php echo $order['id']; ?> - Ngày: <?php echo $order['created']; ?>
            </div>
            <div class="card-body">
                <p><strong>Người mua:</strong> <?php echo $order['name']; ?></p>
                <p><strong>SĐT:</strong> <?php echo $order['phone']; ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo $order['address']; ?></p>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Size</th> <!-- Thêm dòng này -->
                            <th>Đơn giá (VND)</th>
                            <th>Thành tiền (VND)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $order_id = $order['id'];
                        $sql_items = "SELECT order_items.*, products.name 
                                      FROM order_items 
                                      JOIN products ON order_items.product_id = products.id 
                                      WHERE order_items.order_id = $order_id";
                        $items_result = mysqli_query($conn, $sql_items);
                        while ($item = mysqli_fetch_assoc($items_result)) :
                        ?>
                            <tr>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo strtoupper($item['size']); ?></td> <!-- Thêm dòng này -->
                                <td><?php echo number_format($item['price'], 0); ?></td>
                                <td><?php echo number_format($item['price'] * $item['quantity'], 0); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="text-end fw-bold">
                    Tổng tiền: <?php echo number_format($order['total'], 0); ?>.000 VND
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>
