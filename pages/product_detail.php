<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Không tìm thấy sản phẩm.</div></div>";
    include '../includes/footer.php';
    exit;
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");

if (mysqli_num_rows($result) == 0) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Sản phẩm không tồn tại.</div></div>";
    include '../includes/footer.php';
    exit;
}

$product = mysqli_fetch_assoc($result);
?>
<link rel="stylesheet" href="../css/style_productdetail.css">
<div class="container mt-4">
    <div class="row">
        <div class="col-md-5">
            <img src="../img/<?php echo $product['image']; ?>" class="img-fluid rounded shadow" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="col-md-7">
            <h3><?php echo $product['name']; ?></h3>
            <h4 class="text-danger"><?php echo number_format($product['price'], 0); ?>.000 VND</h4>
            <p><strong>Loại:</strong>
        <?php
        switch ($product['category']) {
            case 'ao_thun':
                echo 'Áo thun';
                break;
            case 'ao_somi':
                echo 'Sơ Mi';
                break;    
            case 'ao_khoac':
                echo 'Áo khoác';
                break;
            case 'quan_thun':
                echo 'Quần thun';
                break;
            default:
                echo 'Không xác định';
        }
        ?>
</p>
            <p><strong>Mô tả:</strong> <?php echo nl2br($product['description']); ?></p>

          
           <!-- Form thêm vào giỏ hàng -->
           <form action="../cart/add.php" method="POST" class="mt-3">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

    <div class="mb-2">
        <label for="quantity"><strong>Số lượng:</strong></label>
        <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" style="width: 100px;" required>
    </div>

    <div class="mb-2">
        <label for="size"><strong>Chọn size:</strong></label>
        <select name="size" id="size" class="form-control" style="width: 100px;" required>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">🛒 Thêm vào giỏ hàng</button>
    
</form>

    <a href="../index.php" class="btn btn-secondary">← Quay lại trang chủ</a>



        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
