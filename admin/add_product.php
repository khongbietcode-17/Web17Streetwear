<?php

include '../includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $price       = (int)$_POST['price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);

    // Xử lý ảnh upload
    $image_name = basename($_FILES['image']['name']);
    $image_tmp  = $_FILES['image']['tmp_name'];

    // Thư mục lưu ảnh, tính từ thư mục hiện tại (admin/)
    $upload_dir = __DIR__ . '/../img/';

    // Tạo thư mục nếu chưa có
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $upload_path = $upload_dir . $image_name;

    if (move_uploaded_file($image_tmp, $upload_path)) {
        // Lưu vào DB chỉ đường dẫn tương đối thôi
        $image_relative_path = $image_name;

        $sql = "INSERT INTO products (name, price, image, description, category)
                VALUES ('$name', '$price', '$image_relative_path', '$description', '$category')";

        if (mysqli_query($conn, $sql)) {
            // Làm nổi bật 4 sản phẩm mới nhất
            mysqli_query($conn, "UPDATE products SET is_featured = 0");
            mysqli_query($conn, "UPDATE products SET is_featured = 1 ORDER BY id DESC LIMIT 4");

            $success = "✅ Thêm sản phẩm thành công!";
        } else {
            $error = "❌ Lỗi khi thêm sản phẩm: " . mysqli_error($conn);
        }
    } else {
        $error = "❌ Upload ảnh thất bại. Kiểm tra quyền thư mục img/";
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h3>Thêm sản phẩm mới</h3>

    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Giá (VND)</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Loại sản phẩm</label>
            <select name="category" class="form-control" required>
                <option value="ao_thun">Áo Thun</option>
                <option value="ao_somi">Áo Sơ Mi</option>
                <option value="ao_hoodie">Hoodie</option>
                <option value="quan_ngan">Quần Ngắn</option>
                <option value="quan_thun">Quần Thun</option>
                <option value="quan_jeans">Quần Jeans</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Ảnh sản phẩm</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <button class="btn btn-primary">Thêm sản phẩm</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
