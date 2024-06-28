<?php 
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');
$ma=$_GET['ma'];
$query = "SELECT bills.id, 
    rooms.name as 'Ten phong',
    waterUnitPrice, 
    oldWaterNumber, 
    newWaterNumber, 
    electricityUnitPrice, 
    oldElectricityNumber, 
    newElectricityNumber, 
    servicesPrice, 
    payDate, 
    createdAt, 
    status
    FROM bills INNER JOIN rooms
    ON bills.roomId = rooms.id WHERE bills.id = $ma";

            $bills=mysqli_query($con,$query);
            
            while ($bill = mysqli_fetch_assoc($bills)) {
                $createdAtDate = date('Y-m-d', strtotime($bill['createdAt']));
                
                $filename = "Hoa_Don_" . $bill['Ten phong'] . ".csv";
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="' . $filename . '"');

                // Mở file và ghi dữ liệu
                $output = fopen('php://output', 'w');
                fputcsv($output, array('Ma phong', 'Ten phong','Don gia nuoc', 'So nuoc cu', 'So nuoc moi', 'Don gia dien', 'So dien cu', 'So dien moi', 'Phi dich vu', 'Han tra', 'Ngay tao', 'Trang thai'));

                fputcsv($output, $bill);

                fclose($output);
                break;
            }
mysqli_close($con);
?>