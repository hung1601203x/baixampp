<?php
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

$p = '';
$status = '';
$selectedMonthYear = date("Y-m");

$query ="UPDATE bills SET status = 'OutDate' WHERE payDate < CURDATE() and id >0 and status = 'Pending'";
mysqli_query($con,$query);

$query = "SELECT bills.id, roomId, waterUnitPrice, electricityUnitPrice, oldWaterNumber, newWaterNumber, oldElectricityNumber, newElectricityNumber, createdAt, status, payDate, servicesPrice, name FROM bills INNER JOIN rooms ON bills.roomId = rooms.id WHERE DATE_FORMAT(bills.createdAt, '%Y-%m') = '$selectedMonthYear'";
$bills=mysqli_query($con,$query);

$canCreate = mysqli_num_rows($bills) == 0;
 
if(isset($_GET['find']))
{
    $p=$_GET['p'];
    $status = $_GET['status'];
    $selectedMonthYear = $_GET['date'];

    $statusQuery = $status ==  'All' ? '' : "and status = '$status'";

    $query = "SELECT bills.id, roomId, waterUnitPrice, electricityUnitPrice, oldWaterNumber, newWaterNumber, oldElectricityNumber, newElectricityNumber, createdAt, status, payDate, servicesPrice, name FROM bills INNER JOIN rooms ON bills.roomId = rooms.id WHERE DATE_FORMAT(bills.createdAt, '%Y-%m') = '$selectedMonthYear' and rooms.name like '%$p%' $statusQuery";
    $bills=mysqli_query($con,$query);
}


function getClosestWaterNumber($roomId) {
    $con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');
    $query = "SELECT oldWaterNumber FROM bills WHERE roomId = $roomId ORDER BY createdAt DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return isset($row['oldWaterNumber']) ? $row['oldWaterNumber'] : 0;
}

function getClosetElectricityNumber($roomId) {
    $con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');
    $query = "SELECT oldElectricityNumber FROM bills WHERE roomId = $roomId ORDER BY createdAt DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
        return isset($row['oldElectricityNumber']) ? $row['oldElectricityNumber'] : 0;
    
}

if(isset($_POST['done'])) {
    $ma=$_POST['ma'];
    $sql="update bills set status = 'Success' where id = $ma";
    $kq=mysqli_query($con,$sql);

    header("location: thanhtoan.php");
    exit;
}

mysqli_close($con);
?>
 <title>Thanh toán</title>
<body>
    <div class="flex">
        <?php include_once './sidebar(sv).php'; ?>
        <div class="flex-1 flex flex-col max-h-screen overflow-scroll">
            <div class="py-8 px-4 border-b flex justify-between">
                <div></div>
                <button class="p-2 px-4 rounded-full hover:bg-gray-100 transition">Chào mừng bạn quay trở lại 💙</button>
            </div>
            <div class="flex-1 p-4">
                <div>
                    <form class="flex gap-3 w-full" method="GET">
                        <input name="p" class="border p-3 focus:outline-none outline-none flex-1" type="text" placeholder="Tìm kiếm phòng theo phòng">
                        <input required value="<?php echo $selectedMonthYear ? $selectedMonthYear : '' ?>" name="date" value="<?php echo date('Y-m'); ?>" class="border p-3 focus:outline-none outline-none w-[250px]" type="month">
                        <div  class="w-[180px] border p-3 focus:outline-none outline-none">
                            <select name="status" class=" outline-none focus:outline-none w-full">
                                <option <?php echo $status=='All' ? 'selected' : '' ?> id="option" class="text-sm" value="All">
                                    Tất cả
                                </option>
                                <option <?php echo $status=='Success' ? 'selected' : '' ?> id="option" class="text-sm" value="Success">
                                    Đã thanh toán
                                </option>
                                <option <?php echo $status=='Pending' ? 'selected' : '' ?>  id="option" class="text-sm" value="Pending">
                                    Chờ thanh toán
                                </option>
                                <option <?php echo $status=='OutDate' ? 'selected' : '' ?>  id="option" class="text-sm" value="OutDate">
                                    Quá hạn
                                </option>
                            </select>
                        </div>
                        <button name="find" type="submit" class="border border-slate-800 p-3">Tìm kiếm</button>
                    </form>
                    
                </div>
                <div>
                <?php
                    if (mysqli_num_rows($bills) == 0) {
                        echo '<div class="h-[60vh] grid place-items-center">Không có hoá đơn cần tìm tồn tại trong danh sách.</div>';
                    } else {
                        echo '<div class="grid grid-cols-3 gap-4 mt-4">';
                        while ($bill = mysqli_fetch_array($bills)) {
                            $total =($bill['newWaterNumber']-$bill['oldWaterNumber'])*$bill['waterUnitPrice'] + ($bill['newElectricityNumber']-$bill['oldElectricityNumber'])*$bill['electricityUnitPrice'] +$bill['servicesPrice'];
                            $statusColor=$bill['status'] == 'Pending' ? 'yellow' : ($bill['status'] == 'Success' ? 'green' : 'rose');
                            $status = $bill['status'] == 'Pending' ? 'Chờ thanh toán' : ($bill['status'] == 'Success' ? 'Đã thanh toán' : 'Quá hạn');
                ?>
                    <div class="border border-gray-100 hover:bg-slate-100 duration-100 text-slate-500 p-4 text-sm relative">
                        <div class="absolute top-0 right-0 p-1 text-xs text-white bg-<?php echo $statusColor ?>-600">
                            <?php 
                                echo $status;
                            ?>
                        </div>
                        <h1 class="text-xl text-black font-semibold mt-2"><?php echo $bill['name'] ?></h1>
                        <hr class="mt-4">
                        <div class="flex items-center justify-between mt-4">
                            <p>Số điện cũ</p>
                            <p><?php echo $bill['oldElectricityNumber'] ?></p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <p>Số điện mới</p>
                            <p><?php echo $bill['newElectricityNumber'] ?></p>
                        </div>
                        <hr class="mt-4">
                        <div class="flex items-center justify-between mt-4">
                            <p>Số nước cũ</p>
                            <p><?php echo $bill['oldWaterNumber'] ?></p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <p>Số nước mới</p>
                            <p><?php echo $bill['newWaterNumber'] ?></p>
                        </div>
                        <hr class="mt-4">
                        <div class="flex items-center justify-between mt-4">
                            <p>Hạn trả</p>
                            <p><?php echo $bill['payDate'] ?></p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <p>Phí dịch vụ cố định</p>
                            <p><?php echo $bill['servicesPrice'] ?></p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <p>Tổng</p>
                            <p><?php echo $total ?></p>
                        </div>
                        <hr class="mt-4">
                        <form method="POST" class="p-4 flex items-center justify-center gap-4">
                            <?php 
                                if ($bill['status'] != 'Success') {
                            ?>
                                <button type="submit" name="done" class="material-symbols-outlined cursor-pointer p-2 bg-slate-100 rounded-full hover:bg-green-400 duration-100 hover:text-white">
                                    done
                                </button>
                            <?php 
                                }
                            ?>
                            <a target="_blank" href="http://localhost/QuanLyKyTucXa/bills_print.php?ma=<?php echo $bill['id'] ?>" class="cursor-pointer material-symbols-outlined p-2 bg-slate-100 rounded-full hover:bg-slate-200 duration-100">
                                print
                            </a>
                        </form>
                    </div>
                <?php
                    }
                    echo '</div>';
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</body>
