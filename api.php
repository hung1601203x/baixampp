<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

function connectDB() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'quanLyKyTuc';

    $con = mysqli_connect($servername, $username, $password, $dbname) or die('Lỗi kết nối');
    return $con;
}

$con = connectDB();
$p = '';
if (isset($_GET['p'])) {
    $p = $_GET['p'];
}

$query = "SELECT students.image_path, students.MSV, students.birthday, students.sex, students.phoneNumber, students.class, students.id AS student_id, students.name AS student_name, rooms.name AS room_name FROM students INNER JOIN contracts ON students.id = contracts.studentId INNER JOIN rooms ON contracts.roomId = rooms.id WHERE contracts.cancelledAt IS NULL";

if (!empty($p)) {
    $query .= " AND (students.name LIKE '%$p%' OR rooms.name LIKE '%$p%')";
}

$result = mysqli_query($con, $query);
$students = [];

while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
}

mysqli_close($con);

echo json_encode($students);
?>
