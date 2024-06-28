<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');

    $query ="UPDATE finesTicket SET status = 'OutDate' WHERE maxDate < CURDATE() and id >0 and status = 'Pending'";
    $finesTickets=mysqli_query($con,$query);
    $p = '';
    $status = '';
    
    
    if(isset($_GET['find']))
    {
            $p=$_GET['p'];
            $status = $_GET['status'];
            $statusQuery = $status ==  'All' ? '' : "and status like '%$status%'";
            $query ="select finesTicket.id, studentId, description, type, price, status, maxDate, finesTicket.createdAt, finesTicket.payDate, students.MSV, students.name, students.sex, students.class from finesTicket inner join students on finesTicket.studentId = students.id WHERE students.name like '%$p%' $statusQuery";
            $finesTickets=mysqli_query($con,$query);
        }
    else {
        $query="select finesTicket.id, studentId, description, type, price, status, maxDate, finesTicket.createdAt, finesTicket.payDate, students.MSV, students.name, students.sex, students.class from finesTicket inner join students on finesTicket.studentId = students.id             ";
        $finesTickets=mysqli_query($con,$query);
    }

    if(isset($_POST['check'])){
        $ma=$_POST['ma'];
        $sql="update finesTicket set status = 'Success' where id = $ma";
        $kq=mysqli_query($con,$sql);

        header("location: finesTickets.php");
        exit;
    }

    mysqli_close($con);
?>
 <title>Phiếu phạt </title>
<body>
    <div class="flex">
        <?php include_once './sidebar.php'; ?>
        <div class="flex-1 flex flex-col max-h-screen overflow-scroll">
            <div class="py-8 px-4 border-b flex justify-between">
                <div></div>
                <button class="p-2 px-4 rounded-full hover:bg-gray-100 transition">Chào mừng bạn quay trở lại 💙</button>
            </div>
            <div class="flex-1 p-4">
                <form method="GET">
                    <div class="flex gap-3 items-center">
                        <input value="<?php echo $p ?>" name="p" class="border p-3 focus:outline-none outline-none flex-1" type="text" placeholder="Tìm kiếm phiếu phạt theo tên sinh viên">
                        <div class="w-[180px] border p-3 focus:outline-none outline-none">
                            <select required name="status" class="outline-none focus:outline-none w-full">
                                <option selected="<?php echo $status=='' ?>" id="option" class="text-sm" value="All">
                                    Tất cả
                                </option>
                                <option selected="<?php echo $status=='Success' ?>"  id="option" class="text-sm" value="Success">
                                    Đã xử lí
                                </option>
                                <option selected="<?php echo $status=='Pending' ?>"  id="option" class="text-sm" value="Pending">
                                    Chờ xử lí
                                </option>
                                <option selected="<?php echo $status=='OutDate' ?>"  id="option" class="text-sm" value="OutDate">
                                    Quá hạn
                                </option>
                            </select>
                        </div>
                        <button name="find" type="submit" class="border border-slate-800 p-3">Tìm kiếm</button>
                        <a href="http://localhost/QuanLyKyTucXa/finesTickets_add.php" class="text-white bg-slate-800 p-3">+ Thêm mới</a>
                    </div>
                </form>

                <?php
            if (mysqli_num_rows($finesTickets) == 0) {
                echo '<div class="h-[60vh] grid place-items-center">Hiện tại không có phiếu phạt nào trong danh sách.</div>';
            } else {
                echo '<div class="grid grid-cols-3 gap-4 pt-4">';
                while ($fine = mysqli_fetch_array($finesTickets)) {
                    $statusColor=$fine['status'] == 'Pending' ? 'yellow' : ($fine['status'] == 'Success' ? 'green' : 'rose');
                    $status = $fine['status'] == 'Pending' ? 'Chờ xử lí' : ($fine['status'] == 'Success' ? 'Đã xử lý' : 'Quá hạn');
                ?>
                    <form method="POST" class="border border-gray-100 text-slate-500 p-4 text-sm relative">
                        <input type="hidden" name="ma" value="<?php echo $fine['id'] ?>">
                        <div class="absolute top-0 right-0 p-1 text-xs text-white bg-<?php echo $statusColor ?>-600">
                            <?php 
                                echo $status;
                            ?>
                        </div>
                        <h1 class="text-xl text-black font-semibold mt-2">
                            <?php echo $fine['type'] ?>
                        </h1>
                        <p class="mt-2">
                            Mô tả: <?php echo $fine['description'] ?>
                        </p>
                        <p class="mt-2">
                            Tiền phạt: <?php echo $fine['price'] ?>đ
                        </p>
                        <p class="mt-2">
                            Hạn trả: <?php echo $fine['maxDate'] ?>
                        <hr class="mt-2">
                        <p class="mt-2">
                            Tên sinh viên: <?php echo $fine['name'] ?>
                        </p>
                        <p class="mt-2">
                            Giới tính: <?php echo $fine['sex'] == 'male' ? 'Nam' : 'Nữ' ?>
                        </p>
                        <p class="mt-2">
                            MSV: <?php echo $fine['MSV'] ?>
                        </p>
                        <p class="mt-2">
                            Lớp: <?php echo $fine['class'] ?>
                        </p>
                        <?php 
                            if ($fine['status'] != 'Success') {
                        ?>
                            <hr class="mt-2">
                            <div class="flex items-center justify-center mt-2 gap-6 p-2">
                                <button type="submit" name="check" class="duration-200 p-2 bg-gray-100 rounded-full hover:text-white hover:bg-green-400 material-symbols-outlined">
                                    done
                                </button>
                            </div>
                        <?php 
                            }
                        ?>
                    </form>
                <?php
                }
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
</body>
