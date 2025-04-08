


<?php
include 'includes/db.php';
echo "Kết nối thành công!";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // Tạm dùng md5 vì Vertrigo không hỗ trợ password_hash


    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Tên đăng nhập đã tồn tại!";
    } else {
        
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
if (mysqli_query($conn, $sql)) {
    echo "Đăng ký thành công!";
    header("Location: login.php");
    exit;
} else {
    echo "Lỗi khi đăng ký: " . mysqli_error($conn);
}

       header("Location: login.php");
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-4">
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
<?php include 'includes/footer.php'; ?>
