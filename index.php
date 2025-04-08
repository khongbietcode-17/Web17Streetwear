<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang Bán Quần Áo</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/vertrigo/banquanao/css/style.css">
  <script src="/vertrigo/banquanao/js/script.js"></script>
</head>
<div class="container my-4">
  <video class="img-fluid rounded shadow banner-small" autoplay muted loop>
    <source src="video/carhd.mp4" type="video/mp4">
    Trình duyệt của bạn không hỗ trợ video.
  </video>
</div>

<div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/banner/bannergt.jpg" class="d-block w-100" alt="Banner 1">
    </div>
    <div class="carousel-item">
      <img src="img/banner/banner2.jpg" class="d-block w-100" alt="Banner 2">
    </div>
    <div class="carousel-item">
      <img src="img/banner/banner3.jpg" class="d-block w-100" alt="Banner 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<div class="container mt-4">
    <h2 class="collection-title">SẢN PHẨM MỚI</h2>
    <div class="row">
        <?php
        $featured = mysqli_query($conn, "SELECT * FROM products WHERE is_featured = 1 ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($featured)) {
            echo '
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
                    <div class="card-body">
                        <h5 class="card-title">'.$row['name'].'</h5>
                        <p class="card-text">'.number_format($row['price'], 0).'.000 VND</p>
                        <a href="pages/product_detail.php?id='.$row['id'].'" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
     <!-- BANNER TĨNH RÚT GỌN (CÁCH CSS) -->
     <div class="container my-4">
  <video class="img-fluid rounded shadow banner-smallss" autoplay muted loop>
    <source src="video/top.mp4" type="video/mp4">
    Trình duyệt của bạn không hỗ trợ video.
  </video>
</div>

    <!-- ÁO THUN -->
<h2 class="collection-title mt-5">ÁO THUN</h2>
<div class="row">
<?php
$aothun = mysqli_query($conn, "SELECT * FROM products WHERE category = 'ao_thun' ORDER BY id DESC LIMIT 4");
while ($row = mysqli_fetch_assoc($aothun)) {
    echo '
    <div class="col-md-3">
        <div class="card mb-4">
            <img src="img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
            <div class="card-body">
                <h5 class="card-title">'.$row['name'].'</h5>
                <p class="card-text">'.number_format($row['price'], 0).' VND</p>
                <a href="pages/product_detail.php?id='.$row['id'].'" class="btn btn-primary">Xem chi tiết</a>
            </div>
        </div>
    </div>';
}
?>
</div>
<a href="pages/category.php?category=ao_thun" class="btn btn-outline-primary">Xem thêm →</a>
<!-- ÁO SƠ MI -->
<h2 class="collection-title mt-5">ÁO SƠ MI</h2>
<div class="row">
<?php
$aosomi = mysqli_query($conn, "SELECT * FROM products WHERE category = 'ao_somi' ORDER BY id DESC LIMIT 4");
while ($row = mysqli_fetch_assoc($aosomi)) {
    echo '
    <div class="col-md-3">
        <div class="card mb-4">
            <img src="img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
            <div class="card-body">
                <h5 class="card-title">'.$row['name'].'</h5>
                <p class="card-text">'.number_format($row['price'], 0).' VND</p>
                <a href="pages/product_detail.php?id='.$row['id'].'" class="btn btn-primary">Xem chi tiết</a>
            </div>
        </div>
    </div>';
}
?>
</div>
<a href="pages/category.php?category=ao_somi" class="btn btn-outline-primary">Xem thêm →</a>

    <h2 class="collection-title">ÁO KHOÁC</h2>
    <div class="row">
    <?php
    $aokhoac = mysqli_query($conn, "SELECT * FROM products WHERE category = 'ao_hoodie' ORDER BY id DESC LIMIT 4");
    while ($row = mysqli_fetch_assoc($aokhoac)) {
        echo '
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
                <div class="card-body">
                    <h5 class="card-title">'.$row['name'].'</h5>
                    <p class="card-text">'.number_format($row['price'], 0).' VND</p>
                    <a href="pages/product_detail.php?id='.$row['id'].'" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>';
    }
    ?>
    </div>
<a href="pages/category.php?category=ao_hoodie" class="btn btn-outline-primary">Xem thêm →</a>
<h2 class="collection-title">ÁO KHOÁC</h2>
    <div class="row">
    <?php
    $aokhoac = mysqli_query($conn, "SELECT * FROM products WHERE category = 'ao_hoodie' ORDER BY id DESC LIMIT 4");
    while ($row = mysqli_fetch_assoc($aokhoac)) {
        echo '
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
                <div class="card-body">
                    <h5 class="card-title">'.$row['name'].'</h5>
                    <p class="card-text">'.number_format($row['price'], 0).' VND</p>
                    <a href="pages/product_detail.php?id='.$row['id'].'" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>';
    }
    ?>
    </div>
<a href="pages/category.php?category=ao_hoodie" class="btn btn-outline-primary">Xem thêm →</a>
<div class="container my-4">
  <video class="img-fluid rounded shadow banner-small" autoplay muted loop>
    <source src="video/pant.mp4" type="video/mp4">
    Trình duyệt của bạn không hỗ trợ video.
  </video>
</div>

<h2 class="collection-title">ÁO NGẮN</h2>
    <div class="row">
    <?php
    $aokhoac = mysqli_query($conn, "SELECT * FROM products WHERE category = 'quan_nganngan' ORDER BY id DESC LIMIT 4");
    while ($row = mysqli_fetch_assoc($aokhoac)) {
        echo '
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
                <div class="card-body">
                    <h5 class="card-title">'.$row['name'].'</h5>
                    <p class="card-text">'.number_format($row['price'], 0).' VND</p>
                    <a href="pages/product_detail.php?id='.$row['id'].'" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>';
    }
    ?>
    </div>

    <a href="pages/category.php?category=quan_ngan" class="btn btn-outline-primary">Xem thêm →</a>

    <h2 class="collection-title">QUẦN THUN
   </h2>
    <div class="row">
    <?php
    $aokhoac = mysqli_query($conn, "SELECT * FROM products WHERE category = 'quan_thunthun' ORDER BY id DESC LIMIT 4");
    while ($row = mysqli_fetch_assoc($aokhoac)) {
        echo '
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
                <div class="card-body">
                    <h5 class="card-title">'.$row['name'].'</h5>
                    <p class="card-text">'.number_format($row['price'], 0).' VND</p>
                    <a href="pages/product_detail.php?id='.$row['id'].'" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>';
    }
    ?>
    </div>
<a href="pages/category.php?category=quan_thun" class="btn btn-outline-primary">Xem thêm →</a>

</div>

<?php include 'includes/footer.php'; ?>


