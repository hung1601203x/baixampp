<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');


    if(isset($_GET['find']))
        {
            $p=$_GET['p'];
            $query ="SELECT * FROM room_types WHERE name like '%$p%' or price like '%$p%' or maxNumberOfBed like '%$p%'";
            $roomTypes=mysqli_query($con,$query);
        }
        else {
            $query="SELECT * FROM room_types";
            $roomTypes=mysqli_query($con,$query);
        }
    mysqli_close($con);
?>
 <title>Các loại phòng</title>
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
                        <input name="p" class="border p-3 focus:outline-none outline-none flex-1" type="text" placeholder="Tìm kiếm loại phòng theo tên, giá tiền hoặc số giường">
                        <button name="find" type="submit" class="border border-slate-800 p-3">Tìm kiếm</button>
                        <a href="http://localhost/QuanLyKyTucXa/room_Types_add.php" class="text-white bg-slate-800 p-3">+ Thêm mới</a>
                    </div>
                </form>

                <?php
            if (mysqli_num_rows($roomTypes) == 0) {
                echo '<div class="h-[60vh] grid place-items-center">Hiện tại không có loại phòng nào trong danh sách.</div>';
            } else {
                echo '<div class="grid grid-cols-3 gap-4">';
                while ($type = mysqli_fetch_array($roomTypes)) {
                    echo "<a href='http://localhost/QuanLyKyTucXa/room_Types_edit.php?ma={$type['id']}' class='p-4 mt-4 hover:bg-gray-100 border border-gray-100 cursor-pointer duration-100'>";
                    echo '<div class="font-semibold text-xl mb-4 flex justify-between items-center">';
                    echo "<span>{$type['name']}</span>";
                    echo "<span class='text-sm text-gray-500'>{$type['price']} VND</span>";
                    echo '</div>';
                    echo '<div class="flex items-center justify-between mb-4">';
                    echo '<span>Số giường</span>';
                    echo "<span class='text-sm text-gray-500'>{$type['maxNumberOfBed']}</span>";
                    echo '</div>';
                    echo '<span>Mô tả:</span>';
                    echo "<span class='text-sm text-gray-500'>{$type['description']}</span>";
                    echo '</a>';
                }
                
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
</body>
