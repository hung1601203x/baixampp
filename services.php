<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');


    if(isset($_GET['find']))
        {
            $p=$_GET['p'];
            $query ="SELECT * FROM services WHERE name like '%$p%'";
            $services=mysqli_query($con,$query);
        }
        else {
            $query="SELECT * FROM services";
            $services=mysqli_query($con,$query);
        }
    mysqli_close($con);
?>
 <title>Quản lí dịch vụ</title>
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
                        <input name="p" class="border p-3 focus:outline-none outline-none flex-1" type="text" placeholder="Tìm kiếm dịch vụ theo tên">
                        <button name="find" type="submit" class="border border-slate-800 p-3">Tìm kiếm</button>
                        <a href="http://localhost/QuanLyKyTucXa/services_add.php" class="text-white bg-slate-800 p-3">+ Thêm mới</a>
                    </div>
                </form>

                <?php
            if (mysqli_num_rows($services) == 0) {
                echo '<div class="h-[60vh] grid place-items-center">Hiện tại không có dịch vụ nào trong danh sách.</div>';
            } else {
                echo '<div class="grid grid-cols-3 gap-4 pt-4">';
                while ($service = mysqli_fetch_array($services)) {
                    $isRequired = $service['isRequired'];
                ?>

                    <div class="border border-gray-100 p-4 text-sm relative">
                        <a href="http://localhost/QuanLyKyTucXa/services_edit.php?ma=<?php echo $service['id'] ?>" class="material-symbols-outlined absolute -top-2 -right-2 p-2 border bg-white rounded-full hover:bg-slate-800 hover:text-white duration-200">
                            edit
                        </a>
                        <h1 class="text-xl font-semibold">

                            Dịch vụ <?php echo $service['name'] ?>
                        </h1>
                        <p class="mt-3 mb-2">Giá/ tháng: <?php echo $service['price'] ?>đ</p>
                        <p>Là dịch vụ bắt buộc: <span class="<?php echo $isRequired ? 'text-rose-500' : '' ?>"> <?php echo $isRequired ? 'Bắt buộc' : 'Không bắt buộc' ?> </span> </p>
                    </div>
                <?php
                }
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
</body>
