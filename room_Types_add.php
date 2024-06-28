<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');

    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $price=$_POST['price'];
        $maxNumberOfBed=$_POST['maxNumberOfBed'];
        $description=$_POST['description'];
            $sql="Insert into room_types(name, price, maxNumberOfBed, description) values('$name', '$price', '$maxNumberOfBed', '$description')";
            $kq=mysqli_query($con,$sql);
            if($kq) {
                header("location: room_Types.php");
                exit;
            }
    }
    mysqli_close($con);
?>
 <title>Thêm loại phòng mới</title>
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
                <h1 class="text-4xl font-semibold pb-5">Thêm loại phòng mới</h1>
                <div class="flex gap-4 w-full">
                    <div class="flex-1">
                        <label for="name">Tên loại phòng</label>
                        <input required name="name" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Tên loại phòng">
                    </div>
                    <div class="flex-1">
                        <label for="maxNumberOfBed">Số giường</label>
                        <input required name="maxNumberOfBed" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Số giường">
                    </div>
                    <div class="flex-1">
                        <label for="price">Giá</label>
                        <input required name="price" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mô tả">
                    </div>
                </div>
                <div>
                    <label for="description">Mô tả</label>
                    <input required name="description" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mô tả">
                </div>
                <div class="flex gap-3 mt-4">
                    <a href="/room_Types.php" class=" text-center border border-slate-800 p-3 w-full">Trở lại</a>
                    <button name="submit" type="submit" class="text-white bg-slate-800 p-3 w-full">Thêm</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</body>
