<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<?php include 'navbar.php'; ?>
<div class="container" style="font-family: 'Sarabun', sans-serif;">
    <?php
    // เชื่อมต่อกับฐานข้อมูล
    require_once "database.php";

    // ตรวจสอบว่ามีการส่งค่า bookings_id มาหรือไม่
    if (isset($_GET['bookings_id'])) {
        // รับค่า bookings_id จาก URL
        $bookings_id = $_GET['bookings_id'];

        // สร้างคำสั่ง SQL เพื่อเลือกข้อมูลรถตาม bookings_id
        $sql = "SELECT bookings.*, car_rental.*, images.*
        FROM car_rental
        JOIN  bookings ON car_rental.bookings_id = bookings.id
        JOIN images ON bookings.car_id = images.car_id
        WHERE car_rental.bookings_id =  $bookings_id
        ORDER BY car_rental.rental_id DESC";

        // ส่งคำสั่ง SQL ไปที่ฐานข้อมูล
        $result = mysqli_query($conn, $sql);

        // ตรวจสอบว่ามีข้อมูลรถที่ต้องการหรือไม่
        if (mysqli_num_rows($result) > 0) {
            // ดึงข้อมูลรถ
            $row = mysqli_fetch_assoc($result);
    ?><div class="card">
                <div class="card-body">
                    <h3 class="card-subtitle"><?php echo $row['customer_name'] ?></h3>
                    <h6 class="card-subtitle"><?php echo $row['car_brand'] . ' ' . $row['car_model']; ?></h6>


                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-6">
                            <div class="white-box text-center">
                                <img src="image/<?php echo $row['image_name']; ?>" class="img-responsive" width="430" height="400">
                            </div>

                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-6">
                            <h4 class="box-title mt-5">รายละเอียดการจอง</h4>

                            <p><?php echo $row['car_brand'] . ' ' . $row['car_model'] . '  <br>สถานที่รับรถ:' .  $row['pickup_location'] . ' -> ' .  $row['destination_province'] . '  <br>เดินทางวันที่ ' .  $row['travel_date'] . ' -> ' .  $row['return_date'] . ' <br> เป็นจำนวน ' .  $row['num_days'] . ' วัน'; ?></p>

                            <ul class="list-unstyled">
                                <li><i class="fa fa-check text-success"></i>ลูกค้าทำการจองรถเข้ามาในระบบแล้วครับ กรุณาช่วยติดต่อกลับเพื่อดำเนินการต่อไปครับ </li>
                                <li><i class="fa fa-check text-success"></i>โปรดตรวจสอบรายละเอียดการจองรถที่เราได้รับจากลูกค้าในระบบของเรา</li>
                                <li><i class="fa fa-check text-success"></i>จากนั้นทำการยืนยันการจอง</li>
                            </ul>
                            <h2 class="mt-5">
                                โทรติดต่อ<small class="text-success"><?php echo $row['phone_number'] ?></small>
                            </h2>
                            <button class="btn btn-primary btn-rounded">Buy Now</button>
                        </div>

                        <h3 class="box-title mt-5">บันทึกสถานะ</h3>
                        <div class="card p-3 " style="box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;">

                            <form id="myForm" method="post" action="">
                                <div class="mb-3">
                                    <select class="form-select" aria-label="Default select example" name="status">
                                        <option selected>เลือกสถานะ</option>
                                        <option value="1">รอยืนยัน</option>
                                        <option value="2">รอรับรถ</option>
                                        <option value="3">เช่าอยู่</option>
                                        <option value="4">สิ้นสุดการเช่า</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">เพิ่มบันทึก :</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="note"></textarea>
                                </div>
                                <input type="hidden" name="bookingID" value="<?php echo $row['bookings_id'] ?>">
                                <input type="hidden" name="carID" value="<?php echo $row['car_id'] ?>">
                                <input type="hidden" name="customerName" value="<?php echo $row['customer_name'] ?>">
                                <div class="d-grid gap-2 col-6 mx-auto">

                                    <button class="btn btn-primary" type="submit" name="submit" value="Submit">บันทึกสถานะ</button>
                                </div>

                            </form>
                        </div>
                        <?php
                        if (isset($_POST['submit'])) {

                            $bookingID = $_POST['bookingID'];
                            $note = $_POST['note'];
                            $status = $_POST['status'];
                            $carID = $_POST['carID'];
                            $customerName = $_POST['customerName'];
                            $currentDateTime = date("Y-m-d H:i:s");

                            // ตรวจสอบความถูกต้องของข้อมูล
                            if ($note != "" && $status != "เลือกสถานะ") {
                                // เพิ่มข้อมูลใหม่
                                $carRentalSql = "INSERT INTO car_rental (bookings_id, customer_name, car_id, status, rental_date,note) VALUES (?, ?, ?, ?, ?,?)";
                                $carRentalStmt = mysqli_stmt_init($conn);
                                $prepareCarRentalStmt = mysqli_stmt_prepare($carRentalStmt, $carRentalSql);

                                if ($prepareCarRentalStmt) {
                                    mysqli_stmt_bind_param($carRentalStmt, "ississ", $bookingID, $customerName, $carID, $status, $currentDateTime, $note);
                                    mysqli_stmt_execute($carRentalStmt);
                                    echo "<div class='alert alert-success'>เพิ่มข้อมูลสำเร็จ </div>";
                                } else {
                                    echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . mysqli_error($conn);
                                }
                            } else {
                                echo "กรุณากรอกข้อมูลให้ถูกต้อง";
                            }
                        }
                        ?>

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3 class="box-title mt-5">การตรวจสอบ</h3>
                        <div class="table-responsive">
                            <table class="table table-striped table-product">
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM car_rental WHERE bookings_id   = $bookings_id";

                                    // ส่งคำสั่ง SQL ไปที่ฐานข้อมูล
                                    $result = mysqli_query($conn, $sql);

                                    // ตรวจสอบว่ามีข้อมูลหรือไม่
                                    if (mysqli_num_rows($result) > 0) {
                                        // วนลูปแสดงข้อมูล
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td width="390"><?php echo $row['rental_date'] ?></td>
                                                <td>
                                                    <?php
                                                    $status = $row['status'];
                                                    $note = $row['note'];
                                                    if ($status == "1") {
                                                        echo "<p class='text-success '>รอยืนยัน</p>";
                                                    } elseif ($status == "2") {
                                                        echo "<p class='text-success '>รอรับรถ</p>";
                                                    } elseif ($status == "3") {
                                                        echo "<p class='text-success '>เช่าอยู่</p>";
                                                    } elseif ($status == "4") {
                                                        echo "<p class='text-success '>สิ้นสุดการเช่า</p>";
                                                    }
                                                    ?><br>
                                                    <?php echo $note ?>
                                                </td>
                                            </tr>
                                    <?php

                                        }
                                    } else {
                                        echo "ไม่พบข้อมูล";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>

    <?php
        } else {
            echo "ไม่พบข้อมูลรถ";
        }

        // คืนค่าทรัพยากรที่ใช้ไป
        mysqli_free_result($result);
    } else {
        echo "ไม่พบรหัสรถ";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($conn);
    ?>



</div>
</body>

</html>