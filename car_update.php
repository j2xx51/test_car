<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun&display=swap">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container" style="font-family: 'Sarabun', sans-serif;">
        <?php
        // print_r($_POST);
        if (isset($_POST["submit"])) {
            $car_brand = $_POST["car_brand"];
            $car_model = $_POST["car_model"];
            $car_description = $_POST["car_description"];
            $engine_size = $_POST["engine_size"];
            $manufacturing_year = $_POST["manufacturing_year"];
            $fuel_type = $_POST["fuel_type"];
            $color = $_POST["color"];
            $door_count = $_POST["door_count"];
            $seating_capacity = $_POST["seating_capacity"];
            $transmission = $_POST["transmission"];
            $price = $_POST["price"];
            $car_type = $_POST["car_type"];
            $status_car = 'Ready';
            $errors = array();

            if (empty($car_brand) || empty($car_model) || empty($car_description)) {
                array_push($errors, "กรุณากรอกข้อมูลให้ครบ");
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'> $error</div>";
                }
            } else {
                require_once "database.php";

                // เรียกข้อมูลเดิมจากฐานข้อมูล
                $car_id = $_POST["car_id"]; // ค่า car_id ที่ถูกส่งมาในฟอร์ม
                $select_sql = "SELECT * FROM cars WHERE car_id = ?";
                $select_stmt = mysqli_prepare($conn, $select_sql);
                mysqli_stmt_bind_param($select_stmt, "i", $car_id);
                mysqli_stmt_execute($select_stmt);
                $result = mysqli_stmt_get_result($select_stmt);
                $row = mysqli_fetch_assoc($result);

                $sql = "UPDATE cars SET car_brand=?, car_model=?, car_description=?, engine_size=?, manufacturing_year=?, fuel_type=?, color=?, door_count=?, seating_capacity=?, transmission=?, price=?, car_type=?, status_car=? WHERE car_id=?";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "ssssisssissssi", $car_brand, $car_model, $car_description, $engine_size, $manufacturing_year, $fuel_type, $color, $door_count, $seating_capacity, $transmission, $price, $car_type, $status_car, $car_id);
                    mysqli_stmt_execute($stmt);

                    echo "<div class='alert alert-success'>อัปเดตเรียบร้อย </div>";

                    if (isset($_FILES["car_image"]) && $_FILES["car_image"]["error"] === UPLOAD_ERR_OK) {
                        $image = $_FILES["car_image"];
                        $image_name = $image["name"];
                        $image_tmp = $image["tmp_name"];

                        $allowed_extensions = array("jpg", "jpeg", "png");
                        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                        if (!in_array($file_extension, $allowed_extensions)) {
                            echo "<div class='alert alert-danger'>รูปแบบไฟล์ไม่ถูกต้อง</div>";
                        } else {
                            $image_name = uniqid() . "_" . $image_name;
                            $image_path = "C:/xampp/htdocs/test/image/" . $image_name;

                            if (move_uploaded_file($image_tmp, $image_path)) {
                                // ทำการอัปเดตชื่อและพาธของรูปภาพในฐานข้อมูล
                                $sql_update_image = "UPDATE images SET image_name = ?, image_path = ? WHERE car_id = ?";
                                $stmt_update_image = mysqli_prepare($conn, $sql_update_image);
                                mysqli_stmt_bind_param($stmt_update_image, "ssi", $image_name, $image_path, $car_id);
                                mysqli_stmt_execute($stmt_update_image);
                            } else {
                                echo "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการอัปโหลดไฟล์</div>";
                            }
                        }
                    }
                } else {
                    die("Sorry we failed to connect: " . mysqli_stmt_error($stmt));
                }
            }
        }
        ?>


        <?php
        require_once "database.php";

        // ตรวจสอบว่ามีการส่งค่า car_id มาหรือไม่
        if (isset($_GET["car_id"])) {
            $car_id = $_GET["car_id"];

            // เรียกข้อมูลรถจากฐานข้อมูล
            $sql = "SELECT * FROM cars
            JOIN images ON cars.car_id = images.car_id
            WHERE cars.car_id = ?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $car_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            // ตรวจสอบว่าพบข้อมูลรถหรือไม่
            if ($row) {
                // แสดงฟอร์มแก้ไข
        ?>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="car_id" value="<?php echo $row['car_id']; ?>">

                    <div class="mb-3">
                        <label for="car_brand" class="form-label">แบรนด์รถ:</label>
                        <input type="text" name="car_brand" class="form-control" value="<?php echo $row['car_brand']; ?>">
                    </div>


                    <div class="mb-3">
                        <label for="car_model" class="form-label">รุ่นรถยนต์:</label>
                        <input type="text" name="car_model" class="form-control" value="<?php echo $row['car_model']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">ราคาเช่า:</label>
                        <input type="number" name="price" class="form-control" value="<?php echo $row['price']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="car_description" class="form-label">ข้อมูลรถ:</label>
                        <textarea name="car_description" rows="4" cols="50" class="form-control"><?php echo $row['car_description']; ?></textarea>
                    </div>


                    <div class="mb-3">
                        <label for="engine_size" class="form-label">ขนาดเครื่องยนต์:</label>
                        <input type="text" name="engine_size" class="form-control" value="<?php echo $row['engine_size']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="manufacturing_year" class="form-label">ปีผลิต:</label>
                        <input type="number" name="manufacturing_year" class="form-control " value="<?php echo $row['manufacturing_year']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="fuel_type" class="form-label">ชนิดเชื้อเพลิง:</label>
                        <input type="text" name="fuel_type" class="form-control" value="<?php echo $row['fuel_type']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">สีของรถ:</label>
                        <input type="text" name="color" class="form-control" value="<?php echo $row['color']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="door_count" class="form-label">จำนวนประตู:</label>
                        <input type="number" name="door_count" class="form-control" value="<?php echo $row['door_count']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="seating_capacity" class="form-label">จำนวนที่นั้ง:</label>
                        <input type="number" name="seating_capacity" class="form-control" value="<?php echo $row['seating_capacity']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="transmission" class="form-label">ระบบรถ:</label>
                        <input type="text" name="transmission" class="form-control" value="<?php echo $row['transmission']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="car_type">ประเภทรถยนต์:</label>
                        <select class="form-select" name="car_type" id="car_type" value="<?php echo $row['car_type']; ?>">
                            <option value="sedan">รถยนต์ 4 ที่นั่ง (Sedan)</option>
                            <option value="suv">รถอเนกประสงค์ 7 ที่นั่ง (SUV)</option>
                            <option value="van">รถตู้ 12 ที่นั่ง (Van)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="file" id="input" name="car_image" onchange="previewImage(event)">
                        <img id="img" alt="Preview Image" style="display: none;">
                    </div>

                    <button type="submit" class="btn" style="background-color: #6699cc;" name="submit">บันทึก</button>
                </form>

        <?php
            } else {
                echo "<div class='alert alert-danger'>ไม่พบข้อมูลรถ</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>ไม่ระบุรหัสรถ</div>";
        }
        ?>

    </div>
    <script>
        function previewImage(event) {
            var img = document.getElementById('img');
            var input = document.getElementById('input');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    img.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
                img.style.display = 'block';
            }
        }
    </script>

</body>

</html>