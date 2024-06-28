<?php
header('Content-Type: application/xml');

// Kết nối đến cơ sở dữ liệu
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

// Truy vấn để lấy dữ liệu từ bảng "services"
$query = "SELECT * FROM services";

$result = mysqli_query($con, $query);

// Bắt đầu tạo chuỗi XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<ServiceList>';

while ($row = mysqli_fetch_assoc($result)) {
    $xml .= '<Service>';
    $xml .= '<ID>' . $row['id'] . '</ID>';
    $xml .= '<Name>' . $row['name'] . '</Name>';
    $xml .= '<IsRequired>' . $row['isRequired'] . '</IsRequired>';
    $xml .= '<Price>' . $row['price'] . '</Price>';
    $xml .= '<DeletedAt>' . $row['deletedAt'] . '</DeletedAt>';
    $xml .= '<RoomID>' . $row['roomId'] . '</RoomID>';
    $xml .= '<StudentID>' . $row['studentId'] . '</StudentID>';
    $xml .= '<Status>' . $row['status'] . '</Status>';
    $xml .= '</Service>';
}

$xml .= '</ServiceList>';

// Đóng kết nối cơ sở dữ liệu
mysqli_close($con);

// In ra chuỗi XML
echo $xml;
?>
