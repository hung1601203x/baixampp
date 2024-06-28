<?php
header('Content-Type: application/xml');

// Kết nối đến cơ sở dữ liệu
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

// Truy vấn để lấy dữ liệu từ các bảng của cơ sở dữ liệu
$query = "SELECT rooms.id, rooms.name AS room_name, room_types.name AS roomType_name, room_types.maxNumberOfBed, rooms.numberOfEmptyBed, rooms.created_at, rooms.updated_at FROM rooms INNER JOIN room_types ON rooms.roomTypeId = room_types.id";

$result = mysqli_query($con, $query);

// Bắt đầu tạo chuỗi XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<RoomList>';

while ($row = mysqli_fetch_assoc($result)) {
    $xml .= '<Room>';
    $xml .= '<ID>' . $row['id'] . '</ID>';
    $xml .= '<Name>' . $row['room_name'] . '</Name>';
    $xml .= '<RoomType>' . $row['roomType_name'] . '</RoomType>';
    $xml .= '<MaxNumberOfBed>' . $row['maxNumberOfBed'] . '</MaxNumberOfBed>';
    $xml .= '<NumberOfEmptyBed>' . $row['numberOfEmptyBed'] . '</NumberOfEmptyBed>';
    $xml .= '<CreatedAt>' . $row['created_at'] . '</CreatedAt>';
    $xml .= '<UpdatedAt>' . $row['updated_at'] . '</UpdatedAt>';
    $xml .= '</Room>';
}

$xml .= '</RoomList>';

// Đóng kết nối cơ sở dữ liệu
mysqli_close($con);

// In ra chuỗi XML
echo $xml;
?>
