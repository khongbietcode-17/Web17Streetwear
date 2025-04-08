<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vertrigo/banquanao/css/style.css">
</head>
<body>

<div class="container mt-5">
    <?php
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $result = mysqli_query($conn, "SELECT * FROM products WHERE category = '$category'");

        echo '<h2 class="mb-4 text-uppercase fw-bold text-center">Danh sách sản phẩm</h2>';
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="col-md-3">
                <div class="card mb-4 shadow-sm">
                    <img src="../img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'" style="heigh; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">'.$row['name'].'</h5>
                        <p class="card-text text-danger">'.number_format($row['price'], 0).'.000 VND</p>
                        <a href="product_detail.php?id='.$row['id'].'" class="btn btn-outline-primary w-100">Xem chi tiết</a>
                    </div>
                </div>
            </div>';
        }
        echo '</div>';
    } else {
        echo '<p class="text-danger">Không tìm thấy danh mục sản phẩm.</p>';
    }
    ?>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>

