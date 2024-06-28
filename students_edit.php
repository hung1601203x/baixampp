<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');

    
    $ma=$_GET['ma'];

    $query ="SELECT * FROM students WHERE id = '$ma'";
    $data=mysqli_query($con,$query);

    if(isset($_POST['submit'])){
                $timestamp = time();
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $generatedImageName = 'image' . $timestamp . $name . '.' . $extension;
            
                $uploadDir = 'images/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
            
                $targetPath = $uploadDir . $generatedImageName;
                move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);

                $name=$_POST['name'];
                $MSV=$_POST['MSV'];
                $birthday=$_POST['birthday'];
                $sex=$_POST['sex'];
                $phoneNumber=$_POST['phoneNumber'];
                $class=$_POST['class'];

                $sql="UPDATE students set name='$name', MSV='$MSV', birthday='$birthday', sex='$sex', phoneNumber='$phoneNumber', class='$class' where id='$ma'";
                $result = mysqli_query($con, $sql);
            
                exit;
        }
    mysqli_close($con);
?>
 <title>Sửa thông tin sinh viên</title>
<body>
    <div class="flex">
        <?php
        include_once './sidebar.php';
        ?>
        <div class="flex-1 p-4">
        <form enctype="multipart/form-data" method="POST" class="flex flex-col gap-4">
            <h1 class="text-4xl font-semibold pb-5">Thêm sinh viên</h1>
            <?php
                        if(isset($data)&& $data!=null){
                        while($row=mysqli_fetch_array($data)){
            ?>
            <div class="flex gap-4 w-full">
                <label class="relative border border-dashed h-[350px] w-[500px] grid place-items-center cursor-pointer">
                    <input required id="imageStudent" name="image" type="file" class="opacity-0 absolute inset-0 cursor-pointer">
                    <span>+</span>
                <img id="selectedImage" src="<?php echo ('images/' . $row['image_path']); ?>" alt="Selected Image" class=" absolute inset-0 z-1">

                </label>
                <div class="w-full">
                    <div>
                        <label for="name">Tên sinh viên</label>
                        <input required value="<?php echo $row['name'] ?>" name="name" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Tên sinh viên">
                    </div>
                    <div class="mt-4">
                        <label for="MSV">Mã sinh viên</label>
                        <input required value="<?php echo $row['MSV'] ?>" name="MSV" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mã sinh viên">
                    </div>
                    <div class="mt-4">
                        <label for="">Ngày sinh</label>
                        <input required value="<?php echo $row['birthday'] ?>" type="date" name="birthday" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Ngày sinh">
                    </div>
                </div>
                
            </div>

            <div class="flex gap-4 w-full">
                <div class="flex-1">
                    <label for="price">Giới tính</label>
                    <div  class="border p-4 focus:outline-none outline-none mt-4 w-full">
                        <select value="<?php echo $row['sex'] ?>" name="sex" class="max-w-[97%] outline-none focus:outline-none w-full">
                            <option value="male">Nam</option>
                            <option value="female">Nữ</option>
                        </select>
                    </div>
                </div>
                <div class="flex-1">
                    <label for="phoneNumber">Số điện thoại</label>
                    <input required value="<?php echo $row['phoneNumber'] ?>" name="phoneNumber" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mô tả">
                </div>
                <div class="flex-1">
                    <label for="class">Lớp</label>
                    <input required value="<?php echo $row['class'] ?>" name="class" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mô tả">
                </div>
            </div>
            <?php
                            }
                        }
                    ?>
            <div class="flex gap-3 mt-4">
                <a href="http://localhost/QuanLyKyTucXa/students.php" class=" text-center border border-slate-800 p-3 w-full">Trở lại</a>
                <button name="submit" type="submit" class="text-white bg-slate-800 p-3 w-full">Tiếp</button>
            </div>
        </form>
    </div>
    </div>
</body>

<script>
    document.getElementById('imageStudent').addEventListener('change', function(e) {
        const selectedImage = document.getElementById('selectedImage');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                selectedImage.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
