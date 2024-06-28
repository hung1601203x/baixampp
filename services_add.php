<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');

    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $price=$_POST['price'];
        $isRequired=$_POST['isRequired'];
        
            $sql="Insert into services(name, price, isRequired) values('$name', $price, $isRequired)";
            $kq=mysqli_query($con,$sql);
            if($kq) {
                header("location: services.php");
                exit;
            }
            else echo "<script>alert('Sửa thất bại!')</script>";
    }
    mysqli_close($con);
?>
 <title>Thêm dịch vụ</title>
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
                    <h1 class="text-4xl font-semibold pb-5">Thêm dịch vụ</h1>
                    <div class="flex gap-4">

                        <div class="flex-1">
                            <label for="type" class="block">Tên dịch vụ</label>
                            <input required name="name" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Tên dịch vụ">
                        </div>
                        <div class="flex-1">
                            <label for="type" class="block">Giá dịch vụ</label>
                            <input required name="price" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Giá dịch vụ">
                        </div>
                        <div class="flex-1">
                            <label for="type" class="block">Là dịch vụ bắt buộc</label>
                            <div class="flex gap-4 items-center h-[60px]">
                                <div>
                                    <label for="isRequiredYes">Bắt buộc</label>
                                    <input required value="1" type="radio" name="isRequired" id="isRequiredYes" checked>
                                </div>
                                <div>
                                    <label for="isRequiredNo">Không bắt buộc</label>
                                    <input required value="0" type="radio" name="isRequired" id="isRequiredNo">
                                </div>
                            </div>


                        </div>
                        
                    </div>
                    <div class="flex gap-3 mt-4">
                        <a href="/services.php" class=" text-center border border-slate-800 p-3 w-full">Trở lại</a>
                        <button name="submit" type="submit" class="text-white bg-slate-800 p-3 w-full">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
