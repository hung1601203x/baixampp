
<?php
     $con=mysqli_connect('localhost','root','','quanLyKyTuc')
     or die('Lỗi kết nối');
     $ma=$_GET['ma'];
     $query ="SELECT * FROM room_types WHERE id = '$ma'";
     $data=mysqli_query($con,$query);
 
     if(isset($_POST['update'])){
         $name=$_POST['name'];
         $price=$_POST['price'];
         $maxNumberOfBed=$_POST['maxNumberOfBed'];
         $description=$_POST['description'];
         
             $sql="UPDATE room_types set name='$name', price='$price', maxNumberOfBed='$maxNumberOfBed', description='$description' where id='$ma'";
             $kq=mysqli_query($con,$sql);
             if($kq) {
                 header("location: room_Types.php");
                 exit;
             }
             else echo "<script>alert('Sửa thất bại!')</script>";
     }
 
     if(isset($_POST['delete'])){
         $sql="DELETE from room_types where id='$ma'";
         $kq=mysqli_query($con,$sql);
         echo "<script>alert('Xoá thành công!')</script>";
         header("location: room_Types.php");
     }
     mysqli_close($con);


?>
 <title>Cập nhật loại phòng</title>
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
                    <?php
                        if(isset($data)&& $data!=null){
                        while($row=mysqli_fetch_array($data)){
                    ?>

                    <h1 class="text-4xl font-semibold pb-5">Cập nhật <?php echo $row['name'] ?></h1>
                    <div class="flex gap-4 w-full">
                        <div class="flex-1">
                            <label for="name">Tên loại phòng</label>
                            <input required value="<?php echo $row['name'] ?>" name="name" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Tên loại phòng">
                        </div>
                        <div class="flex-1">
                            <label for="maxNumberOfBed">Số giường</label>
                            <input required value="<?php echo $row['maxNumberOfBed'] ?>" name="maxNumberOfBed" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Số giường">
                        </div>
                        <div class="flex-1">
                            <label for="price">Giá</label>
                            <input required value="<?php echo $row['price'] ?>" name="price" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mô tả">
                        </div>
                    </div>
                    <div>
                        <label for="description">Mô tả</label>
                        <input required value="<?php echo $row['description'] ?>" name="description" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mô tả">
                    </div>

                    <?php
                            }
                        }
                    ?>
                    <div class="flex gap-3 mt-4">
                        <a href="http://localhost/QuanLyKyTucXa/room_Types.php" class=" text-center border border-slate-800 p-3 w-full">Trở lại</a>
                        <button name="delete" type="submit" class="text-white bg-rose-600 p-3 w-full">Xoá</button>
                        <button name="update" type="submit" class="text-white bg-slate-800 p-3 w-full">Cập nhật</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</body>
