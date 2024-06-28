<?php
    $con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

    $sql="select rooms.id, rooms.name, rooms.numberOfEmptyBed, room_types.name as type_name, room_types.maxNumberOfBed, room_types.description from rooms inner join room_types on rooms.roomTypeId = room_types.id    ";
    $data=mysqli_query($con,$sql);
    $result = null;

    $roomId = '';

    $haveRoomId = isset($_GET['haveRoomId']) ?  $_GET['haveRoomId'] : null;

    
    if(isset($_POST['submit'])){
        if($_POST['roomId']==''||$_POST['startDate']==''||$_POST['endDate']=='')
            echo "<script>alert('Phai nhap thong tin')</script>";  
        else{
            $startDate=$_POST['startDate'];
            $dateDistance=$_POST['endDate'];
            
            $roomId=$_POST['roomId'];


            $date = new DateTime($startDate);

            if ($dateDistance == 3) {
                $date->add(new DateInterval('P3M'));
            } elseif ($dateDistance == 6) {
                $date->add(new DateInterval('P6M'));
            } elseif ($dateDistance == 9) {
                $date->add(new DateInterval('P9M'));
            }

            $endDate = $date->format('Y/m/d');

            $name=$_GET['name'];
            $MSV=$_GET['MSV'];
            $birthday=$_GET['birthday'];
            $sex=$_GET['sex'];
            $phoneNumber=$_GET['phoneNumber'];
            $class=$_GET['class'];
            $image=$_GET['image'];
            $studentId=isset($_GET['studentId']) ? $_GET['studentId'] : "" ;

            if (!isset($haveRoomId)) {
                $sql = "INSERT INTO students(image_path, MSV, name, birthday, sex, phoneNumber, class) VALUES ('$image', '$MSV', '$name', '$birthday', '$sex', '$phoneNumber', '$class')";
                $result = mysqli_query($con, $sql);
            }
        
            if ($result || isset($haveRoomId)) {
                if (!$studentId) {
                    $studentId = mysqli_insert_id($con); // Get the ID of the newly inserted student
                }
                
                $sql = "INSERT INTO contracts(studentId, roomId, startDate, endDate) VALUES ('$studentId', '$roomId', '$startDate', '$endDate')";
                $result = mysqli_query($con, $sql);

                if (!isset($haveRoomId)) {
                    $sql = "select * from rooms where id = $roomId";
                    $result = mysqli_query($con, $sql);
                    while ($dt = mysqli_fetch_assoc($data)){
                        $newNumberOfEmptyBed = ($dt['numberOfEmptyBed']) - 1;
                        $sql = "update rooms set numberOfEmptyBed = $newNumberOfEmptyBed where id = $roomId";
                        $result = mysqli_query($con, $sql);
                        break;
                    }
                }

                if ($result) {
                    header("location: hopdong.php   ");
                } else {
                    echo "<script>alert('Lỗi khi thêm hợp đồng')</script>";
                }
            }
        }
    }

    mysqli_close($con);
?>
 <title>Tạo hợp đồng</title>
<body>
    <div class="flex">
        <?php
        include_once './sidebar(sv).php';
        ?>
        <div class="flex-1 flex flex-col max-h-screen overflow-scroll">
            <div class="py-8 px-4 border-b flex justify-between">
                <div></div>
                <button class="p-2 px-4 rounded-full hover:bg-gray-100 transition">Chào mừng bạn quay trở lại 💙</button>
            </div>
            <div class="flex-1 p-4">
            <form enctype="multipart/form-data" method="POST" class="flex flex-col gap-4">
                <h1 class="text-4xl font-semibold">Tạo hợp đồng</h1>
                <hr class="my-4">
                <h1 class="text-xl font-semibold mb-2">1. Chọn phòng</h1>
                <p class="text-xs text-rose-500 italic mb-4">* Không thể chọn phòng màu đỏ</p>
                <div class="grid grid-cols-4 gap-4 text-slate-600">

                <?php if (mysqli_num_rows($data) != 0) {
                    while ($room = mysqli_fetch_assoc($data)) { 
                        $isFull = $room['maxNumberOfBed'] == $room['maxNumberOfBed'] - $room['numberOfEmptyBed'];
                        ?>
                    <div class="room-select border p-4 <?= $isFull || isset($haveRoomId) ? 'pointer-events-none bg-rose-500 text-white' : 'cursor-pointer' ?>" data-room="<?= $room['id'] ?>">
                        <p class="mb-4 text-lg font-semibold">
                            <?= $room['name'] ?> - <span class="text-sm font-thin  <?= $isFull ? 'text-white' : 'text-gray-400' ?>"><?= $room['type_name'] ?></span>
                        </p>
                        <p>
                            <?= ($room['maxNumberOfBed'] - $room['numberOfEmptyBed']) ?>/ <?= $room['maxNumberOfBed'] ?> sinh viên
                        </p>
                    </div>

                    <?php } ?>
                <?php } ?>
                </div>
                <hr class="my-4">
                <h1 class="text-xl font-semibold mb-4">2. Thời hạn hợp đồng</h1>
                <div class="flex gap-8">
                    <div class="flex-1">
                        <label for="">Ngày bắt đầu</label>
                        <input required type="date" name="startDate" class="w-full border p-4 focus:outline-none outline-none mt-4">
                    </div>
                    <div class="flex-1">
                        <label for="">Loại hợp đồng</label>
                        <div class="flex gap-6 mt-6">
                            <div>
                                <input required type="radio" value="3" name="endDate">
                                <label for="">3 tháng</label>
                            </div>
                            <div>
                                <input required type="radio" value="3" name="endDate">
                                <label for="">6 tháng</label>
                            </div>
                            <div>
                                <input required type="radio" value="3" name="endDate">
                                <label for="">12 tháng</label>
                            </div>
                        </div>
                    </div>
                </div>

                <input value="<?php echo isset($_GET['roomId']) ? $_GET['roomId'] : '' ?>" type="hidden" name="roomId" id="selectedRoomId">
                <button name="submit" type="submit" class="text-white bg-slate-800 p-3 w-full mt-4">Tạo hợp đồng</button>
            </form>

            </div>
        </div>
    </div>
</body>

<script>
    const roomElements = document.querySelectorAll('.room-select');

    roomElements.forEach(roomElement => {
        roomElement.addEventListener('click', function () {
            if (roomElement.classList.contains('pointer-events-none') === false) {
                roomElements.forEach(roomElement2 => {
                    if (roomElement2.classList.contains('pointer-events-none') === false) {
                        roomElement2.classList.remove('text-white', 'bg-slate-800');
                        roomElement2.classList.add('hover:bg-slate-100');
                    }
                })
                roomElement.classList.add('text-white', 'bg-slate-800');
                roomElement.classList.remove('hover:bg-slate-100');
                
                const roomId = roomElement.getAttribute('data-room');
                document.querySelector('#selectedRoomId').value = roomId;
            }
        });
    });
</script>
