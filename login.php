<?php
$curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); // lấy tên file hiện tại
session_start();

if (isset($_POST['login'])) {
    // Lấy giá trị nhập từ người dùng
    $masv = $_POST['masv'];
    $mk = $_POST['matkhau'];
    $vt = $_POST['role'];

    // Kết nối đến cơ sở dữ liệu
    try {
        $conn = new PDO('mysql:host=localhost;dbname=quanlykytuc', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
    }

    // Kiểm tra xem người dùng có tồn tại trong cơ sở dữ liệu không bằng cách sử dụng câu lệnh chuẩn bị
    $sql = 'SELECT * FROM logins WHERE masv = :masv AND role = :role';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':masv', $masv);
    $stmt->bindParam(':role', $vt);

    try {
        $stmt->execute();
        $user = $stmt->fetch();
    } catch (PDOException $e) {
        die("Truy vấn cơ sở dữ liệu thất bại: " . $e->getMessage());
    }

    // Kiểm tra xem người dùng đã được tìm thấy và xác minh mật khẩu
    if ($user && $mk == $user['matkhau']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['masv'] = $user['masv'];
        $_SESSION['role'] = $user['role'];

        if ($vt == 'Admin') {
            header("Location: http://localhost/QuanLyKyTucXa/students.php");
        } else {
            header("Location: DSphong(sv).php");
        }
        exit;
    } else {
        // Đăng nhập thất bại
        echo "<script> alert('Đăng nhập thất bại. Vui lòng kiểm tra thông tin đăng nhập của bạn.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="./style/dist/output.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 0px;
            width: 300px;
        }

        .login-container h1 {
            color: #dc3545;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .login-form table {
            width: 200%;
        }

        .login-form input {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-form input[type="submit"] {
            background-color: #dc3545;
            color: #fff;
            cursor: pointer;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h1>Đăng nhập</h1>
            <form action="login.php" method="post">
                <table border="0" align="center">
                <table border="0" align="center">
            <tr>
                <td>Mã sinh viên</td>
                <td>
        <input type="text" name="masv" required>
                </td>   
            </tr>
            <tr>
                <td>Mật khẩu</td>
                <td>
        <input type="password" name="matkhau" required>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
       <select name="role" required>
            <option value="Admin">Admin</option>
            <option value="sinhvien">Sinh viên</option>
        </select>
</td>
            </tr>
            <tr>
                <td></td>
                <td>
        <input type="submit" name="login" value="Đăng nhập">
                </td>
            </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
