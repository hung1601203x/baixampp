<?php
$con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');
$rowNumber = 1;
$data=[];
$p='';

if (isset($_GET['find'])) {
    $p = $_GET['p'];
    $query = "SELECT rooms.id, rooms.name, room_types.name AS roomType_name, room_types.maxNumberOfBed, rooms.numberOfEmptyBed FROM rooms INNER JOIN room_types ON rooms.roomTypeId = room_types.id where rooms.name like '%$p%'";
    $result = mysqli_query($con, $query);

} else {
    $query = "SELECT rooms.id, rooms.name, room_types.name AS roomType_name, room_types.maxNumberOfBed, rooms.numberOfEmptyBed FROM rooms INNER JOIN room_types ON rooms.roomTypeId = room_types.id";
    $result = mysqli_query($con, $query);

}

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

if (isset($data)) {
    $ml_rooms = array_filter($data, function ($room) {
        return strpos($room['name'], 'A') !== false;
    });
    
    $fml_rooms = array_filter($data, function ($room) {
        return strpos($room['name'], 'B') !== false;
    });
} else {
    $ml_rooms = [];
    $fml_rooms = [];
}

mysqli_close($con);
?>
 <title>Thông tin phòng</title>
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
                        <input value="<?php echo $p ?>" name="p" class="border p-3 focus:outline-none outline-none flex-1" type="text"
                            placeholder="Tìm kiếm phòng theo tên phòng">
                        <button name="find" type="submit" class="border border-slate-800 p-3">Tìm kiếm</button>
                    </div>
                </form>
                <?php if (mysqli_num_rows($result) == 0) : ?>
                    <div class="h-[60vh] grid place-items-center">Hiện tại không có phòng nào trong danh sách.</div>
                <?php else : ?>
                    <div class="text-2xl my-6 font-semibold ">A - Toà con trai</div>
                    <div class="grid grid-cols-3 gap-4 text-slate-600">
                        <?php
                            foreach ($ml_rooms as $ml_room ) :
                                $isFull = $ml_room['maxNumberOfBed'] == $ml_room['maxNumberOfBed'] - $ml_room['numberOfEmptyBed'] ;
                        ?>
                        <div class="relative">

                            <a target="_blank" href="http://localhost/QuanLyKyTucXa/phong(sv).php?ma=<?php echo $ml_room['id'] ?>" class="block border p-4 <?= $isFull ? 'bg-rose-500 text-white' : '' ?>">
                                <p class="mb-4 text-lg font-semibold">
                                    <?php echo $ml_room['name'] ?> - <span class="text-sm font-thin <?= $isFull ? 'text-white' : 'text-gray-400 ' ?>"> <?php echo $ml_room['roomType_name'] ?></span>
                                </p>
                                <p>
                                    <?php echo $ml_room['maxNumberOfBed'] - $ml_room['numberOfEmptyBed'] ?>/ <?php echo $ml_room['maxNumberOfBed'] ?> sinh viên
                                </p>
                            </a>
                        </div>
                        <?php
                            endforeach;
                        ?>
                    </div>

                    <div class="text-2xl my-6 font-semibold ">B - Toà con gái</div>
                    <div class="grid grid-cols-3 gap-4 text-slate-600">
                        <?php
                            foreach ($fml_rooms as $fml_room ) :
                                $isFull = $fml_room['maxNumberOfBed'] == $fml_room['maxNumberOfBed'] - $fml_room['numberOfEmptyBed'] ;

                        ?>
                        <div class="relative">

                            <a target="_blank" href="http://localhost/QuanLyKyTucXa/rooms_detail.php?ma=<?php echo $fml_room['id'] ?>" class="block border p-4 relative <?= $isFull ? 'bg-rose-500 text-white' : '' ?>">
                                <p class="mb-4 text-lg font-semibold">
                                    <?php echo $fml_room['name'] ?> - <span class="text-sm font-thin text-gray-400"> <?php echo $fml_room['roomType_name'] ?></span>
                                </p>
                                <p>
                                    <?php echo $fml_room['maxNumberOfBed'] - $fml_room['numberOfEmptyBed'] ?>/ <?php echo $fml_room['maxNumberOfBed'] ?> sinh viên
                                </p>
                            </a>
                        </div>
                        <?php
                            endforeach;
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
