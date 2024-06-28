<?php
header('Content-Type: application/xml');

// Kết nối đến cơ sở dữ liệu
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

// Truy vấn để lấy dữ liệu từ bảng "bills" và các bảng liên quan
$query = "SELECT bills.id, bills.roomId, bills.waterUnitPrice, bills.electricityUnitPrice, bills.oldWaterNumber, bills.newWaterNumber, bills.oldElectricityNumber, bills.newElectricityNumber, bills.createdAt, bills.status, bills.payDate, bills.servicesPrice, rooms.name FROM bills INNER JOIN rooms ON bills.roomId = rooms.id";

$result = mysqli_query($con, $query);

// Bắt đầu tạo chuỗi XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<BillList>';

while ($row = mysqli_fetch_assoc($result)) {
    $xml .= '<Bill>';
    $xml .= '<ID>' . $row['id'] . '</ID>';
    $xml .= '<RoomID>' . $row['roomId'] . '</RoomID>';
    $xml .= '<WaterUnitPrice>' . $row['waterUnitPrice'] . '</WaterUnitPrice>';
    $xml .= '<ElectricityUnitPrice>' . $row['electricityUnitPrice'] . '</ElectricityUnitPrice>';
    $xml .= '<OldWaterNumber>' . $row['oldWaterNumber'] . '</OldWaterNumber>';
    $xml .= '<NewWaterNumber>' . $row['newWaterNumber'] . '</NewWaterNumber>';
    $xml .= '<OldElectricityNumber>' . $row['oldElectricityNumber'] . '</OldElectricityNumber>';
    $xml .= '<NewElectricityNumber>' . $row['newElectricityNumber'] . '</NewElectricityNumber>';
    $xml .= '<CreatedAt>' . $row['createdAt'] . '</CreatedAt>';
    $xml .= '<Status>' . $row['status'] . '</Status>';
    $xml .= '<PayDate>' . $row['payDate'] . '</PayDate>';
    $xml .= '<ServicesPrice>' . $row['servicesPrice'] . '</ServicesPrice>';
    $xml .= '<RoomName>' . $row['name'] . '</RoomName>';
    $xml .= '</Bill>';
}

$xml .= '</BillList>';

// Đóng kết nối cơ sở dữ liệu
mysqli_close($con);

// In ra chuỗi XML
echo $xml;
?>
