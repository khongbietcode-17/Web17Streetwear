<?php
ob_start(); // bật buffer
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/db.php';
include '../includes/header.php';

// Xóa sản phẩm nếu có yêu cầu
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: list.php");
    exit();
}

// Cập nhật sản phẩm
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $conn->query("UPDATE products SET name='$name', price='$price', category='$category' WHERE id=$id");
    header("Location: list_product.php");
    exit();
}

// Lấy danh sách sản phẩm
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f9fc;
        margin: 0;
        padding: 20px;
    }

    h2, h3 {
        padding-top: 40px;
        padding-bottom: 10px;
        text-align: center;
        color: #333;
    }

    table {
        padding-top: 20px;
        border-collapse: collapse;
        width: 90%;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        border-radius: 10px;
        overflow: hidden;
    }

    th {
        background-color: #007bff;
        color: white;
        padding: 12px 10px;
        text-align: center;
    }

    td {
        padding: 12px 10px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    tr:hover {
        background-color: #f1f5ff;
        cursor: pointer;
    }

    .selected {
        background-color: #d0e0ff !important;
    }

    a {
        color: #dc3545;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    form {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    input[type="text"], input[type="number"] {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        min-width: 150px;
    }

    button {
        padding: 8px 16px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #218838;
    }
</style>

    <script>
        function selectRow(row, id, name, price, category) {
            document.getElementById('id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('price').value = price;
            document.getElementById('category').value = category;

            let rows = document.querySelectorAll("tr");
            rows.forEach(r => r.classList.remove("selected"));
            row.classList.add("selected");
        }
    </script>
</head>
<body>

<!-- Form cập nhật -->



<h2 style="text-align:center">Danh sách sản phẩm</h2>

<form method="post" style="text-align:center">
    <input type="hidden" name="id" id="id">
    Tên: <input type="text" name="name" id="name" required>
    Giá: <input type="number" name="price" id="price" required>
    Loại: <input type="text" name="category" id="category" required>
    <button type="submit" name="update">Lưu</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Giá</th>
        <th>Loại</th>
        <th>Hành động</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr onclick="selectRow(this, '<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['name']); ?>', '<?php echo $row['price']; ?>', '<?php echo $row['category']; ?>')">
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['category']; ?></td>
        <td>
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
        </td>
    </tr>
    <?php } ?>
</table>



</body>
</html>
