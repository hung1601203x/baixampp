<?php
header('Content-Type: application/xml');

// Kết nối đến cơ sở dữ liệu
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

// Truy vấn để lấy dữ liệu từ bảng "contracts" và các bảng liên quan
$query = "SELECT contracts.id, contracts.studentId, contracts.roomId, contracts.startDate, contracts.endDate, contracts.created_at, contracts.updated_at, contracts.cancelledAt, students.name AS student_name, rooms.name AS room_name FROM contracts INNER JOIN students ON contracts.studentId = students.id INNER JOIN rooms ON contracts.roomId = rooms.id";

$result = mysqli_query($con, $query);

// Bắt đầu tạo chuỗi XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<ContractList>';

while ($row = mysqli_fetch_assoc($result)) {
    $xml .= '<Contract>';
    $xml .= '<ID>' . $row['id'] . '</ID>';
    $xml .= '<StudentID>' . $row['studentId'] . '</StudentID>';
    $xml .= '<RoomID>' . $row['roomId'] . '</RoomID>';
    $xml .= '<StartDate>' . $row['startDate'] . '</StartDate>';
    $xml .= '<EndDate>' . $row['endDate'] . '</EndDate>';
    $xml .= '<CreatedAt>' . $row['created_at'] . '</CreatedAt>';
    $xml .= '<UpdatedAt>' . $row['updated_at'] . '</UpdatedAt>';
    $xml .= '<CancelledAt>' . $row['cancelledAt'] . '</CancelledAt>';
    $xml .= '<StudentName>' . $row['student_name'] . '</StudentName>';
    $xml .= '<RoomName>' . $row['room_name'] . '</RoomName>';
    $xml .= '</Contract>';
}

$xml .= '</ContractList>';

// Đóng kết nối cơ sở dữ liệu
mysqli_close($con);

// In ra chuỗi XML
echo $xml;
?>
