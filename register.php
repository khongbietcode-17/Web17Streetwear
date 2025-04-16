<?php
session_start(); // Đặt lên đầu tiên
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Tên đăng nhập đã tồn tại!";
    } else {
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Lỗi khi đăng ký: " . mysqli_error($conn);
        }
    }
}
?>
<link rel="stylesheet" href="css/styleregis.css">


<?php include 'includes/header.php'; ?>
<div class="register-wrapper">
<div class="register-banner">
    <video autoplay muted loop playsinline>
        <source src="video/videoregis.mp4" type="video/mp4">
        Trình duyệt của bạn không hỗ trợ video.
    </video>
</div>
    <div class="register-form">
        <h3>Đăng ký tài khoản</h3>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <button class="btn btn-primary">Đăng ký</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
