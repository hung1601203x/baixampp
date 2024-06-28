<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');

    $query="SELECT * FROM room_types";
    $roomTypes=mysqli_query($con,$query);
    
    if(isset($_POST['submit'])){
        $type = $_POST['type'];
        $name=$_POST['type'].$_POST['name'];
        $roomTypeId = $_POST['roomTypeId'];
        $numberOfEmptyBed = $_POST['numberOfEmptyBed'];

       
            $numberOfEmptyBed = intval($numberOfEmptyBed);


            $sql="Insert into rooms(name, roomTypeId, numberOfEmptyBed) values('$name', '$roomTypeId', '$numberOfEmptyBed')";
            $kq=mysqli_query($con,$sql);
            if($kq) {
                header("location: rooms.php");
                exit;
            }
            else echo "<script>alert('Thêm thất bại!')</script>";
    }
    mysqli_close($con);
?>
 <title>Thêm phòng</title>
<body>
    <div class="flex">
        <?php
        include_once './sidebar.php';
        ?>
        <div class="flex-1 flex flex-col max-h-screen overflow-scroll">
            <div class="py-8 px-4 border-b flex justify-between">
                <div></div>
                <button class="p-2 px-4 rounded-full hover:bg-gray-100 transition">Chào mừng bạn quay trở lại 💙</button>
            </div>
            <div class="flex-1 p-4">
                <form method="POST" class="flex flex-col gap-4">
                    <h1 class="text-4xl font-semibold pb-5">Thêm phòng mới</h1>
                    <div class="flex gap-4 w-full">
                        <div class="flex-1">
                            <label for="name">Dãy</label>
                            <div class="border p-4 focus:outline-none outline-none mt-4 w-full">
                                <select name="type" id="type" class="max-w-[90%] outline-none focus:outline-none w-full">
                                    <option value="A">A - Con trai</option>
                                    <option value="B">B - Con gái</option>
                                </select>
                            </div>        </div>
                        <div class="flex-1">
                            <label for="name">Số phòng</label>
                            <input required name="name" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Số phòng">
                        </div>
                        </div>

                        <div>
                            <label for="type" class="block">Loại phòng</label>
                            <input id="hiddenBedInput" name="numberOfEmptyBed" type="hidden">
                            <div  class="border p-4 focus:outline-none outline-none mt-4 w-full">
                                <select  id="roomTypeSelect" name="roomTypeId" class="max-w-[97%] outline-none focus:outline-none w-full">
                                <?php
                                        if(isset($roomTypes)&& $roomTypes!=null){
                                        while($row=mysqli_fetch_array($roomTypes)){
                                ?>
                                        <option  data-bed="<?php echo $row['maxNumberOfBed'] ?>" id="option" class="text-sm" value="<?php echo $row['id'] ?>">
                                            <?php echo $row['name'] ?> - <?php echo $row['price'] ?>: 
                                            <?php echo $row['description'] ?>
                                        </option>
                                <?php
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <a href="/rooms.php" class=" text-center border border-slate-800 p-3 w-full">Trở lại</a>
                        <button name="submit" type="submit" class="text-white bg-slate-800 p-3 w-full">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    const roomTypeSelect = document.getElementById('roomTypeSelect');
    const hiddenBedInput = document.getElementById('hiddenBedInput');

    roomTypeSelect.options.selectedIndex = 0
    hiddenBedInput.value = roomTypeSelect.options[roomTypeSelect.options.selectedIndex].getAttribute('data-bed');

    document.addEventListener('DOMContentLoaded', function() {
        const roomTypeSelect = document.getElementById('roomTypeSelect');
        const hiddenBedInput = document.getElementById('hiddenBedInput');

        roomTypeSelect.addEventListener('change', function() {
            const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
            const bedValue = selectedOption.getAttribute('data-bed');
            hiddenBedInput.value = bedValue;
        });
    });
</script>
