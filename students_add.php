<?php
    $con=mysqli_connect('localhost','root','','quanLyKyTuc')
    or die('Lỗi kết nối');

    if(isset($_POST['submit'])){
        if(!isset($_FILES["image"])||$_POST['name']==''||$_POST['MSV']==''||$_POST['birthday']==''||$_POST['sex']==''||$_POST['phoneNumber']==''||$_POST['class']=='')
            echo "<script>alert('Phai nhap thong tin')</script>";  
        else{
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
            
                header('Location: contracts_add.php?image=' . urlencode($generatedImageName) . '&name=' . urlencode($name). '&MSV=' . urlencode($MSV). '&birthday=' . urlencode($birthday). '&sex=' . urlencode($sex). '&phoneNumber=' . urlencode($phoneNumber). '&class=' . urlencode($class));
                exit;
        }
    }
    mysqli_close($con);
?>
 <title>Thêm sinh viên</title>
<body>
    <div class="flex">
        <?php
        include_once './sidebar.php';
        ?>
        <div class="flex-1 p-4">
        <form enctype="multipart/form-data" method="POST" class="flex flex-col gap-4">
            <h1 class="text-4xl font-semibold pb-5">Thêm sinh viên</h1>
            <div class="flex gap-4 w-full">
                <label class="relative border border-dashed h-[350px] w-[500px] grid place-items-center cursor-pointer">
                    <input required id="imageStudent" name="image" type="file" class="opacity-0 absolute inset-0 cursor-pointer">
                    <span>+</span>
                <img id="selectedImage" src="#" alt="Selected Image" style="display: none;" class=" absolute inset-0 z-1">

                </label>
                <div class="w-full">
                    <div>
                        <label for="name">Tên sinh viên</label>
                        <input required name="name" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Tên sinh viên">
                    </div>
                    <div class="mt-4">
                        <label for="MSV">Mã sinh viên</label>
                        <input required name="MSV" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mã sinh viên">
                    </div>
                    <div class="mt-4">
                        <label for="">Ngày sinh</label>
                        <input required type="date" name="birthday" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Ngày sinh">
                    </div>
                </div>
                
            </div>

            <div class="flex gap-4 w-full">
                <div class="flex-1">
                    <label for="price">Giới tính</label>
                    <div  class="border p-4 focus:outline-none outline-none mt-4 w-full">
                        <select name="sex" class="max-w-[97%] outline-none focus:outline-none w-full">
                            <option value="male">Nam</option>
                            <option value="female">Nữ</option>
                        </select>
                    </div>
                </div>
                <div class="flex-1">
                    <label for="phoneNumber">Số điện thoại</label>
                    <input required name="phoneNumber" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mô tả">
                </div>
                <div class="flex-1">
                    <label for="class">Lớp</label>
                    <input required name="class" class="w-full border p-4 focus:outline-none outline-none mt-4" type="text" placeholder="Mô tả">
                </div>
            </div>
            <div class="flex gap-3 mt-4">
                <a href="/students.php" class=" text-center border border-slate-800 p-3 w-full">Trở lại</a>
                <button name="submit" type="submit" class="text-white bg-slate-800 p-3 w-full">Tiếp</button>
            </div>
        </form>
    </div>
    </div>
</body>

<script>
    document.getElementById('imageStudent').addEventListener('change', function(e) {
        const selectedImage = document.getElementById('selectedImage');
        console.log(e)
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                selectedImage.src = e.target.result;
                selectedImage.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
