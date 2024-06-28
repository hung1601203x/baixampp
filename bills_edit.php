
<?php
     $con=mysqli_connect('localhost','root','','quanLyKyTuc')
     or die('Lỗi kết nối');
     $ma=$_GET['ma']; 

     $query ="SELECT waterUnitPrice, electricityUnitPrice, oldWaterNumber, newWaterNumber,oldElectricityNumber,newElectricityNumber, rooms.name, bills.createdAt FROM bills inner join rooms on bills.roomId = rooms.id WHERE bills.id = '$ma'";
     $data=mysqli_query($con,$query);

     $query ="SELECT * from services";
     $services=mysqli_query($con,$query);

     $servicesTotal = 0;

     while($sv=mysqli_fetch_array($services)){
        $servicesTotal+= $sv['price'];
     }


     if(isset($_POST['update'])){
            
         $newWaterNumber=$_POST['newWaterNumber'];
         $newElectricityNumber=$_POST['newElectricityNumber'];
 
        $sql="UPDATE bills set servicesPrice=$servicesTotal, newWaterNumber='$newWaterNumber', newElectricityNumber='$newElectricityNumber' where id='$ma'";
        $kq=mysqli_query($con,$sql);
        if($kq) {
            header("location: bills.php");
            exit;
        }
        else echo "<script>alert('Sửa thất bại!')</script>";
     }
 
     mysqli_close($con);

?>
 <title>Cập nhật hoá đơn</title>
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
                        $rowNumber = 1;
                        while($row=mysqli_fetch_array($data)){
                            $date = date("m-Y", strtotime($row['createdAt']));

                    ?>

                    <h1 class="text-4xl font-semibold pb-5">Cập nhật hoá đơn tháng <?php echo $date ?> của phòng <?php echo $row['name'] ?></h1>
                    <div class="flex gap-4 w-full">
                        <div class="flex-1">
                            <label for="name">Số nước mới</label>
                            <input required type='number' value="<?php echo $row['newWaterNumber'] ?>" name="newWaterNumber" class="w-full border p-4 focus:outline-none outline-none mt-4" placeholder="Tên loại phòng">
                        </div>
                        <div class="flex-1">
                            <label for="maxNumberOfBed">Số điện mới</label>
                            <input required type='number' value="<?php echo $row['newElectricityNumber'] ?>" name="newElectricityNumber" class="w-full border p-4 focus:outline-none outline-none mt-4" placeholder="Số giường">
                        </div>
                    </div>
                    <div>
                        <h1 class="mb-2">- Tổng tiền chi tiết</h1>
                        <?php
                            foreach ($services as $service ) :    
                        ?>
                            <div class="flex justify-between mt-2 text-gray-600">
                                <div><?php echo $rowNumber .'. '. $service['name'] ?></div>
                                <div><?php echo $service['price'] ?></div>
                            </div>
                        <?php
                                ++$rowNumber;
                            endforeach;
                        ?>

                        <span id="servicesTotal" class="hidden"><?php echo $servicesTotal ?></span>

                        <?php
                            $elecPrice = ($row['newElectricityNumber'] - $row['oldElectricityNumber'])*$row['electricityUnitPrice'];
                            $waterPrice = ($row['newWaterNumber'] - $row['oldWaterNumber'])*$row['waterUnitPrice'];

                        ?>

                        <div class="flex justify-between mt-2 text-gray-600">
                            <div><?php echo $rowNumber++. '. ' ?>Điện: <span>10</span>x <span id="electricityUnitPrice"><?php echo $row['electricityUnitPrice'] ?></span>/ số</div>
                            <div id="electricityPrice"><?php echo $elecPrice ?></div>
                        </div>
                        <div class="flex justify-between mt-2 text-gray-600">
                            <div><?php echo $rowNumber. '. ' ?>Nước: <span>10</span>x <span id="waterUnitPrice"><?php echo $row['waterUnitPrice'] ?></span>/ khối</div>
                            <div id="waterPrice"><?php echo $waterPrice ?></div>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between mt-2 text-black text-lg">
                            <div>Tổng</div>
                            <div id="totalPrice"><?php echo $waterPrice + $elecPrice + $servicesTotal ?></div>
                        </div>

                    </div>
                    <?php
                            }
                        }
                    ?>
                    <div class="flex gap-3 mt-4">
                        <a href="http://localhost/QuanLyKyTucXa/bills.php" class=" text-center border border-slate-800 p-3 w-full">Trở lại</a>
                        <button name="update" type="submit" class="text-white bg-slate-800 p-3 w-full">Cập nhật</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</body>

<script>
    const waterValue = document.querySelector("input[name='newWaterNumber']")
    const electricityValue = document.querySelector("input[name='newElectricityNumber']")
    const servicesTotal = document.querySelector("#servicesTotal")

    const waterPrice = document.querySelector('#waterPrice')
    const electricityPrice = document.querySelector('#electricityPrice')
    const totalPrice = document.querySelector('#totalPrice')
    
    const waterUnitPrice = document.querySelector('#waterUnitPrice')
    const electricityUnitPrice = document.querySelector('#electricityUnitPrice')


    const handleChange = () => {
        totalPrice.innerHTML = +waterPrice.innerHTML+ +electricityPrice.innerHTML + +servicesTotal.innerHTML
    }

    waterValue.addEventListener('input', (e) => {
        waterPrice.innerHTML = e.target.value*waterUnitPrice.innerHTML
        handleChange()
    })
    
    electricityValue.addEventListener('input', (e) => {
        electricityPrice.innerHTML = e.target.value*electricityUnitPrice.innerHTML
        handleChange()
    })

</script>
