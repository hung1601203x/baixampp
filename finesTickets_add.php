<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');

    if(isset($_POST['submit'])){
        $MSV=$_POST['MSV'];
        $price=$_POST['price'];
        $description=$_POST['description'];

        $maxDate=$_POST['maxDate'];
        $type=$_POST['type'];

        // Kiểm tra tồn tại sinh viên có MSV tương ứng
        $sql="Select * from students where MSV = '$MSV'";
        $kq=mysqli_query($con,$sql);

        if (mysqli_num_rows($kq) == 0) {
            echo "<script>alert('Không tồn tại sinh viên có Mã sinh viên là $MSV')</script>";
        } else {
            $formattedDate = date('Y/m/d', strtotime($maxDate));
            while ($student = mysqli_fetch_array($kq)) {
                $studentId = $student['id'];
                $sql="Insert into finesTicket(studentId, description, type, price, maxDate) values ($studentId, '$description', '$type', $price, '$formattedDate')";
                $kq=mysqli_query($con,$sql);
                break;
            }
            header("location: finesTickets.php");
            exit;
        }
    }

    mysqli_close($con);
?>
 <title>Thêm phiếu phạt</title>
<body>
    <div class="flex">
        <?php include_once './sidebar.php'; ?>
        <div class="flex-1 flex flex-col max-h-screen overflow-scroll">
            <div class="py-8 px-4 border-b flex justify-between">
                <div></div>
                <button class="p-2 px-4 rounded-full hover:bg-gray-100 transition">Chào mừng bạn quay trở lại 💙</button>
            </div>
            <div class="flex-1 p-4">
            <form method="POST" class="flex flex-col gap-4">
                    <h1 class="text-4xl font-semibold pb-5">Thêm phiếu phạt</h1>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="type" class="block">Mã sinh viên</label>
                            <input required name="MSV" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mã sinh viên">
                        </div>
                        <div class="flex-1">
                            <label for="type" class="block">Hạn trả</label>
                            <input required name="maxDate" class="w-full border p-4 focus:outline-none outline-none mt-4" type="date">
                        </div>
                    </div>
                    <div class="flex gap-4">
                        
                        <div class="flex-1">
                            <label for="type" class="block">Lỗi phạt</label>
                            
                            <div  class="border p-4 focus:outline-none outline-none mt-4 w-full">
                                <select required class="w-full outline-none" name="type" id="">
                                    <option value="Làm hư hỏng tài sản">Làm hư hỏng tài sản</option>
                                    <option value="Ảnh hưởng vệ sinh môi trường">Ảnh hưởng vệ sinh môi trường</option>
                                    <option value="Trộm cắp tài sản">Trộm cắp tài sản</option>
                                    <option value="Nộp tiền chậm">Nộp tiền chậm</option>
                                    <option value="Uống rượu bia trong ký túc xá">Uống rượu bia trong ký túc xá</option>
                                    <option value="Hút thuốc không đúng nơi quy định">Hút thuốc không đúng nơi quy định</option>
                                    <option value="Gây ồn ào, đánh nhau trong ký túc xá">Gây ồn ào, đánh nhau trong ký túc xá</option>
                                    <option value="Tổ chức đánh bạc ăn tiền trong ký túc xá">Tổ chức đánh bạc ăn tiền trong ký túc xá</option>
                                    <option value="Leo trèo tường rào, lan can trong ký túc xá">Leo trèo tường rào, lan can trong ký túc xá</option>
                                    <option value="Hoạt động thể thao không đúng nơi quy định">Hoạt động thể thao không đúng nơi quy định</option>
                                    <option value="Nấu ăn dưới mọi hình thức">Nấu ăn dưới mọi hình thức</option>
                                    <option value="Đem động vật vào ký túc xá">Đem động vật vào ký túc xá</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex-1">
                            <label for="type" class="block">Tiền phạt</label>
                            <input required value="50000" name="price" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text">
                        </div>
                    </div>

                    <div class="flex-1">
                        <label for="type" class="block">Mô tả</label>
                        <textarea required placeholder="Mô tả" rows="4" name="description" class="w-full border p-4 focus:outline-none outline-none mt-4"></textarea>
                    </div>


                    <div class="flex gap-3 mt-4">
                        <a href="http://localhost/QuanLyKyTucXa/finesTickets.php" class=" text-center border border-slate-800 p-3 w-full">Trở lại</a>
                        <button name="submit" type="submit" class="text-white bg-slate-800 p-3 w-full">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
