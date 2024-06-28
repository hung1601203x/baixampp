<?php
    $con = mysqli_connect('localhost', 'root', '', 'quanLyKyTuc') or die('Lỗi kết nối');

    if (mysqli_connect_errno()) {
        die("Kết nối không thành công: " . mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {
        $selectedService = $_POST['service'];

        // Thực hiện câu lệnh INSERT cho bảng services
        $insertServiceQuery = "INSERT INTO services (name) VALUES ('$selectedService')";
        $result = mysqli_query($con, $insertServiceQuery);

        if ($result) {
            // Nếu INSERT thành công, có thể thực hiện các hành động khác hoặc chuyển hướng đến trang thành công
            header("Location: DSphong(sv).php");
            exit;
        } else {
            // Nếu có lỗi, hiển thị thông báo hoặc xử lý theo cách phù hợp với ứng dụng của bạn
            echo "Lỗi: " . mysqli_error($con);
        }
    }

    // Lấy dữ liệu từ bảng services
    $sql_services = "SELECT * FROM services";
    $result_services = mysqli_query($con, $sql_services);

    // Lấy dữ liệu từ bảng rooms
    $sql_rooms = "SELECT * FROM rooms";
    $result_rooms = mysqli_query($con, $sql_rooms);

    mysqli_close($con);
?>

<title>Đăng kí dịch vụ</title>
<body>
    <div class="flex">
        <?php include_once './sidebar(sv).php'; ?>
        <div class="flex-1 flex flex-col max-h-screen overflow-scroll">
            <div class="py-8 px-4 border-b flex justify-between">
                <div></div>
                <button class="p-2 px-4 rounded-full hover:bg-gray-100 transition">Chào mừng bạn quay trở lại 💙</button>
            </div>

            <div class="flex-1 p-4">
            <form method="POST" class="flex flex-col gap-4">
                    <h1 class="text-4xl font-semibold pb-5">Đăng kí dịch vụ</h1>
                    <div class="flex gap-4">
            <div class="flex-1 p-4">
            <label for="type" class="block">Tên dịch vụ</label>
                <div class="w-[600px] border p-3 focus:outline-none outline-none">
    <select id="service" name="service" class="outline-none focus:outline-none w-full">
        <?php
        while ($row = mysqli_fetch_assoc($result_services)) {
            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
        }
        ?>
    </select>
                </div>
    </div>
            
        <div class="flex-1 p-4">
            <label for="type" class="block">Tên phòng</label>
                <div class="w-[600px] border p-3 focus:outline-none outline-none">
    <select id="service" name="service" class="outline-none focus:outline-none w-full">
        <?php
        while ($row = mysqli_fetch_assoc($result_rooms)) {
            echo "<option value='" . str_replace(' ', '-', $row['name']) . "'>" . $row['name'] . "</option>";
        }
        ?>
    </select>
            </div>
            </div>

            <div class="flex gap-3 mt-4">
                        <a href="/DSphong(sv).php" class=" text-center border border-slate-800 p-3 w-full">Trở lại</a>
                        <button name="submit" type="submit" class="text-white bg-slate-800 p-3 w-full">Lưu</button>
                    </div>
    </div>
        </div>
</body>
</html>
