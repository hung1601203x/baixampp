<?php
header('Content-Type: application/xml');

// Kết nối đến cơ sở dữ liệu
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

// Truy vấn để lấy dữ liệu từ bảng "students"
$query = "SELECT * FROM students";

$result = mysqli_query($con, $query);

// Bắt đầu tạo chuỗi XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<StudentList>';

while ($row = mysqli_fetch_assoc($result)) {
    $xml .= '<Student>';
    $xml .= '<ID>' . $row['id'] . '</ID>';
    $xml .= '<ImagePath>' . $row['image_path'] . '</ImagePath>';
    $xml .= '<MSV>' . $row['MSV'] . '</MSV>';
    $xml .= '<Name>' . $row['name'] . '</Name>';
    $xml .= '<Birthday>' . $row['birthday'] . '</Birthday>';
    $xml .= '<Sex>' . $row['sex'] . '</Sex>';
    $xml .= '<PhoneNumber>' . $row['phoneNumber'] . '</PhoneNumber>';
    $xml .= '<Class>' . $row['class'] . '</Class>';
    $xml .= '<Money>' . $row['money'] . '</Money>';
    $xml .= '<CreatedAt>' . $row['created_at'] . '</CreatedAt>';
    $xml .= '<UpdatedAt>' . $row['updated_at'] . '</UpdatedAt>';
    $xml .= '<RoomID>' . $row['roomId'] . '</RoomID>';
    $xml .= '</Student>';
}

$xml .= '</StudentList>';

// Đóng kết nối cơ sở dữ liệu
mysqli_close($con);

// In ra chuỗi XML
echo $xml;
?>
