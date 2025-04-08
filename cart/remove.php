<?php
session_start();
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    unset($_SESSION['cart'][$id]);
}
header("Location: view.php");
exit;
