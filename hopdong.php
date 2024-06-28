<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');
    $status = 'Available';
    $date = date("Y-m-d");
    $p ='';

    if(isset($_POST['delete'])) {
        $p=$_POST['ma'];
        $roomId=$_POST['roomId'];
        $cancelledAt = date("Y-m-d");

        $query = "update contracts set cancelledAt = '$cancelledAt' where id = $p ";
        mysqli_query($con,$query);


        $sql = "select * from rooms where id = $roomId";
        $result = mysqli_query($con, $sql);
        while ($dt = mysqli_fetch_assoc($result)){
            $newNumberOfEmptyBed = ($dt['numberOfEmptyBed']) + 1;
            $sql = "update rooms set numberOfEmptyBed = $newNumberOfEmptyBed where id = $roomId";
            mysqli_query($con, $sql);
            break;
        }
    }

    if(isset($_GET['find']))
        {
            $p=$_GET['p'];
            $status=$_GET['status'];

            $dateQuery = $status == 'Available' 
            ? "(DATE_FORMAT(contracts.endDate, '%Y-%m-%d') >= '$date') AND contracts.cancelledAt is null " 
            : ($status == 'Unavailable' 
                ? "(DATE_FORMAT(contracts.endDate, '%Y-%m-%d') < '$date') AND contracts.cancelledAt is null " 
                : "(cancelledAt IS NOT NULL)");
        
            $query = "SELECT 
            rooms.name as room_name, 
            contracts.id, 
            contracts.cancelledAt,
            contracts.studentId, 
            contracts.roomId,
            students.image_path, 
            students.MSV, 
            students.name, 
            contracts.startDate, 
            contracts.endDate, 
            students.birthday, 
            students.sex, 
            students.phoneNumber, 
            students.class,
            (SELECT COUNT(*) 
                FROM contracts as c 
                WHERE 
                    DATE_FORMAT(c.endDate, '%Y-%m-%d') > CURDATE() AND 
                    c.studentId = contracts.studentId
            ) as numberOfAvailableContractsRemain -- lấy số hợp đồng còn hiệu lực (trả về 0 hoặc 1)
            FROM contracts 
            INNER JOIN students ON contracts.studentId = students.id 
            INNER JOIN rooms ON contracts.roomId = rooms.id 
            WHERE 
            (students.name LIKE '%$p%' OR rooms.name LIKE '%$p%')
            and $dateQuery";

            $contracts=mysqli_query($con,$query);
        }
        else {
            $query ="select rooms.name as room_name,contracts.cancelledAt, contracts.roomId,contracts.id,contracts.studentId, students.image_path, students.MSV, students. name, contracts.startDate, contracts.endDate,students.birthday, students.sex, students.phoneNumber, students.class from contracts inner join students on contracts.studentId = students.id inner join rooms on contracts.roomId = rooms.id where DATE_FORMAT(contracts.endDate, '%Y-%m-%d') >= '$date' AND contracts.cancelledAt is null ";
            $contracts=mysqli_query($con,$query);
        }
    mysqli_close($con);
?>
 <title>Hợp đồng</title>
<body>
    <div class="flex">
        <?php include_once './sidebar(sv).php'; ?>
        <div class="flex-1 flex flex-col max-h-screen overflow-scroll">
            <div class="py-8 px-4 border-b flex justify-between">
                <div></div>
                <button class="p-2 px-4 rounded-full hover:bg-gray-100 transition">Chào mừng bạn quay trở lại 💙</button>
            </div>
            <div class="flex-1 p-4">
                <form method="GET">
                    <div class="flex gap-3 items-center">
                        <input value="<?php echo $p ?>" name="p" class="border p-3 focus:outline-none outline-none flex-1" type="text" placeholder="Tìm kiếm hợp đồng theo tên phòng, tên sinh viên">
                        <div  class="w-[180px] border p-3 focus:outline-none outline-none">
                            <select name="status" class="outline-none focus:outline-none w-full">
                                <option <?php echo $status=='Available' ? 'selected' : '' ?> id="option" class="text-sm" value="Available">
                                    Còn hạn
                                </option>
                                <option <?php echo $status=='Unavailable' ? 'selected' : '' ?>  id="option" class="text-sm" value="Unavailable">
                                    Quá hạn
                                </option>
                                <option <?php echo $status=='Cancelled' ? 'selected' : '' ?>  id="option" class="text-sm" value="Cancelled">
                                    Đã huỷ
                                </option>
                            </select>
                        </div>
                        <button name="find" type="submit" class="text-white bg-slate-800 p-3">Tìm kiếm</button>
                    </div>
                </form>

            <div class="grid grid-cols-4 gap-4 text-slate-600 mt-8">
                <?php
                if (mysqli_num_rows($contracts) == 0) {
                    echo '<div class="h-[60vh] grid place-items-center">Hiện tại không có loại phòng nào trong danh sách.</div>';
                } else {
                    while ($contract = mysqli_fetch_array($contracts)) {
                            $name=$contract['name'];
                            $MSV=$contract['MSV'];
                            $birthday=$contract['birthday'];
                            $sex=$contract['sex'];
                            $phoneNumber=$contract['phoneNumber'];
                            $class=$contract['class'];
                            $image=$contract['image_path'];
                            $roomId=$contract['roomId'];
                            $studentId=$contract['studentId'];
                            
                        echo '<form method="POST" class="text-sm">';
                        echo    '<img src="images/' . $image . '" alt="">';
                        echo    '<div class="px-2 py-4">';
                        echo        '<h1 class="mt-2">Tên: ' . $name . ' <span class="text-xs text-gray-400">- ' . ($sex == 'male' ? "Nam" : "Nữ") . '</span></h1>';
                        echo        '<h1 class="mt-2">MSV: ' . $MSV . '</h1>';
                        echo        '<h1 class="mt-2">Lớp: ' . $class . '</h1>';
                        echo        '<h1 class="mt-2">Phòng: ' . $contract['room_name'] . '</h1>';
                        echo        '<h1 class="mt-2">Thời gian bắt đầu: ' . $contract['startDate'] . '</h1>';
                        echo        '<h1 class="mt-2">Thời gian kết thúc: ' . $contract['endDate'] . '</h1>';
                        echo '<h1 class="mt-2">Trạng thái: <span class="' . ((new DateTime() > new DateTime($contract['endDate']) || $contract['cancelledAt']) ? 'text-rose-500' : '') . '">' . ($contract['cancelledAt'] ? 'Đã huỷ' : (new DateTime() < new DateTime($contract['endDate']) ? "Còn hạn" : "Hết hạn")) . '</span></h1>';
                                            if (isset($contract['numberOfAvailableContractsRemain']) && $contract['numberOfAvailableContractsRemain'] == 0) {
                            echo    '<div class="pt-4 w-full">';
                            echo        '<a href="http://localhost/QuanLyKyTucXa/contracts_add.php?MSV=' . $MSV . '&name=' . urlencode($name) . '&birthday=' . urldecode($birthday) . '&sex=' . urldecode($sex). '&phoneNumber='. urldecode($phoneNumber) . '&class='. urldecode($class). '&image='. $image . '&roomId='. $roomId . '&studentId='. $studentId .'&haveRoomId='. '"  class="p-3 bg-slate-600 text-white w-full">Gia hạn hợp đồng</a>';
                            echo    '</div>';
                        }
                        echo        '<input type="hidden" name="ma" value="' . $contract['id'] . '">';
                        echo        '<input type="hidden" name="roomId" value="' . $roomId . '">';
                        echo        '<button type="submit" class="bg-rose-600 p-2 text-white w-full mt-4" name="delete">Huỷ hợp đồng</button>';
                        echo        '<div class="p-2"></div>';
                        echo        "<a target='_blank' href='http://localhost/QuanLyKyTucXa/contracts_print.php?ma={$contract['id']}' class='block text-center bg-green-600 p-2 text-white w-full'>In hợp đồng</a>";
                        echo    '</div>';
                        echo  '</form>';
                    }
                }
                ?>
            </div>
        </div>
     </div>
</body>
