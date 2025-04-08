<?php
session_start();
include '../includes/header.php';
?>

<div class="container mt-4">
    <h3>🛒 Giỏ hàng của bạn</h3>

    <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">Giỏ hàng đang trống. <a href="../index.php">Quay lại mua sắm</a></div>
    <?php else: ?>
        <table class="table table-bordered text-center align-middle mt-3">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><img src="../img/<?php echo $item['image']; ?>" width="80"></td>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo number_format($item['price'], 0); ?> VND</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($subtotal, 0); ?> VND</td>
                    <td>
                        <a href="remove.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Tổng cộng</th>
                    <th colspan="2" class="text-danger"><?php echo number_format($total, 0); ?> VND</th>
                </tr>
            </tfoot>
        </table>

        <div class="text-end">
            <a href="checkout.php" class="btn btn-success">🧾 Thanh toán</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
