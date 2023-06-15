<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div style="font-family: 'Sarabun', sans-serif;">

        <!-- Header-->
        <header class=" py-3"  style="background-color: #6699cc  ;">
            <div class="container px-4 px-lg-5 ">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">รถเช่าพร้อมคนขับ อยุธยา</h1>
                    <p class="lead fw-normal text-white-50 mb-0">บริษัท รถเช่าพร้อมคนขับ อยุธยา (Private Car Rent) จำกัด</p>
                    <div class="d-grid gap-2 mt-2 col-6 mx-auto">
                        <form method="GET" action="">
                            <div class="form-group">                           
                                <input type="text" class="form-control" id="searchWord" name="search_word" placeholder="กรอกชื่อแบรนด์รถ รุ่นรถ ที่ต้องการค้นหา">
                                <button type="submit" class="btn  mt-2 d-grid btn-sm gap-2 col-6 mx-auto" style="background-color: #f7d2db;">ค้นหา</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-2">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                 
                    <?php
                    require_once "database.php";
                    if (isset($_GET['search_word'])) {
                        $searchWord = $_GET['search_word']; // รับค่าคำค้นหาแบรนด์รถ
                        $sql = "SELECT cars.*, images.image_name 
                        FROM cars
                        JOIN images ON cars.car_id = images.car_id
                                WHERE( cars.car_brand LIKE '%$searchWord%' or  cars.car_model LIKE '%$searchWord%') and cars.status_car = 'Ready' -- เพิ่มเงื่อนไขการค้นหาแบรนด์รถ
                                ORDER BY cars.car_id DESC";
                    } else {
                        $sql = "SELECT cars.*, images.image_name 
                    FROM cars
                    JOIN images ON cars.car_id = images.car_id
                    WHERE cars.status_car = 'Ready'
                    ORDER BY cars.car_id DESC;
                    ";
                    }


                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $car_id = $row['car_id'];
                            $car_brand = $row['car_brand'];
                            $car_model = $row['car_model'];
                            $price = $row["price"];
                            $image_name = $row["image_name"];
                    ?>



                            <div class="col mb-5">
                                <div class="card h-100">
                                    <!-- Product image-->
                                    <img class="card-img-top" src='image\<?php echo $image_name; ?>' alt="..." />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder"><?php echo $car_brand, $car_model; ?></h5>
                                            <!-- Product price-->
                                             <p>ราคา  <?php echo $price; ?> บาท/ต่อวัน</p>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-white  text-center "><a class="btn  mt-auto" style=" background-color: #003b6d; color: #ffffff;" href="car_detail.php?car_id=<?php echo $car_id; ?>">รายละเอียด</a></div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "ไม่พบข้อมูลที่คุณต้องการ";
                    }
                    mysqli_close($conn);
                    ?>
                </div>
            </div>

        </section>
       
    </div>
</body>

</html>