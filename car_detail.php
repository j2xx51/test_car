<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</head>


<body>
    <?php include 'navbar.php'; ?>
    <div class="container" style="font-family: 'Sarabun', sans-serif;">

        <?php
        // เชื่อมต่อกับฐานข้อมูล
        require_once "database.php";

        // ตรวจสอบว่ามีการส่งค่า car_id มาหรือไม่
        if (isset($_GET['car_id'])) {
            // รับค่า car_id จาก URL
            $car_id = $_GET['car_id'];

            // สร้างคำสั่ง SQL เพื่อเลือกข้อมูลรถตาม car_id
            $sql = "SELECT cars.*, images.image_name 
                        FROM cars
                        JOIN images ON cars.car_id = images.car_id
                        WHERE cars.car_id = $car_id";

            // ส่งคำสั่ง SQL ไปที่ฐานข้อมูล
            $result = mysqli_query($conn, $sql);

            // ตรวจสอบว่ามีข้อมูลรถที่ต้องการหรือไม่
            if (mysqli_num_rows($result) > 0) {
                // ดึงข้อมูลรถ
                $row = mysqli_fetch_assoc($result);
        ?>


                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $row['car_brand']; ?></h3>
                            <h6 class="card-subtitle"><?php echo $row['car_model']; ?></h6>
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-6 mt-2">
                                    <div class="card white-box text-center">
                                        <img src="image/<?php echo $row['image_name']; ?>" width="430" height="400" class="card-img-top img-fluid" alt="Car Image">
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-6">
                                    <h4 class="mt-5">รายละเอียดรถ</h4>
                                    <p><?php echo $row['car_description'] ?></p>
                                    <h2 class="mt-5">
                                        <small class="text-success"><?php echo $row['price'] ?></small> / ต่อวัน
                                    </h2>
                                    <a class="btn "  style="background-color: #6699cc;" href="booking1.php?car_id=<?php echo $car_id; ?>&bookings_type=1" role="button">เช่าขับเอง</a>

                                    <a class="btn "   style="background-color: #003b6d; color: #ffffff;" href="booking2.php?car_id=<?php echo $car_id; ?>&bookings_type=2" role="button">เช่าพร้อมคนขับ</a>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h3 class="box-title mt-5">ข้อมูลรถ</h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-product">
                                            <tbody>
                                                <tr>
                                                    <td width="390">แบรนด์</td>
                                                    <td><?php echo $row['car_brand'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>รุ่น</td>
                                                    <td><?php echo $row['car_model'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>ขนาดเครื่องยนต์</td>
                                                    <td><?php echo $row['engine_size'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>ปี</td>
                                                    <td><?php echo $row['manufacturing_year'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>เชื้อเพลิง</td>
                                                    <td><?php echo $row['fuel_type'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>สี</td>
                                                    <td><?php echo $row['color'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>จำนวนประตู</td>
                                                    <td><?php echo $row['door_count'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>จำนวนที่นั้ง</td>
                                                    <td><?php echo $row['seating_capacity'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>ระบบเกียร์</td>
                                                    <td><?php echo $row['transmission'] ?></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <?php
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