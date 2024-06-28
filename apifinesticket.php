<?php
header('Content-Type: application/xml');

// Kết nối đến cơ sở dữ liệu
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

// Truy vấn để lấy dữ liệu từ bảng "room_types"
$query = "SELECT * FROM room_types";

$result = mysqli_query($con, $query);

// Bắt đầu tạo chuỗi XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<RoomTypeList>';

while ($row = mysqli_fetch_assoc($result)) {
    $xml .= '<RoomType>';
    $xml .= '<ID>' . $row['id'] . '</ID>';
    $xml .= '<Name>' . $row['name'] . '</Name>';
    $xml .= '<Description>' . $row['description'] . '</Description>';
    $xml .= '<MaxNumberOfBed>' . $row['maxNumberOfBed'] . '</MaxNumberOfBed>';
    $xml .= '<CreatedAt>' . $row['created_at'] . '</CreatedAt>';
    $xml .= '<UpdatedAt>' . $row['updated_at'] . '</UpdatedAt>';
    $xml .= '</RoomType>';
}

$xml .= '</RoomTypeList>';

// Đóng kết nối cơ sở dữ liệu
mysqli_close($con);

// In ra chuỗi XML
echo $xml;
?>
