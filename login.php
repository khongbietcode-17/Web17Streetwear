<?php
session_start(); // luôn ở đầu tiên, không có gì trước dòng này

include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $user = mysqli_fetch_assoc($result);

    if ($user && md5($password) == $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin/orders.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<link rel="stylesheet" href="css/stylelogin.css">


<?php include 'includes/header.php'; ?>
<div class="login-wrapper">
    <div class="login-banner">
        <video autoplay muted loop playsinline>
            <source src="video/carhd.mp4" type="video/mp4">
            Trình duyệt của bạn không hỗ trợ video.
        </video>
    </div>
    <div class="login-form">
        <h3>Đăng nhập</h3>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <button class="btn btn-success">Đăng nhập</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
