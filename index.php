
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
</head>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div>
        <div class="p-2" style="font-family: 'Sarabun', sans-serif;">
            <div class="row gx-4 gx-lg-5 align-items-center ">
                <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="image\350812065_133862573030297_6377887136345682373_n.jpg" alt="..." /></div>
                <div class="col-lg-5">
                    <h1 class="font-weight-light">บริษัท รถเช่าพร้อมคนขับ อยุธยา (Private Car Rent) จำกัด</h1>
                    <p>"เปิดประสบการณ์ใหม่กับบริการรถเช่าพร้อมคนขับอยุธยา ที่จะทำให้คุณเดินทางไปถึงจุดหมายด้วยความสะดวกสบายและความปลอดภัยที่ไม่เคยมีมาก่อน ร่วมกับ Private Car Rent และสัมผัสประสบการณ์ที่ดีที่สุดในการเดินทางของคุณ"</p>
                    <a class="btn btn-warning" href="car_list.php">รายการรถเช่า</a>
                </div>
            </div>
            <div class="card text-white bg-secondary my-5 py-4 text-center">
                <div class="card-body">
                    <p class="text-white m-0">👉 ไม่ต้องใช้บัตรเครดิต
                        👉 ลูกค้าขับเอง เราบริการส่งรถ
                        👉 ลูกค้าเช่าพร้อมคนขับ เราบริการรับถึงบ้าน
                        👉 ราคาถูก ประหยัดจริง
                        👉 จองง่าย สะดวกรวดเร็ว ตรงเวลา</p>
                </div>
            </div>
            <div class="row px-4 px-lg-5 mt-5">
                <?php
                require_once "database.php";

                $sql = "SELECT cars.*, images.image_name 
FROM cars
JOIN images ON cars.car_id = images.car_id
WHERE cars.status_car = 'Ready'
ORDER BY cars.car_id DESC
LIMIT 3;
";

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $car_id = $row['car_id'];
                        $car_brand = $row['car_brand'];
                        $car_model = $row['car_model'];
                        $price = $row["price"];
                        $image_name = $row["image_name"];

                ?>


                        <div class="col ">
                                <div class="card h-100 ">
                                    <!-- Product image-->
                                    <img class="card-img-top" src='image\<?php echo $image_name; ?>' alt="..." />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder"><?php echo $car_brand, $car_model; ?></h5>
                                            <!-- Product price-->
                                            <?php echo $price; ?> /ต่อวัน
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-warning mt-auto"  href="car_detail.php?car_id=<?php echo $car_id; ?>">ดูรายละเอียด</a></div>
                                    </div>
                                </div>
                            </div>
                <?php
                    }
                } else {
                    echo "No data found.";
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5">
                <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
            </div>
        </footer>



    </div>

</body>

</html>