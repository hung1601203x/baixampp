<?php 
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');
$ma=$_GET['ma'];
$query = "SELECT 
            rooms.name as 'Ten phong', 
            students.name as 'Ho Ten', 
            students.MSV as 'Ma sinh vien', 
            students.sex as 'Gioi tinh', 
            students.birthday as 'Ngay sinh', 
            students.phoneNumber as 'So dien thoai', 
            students.class as 'Lop',
            contracts.startDate as 'Thoi gian bat dau', 
            contracts.endDate as 'Thoi gian ket thuc', 
            contracts.cancelledAt as 'Thoi gian huy'
            FROM contracts 
            INNER JOIN students ON contracts.studentId = students.id 
            INNER JOIN rooms ON contracts.roomId = rooms.id 
            where contracts.id = $ma";

            $contracts=mysqli_query($con,$query);
            
            while ($contract = mysqli_fetch_assoc($contracts)) {
                $filename = "Hop_Dong_" . $contract['Ten phong'] . ".csv";
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="' . $filename . '"');

                // Mở file và ghi dữ liệu
                $output = fopen('php://output', 'w');
                fputcsv($output, array('Ten phong', 'Ho Ten', 'Ma sinh vien','Gioi tinh','Ngay sinh', 'So dien thoia', 'Lop', 'Thoi gian bat dau', 'Thoi gian ket thuc' ,'Thoi gian huy'));

                fputcsv($output, $contract);

                fclose($output);
                break;
            }
mysqli_close($con);
?>