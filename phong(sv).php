<?php
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

if (isset($_GET['ma'])) {
    $ma = $_GET['ma'];
    $query = "SELECT rooms.id, rooms.name, room_types.name AS roomType_name, room_types.maxNumberOfBed, rooms.numberOfEmptyBed, room_types.price, room_types.description FROM rooms INNER JOIN room_types ON rooms.roomTypeId = room_types.id where rooms.id = '$ma'";
    $result = mysqli_query($con, $query);
    $query = "SELECT students.id, image_path, MSV, name, birthday, sex, phoneNumber, class from students inner join contracts on students.id = contracts.studentId where contracts.roomId = $ma and cancelledAt is null";
    $students = mysqli_query($con, $query);

}

mysqli_close($con);
?>
 <title>Phòng</title>
<body>
    <div class="flex">
        <?php include_once './sidebar(sv).php'; ?>
        <div class="flex-1 flex flex-col max-h-screen overflow-scroll">
            <div class="py-8 px-4 border-b flex justify-between">
                <div></div>
                <button class="p-2 px-4 rounded-full hover:bg-gray-100 transition">Chào mừng bạn quay trở lại 💙</button>
            </div>
            <div class="flex-1 p-4">
                <?php if (mysqli_num_rows($result) == 0) : ?>
                    <div class="h-[60vh] grid place-items-center">Hiện tại không có phòng nào trong danh sách.</div>
                <?php else : ?>
                        <?php
                            foreach ($result as $dt ) :
                        ?>
                            <div class="mt-4">
                                <span class="text-3xl"><?php echo $dt['name'] ?> </span><span class="text-lg text-gray-500">- <?php echo $dt['maxNumberOfBed'] - $dt['numberOfEmptyBed'] ?>/ <?php echo $dt['maxNumberOfBed'] ?></span>
                                <div class="pt-2">Mô tả: <?php echo $dt['description'] ?></div>
                                <div class="pt-2">Giá: <?php echo $dt['price'] ?></div>
                                <div class="pt-2">Thành viên:</div>
                                <div class="grid grid-cols-4 gap-4 w-full mt-4">
                                 <?php
                                    foreach ($students as $st ) :
                                ?>
                                    <div class="text-sm hover:bg-slate-100 cursor-pointer duration-100">
                                        <img src="images/<?php echo $st['image_path'] ?>" alt="">
                                        <div class="py-2 px-4">
                                            <h1 class="mt-2">
                                                Họ và tên: <?php echo $st['name'] ?>
                                            </h1>
                                            <h1 class="mt-2">
                                                MSV: <?php echo $st['MSV'] ?>
                                            </h1>
                                            <h1 class="mt-2">
                                                Lớp: <?php echo $st['class'] ?>
                                            </h1>
                                            <h1 class="mt-2">
                                                Sinh ngày: <?php echo $st['birthday'] ?>
                                            </h1>
                                            <h1 class="mt-2">
                                                Giới tính: <?php echo $st['sex'] ='male' ? "Nam" : "Nữ" ?>
                                            </h1>
                                            <h1 class="mt-2">
                                                Số điện thoại: <?php echo $st['phoneNumber'] ?>
                                            </h1>
                                            
                                        </div>
                                
                                    </div>
                                 <?php
                                    endforeach
                                ?>
                                </div>
                            </div>

                        <?php
                            endforeach
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
