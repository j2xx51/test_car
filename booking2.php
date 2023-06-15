<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</head>

<?php include 'navbar.php'; ?>
<div class="container" style="font-family: 'Sarabun', sans-serif;">
    <?php

    if (isset($_GET['car_id'])) {
        $car_id = $_GET['car_id'];
    }

    if (isset($_POST['submit'])) {
        $customerName = $_POST['customer_name'];
        $phoneNumber = $_POST['phone_number'];
        $lineId = $_POST['line_id'];
        $travelDate = $_POST['travel_date'];
        $travelTime = $_POST['travel_date_time'];
        $pickupLocation = $_POST['pickup_location'];
        $destinationProvince = $_POST['destination_province'];
        $carID = $_POST['car_id'];
        $passengerCount = $_POST['passenger_count'];
        $numDays = $_POST['num_days'];

        $errors = array();

        if (empty($customerName) || empty($phoneNumber) || empty($travelDate) || empty($travelTime) || empty($pickupLocation) || empty($destinationProvince) || empty($passengerCount)  || empty($passengerCount)) {
            $errors[] = "กรุณากรอกข้อมูลให้ครบ";
        }
        $currentDate = date("Y-m-d"); // วันที่ปัจจุบัน
        if (strtotime($travelDate) < strtotime($currentDate)) {
            $errors[] = "กรุณากรอกวันที่ให้ถูกต้อง";
        }




        // เรียกดูค่า car_brand, car_model จากตาราง cars โดยใช้ค่า car_id
        require_once "database.php";
        $sql = "SELECT car_brand, car_model, price FROM cars WHERE car_id = ?";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "s", $carID);
            mysqli_stmt_execute($stmt);

            // ตรวจสอบจำนวนแถวที่ผ่านการเลือกข้อมูลมาเพียงพอหรือไม่
            mysqli_stmt_store_result($stmt);
            $numRows = mysqli_stmt_num_rows($stmt);

            if ($numRows > 0) {
                mysqli_stmt_bind_result($stmt, $carBrand, $carModel, $price);
                mysqli_stmt_fetch($stmt);
            } else {
                $errors[] = "ไม่พบข้อมูลรถรหัส " . $carID;
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        if (empty($errors)) {
            addBooking($customerName, $phoneNumber, $travelDate, $travelTime, $pickupLocation, $destinationProvince, $carID, $passengerCount, $carBrand, $carModel, $numDays, $price, $lineId);
        } else {
            // Display error messages
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }
        }
    }


    function addBooking($customerName, $phoneNumber, $travelDate, $travelTime, $pickupLocation, $destinationProvince, $carID, $passengerCount, $carBrand, $carModel, $numDays, $price, $lineId)
    {
        global $conn;
        $price_c =  ($numDays * $price);
        $status_b = 'เช่าพร้อมคนขับ';


        // ฟอร์ม SQL สำหรับเพิ่มข้อมูลในตาราง bookings
        $sql = "INSERT INTO bookings (customer_name, phone_number, travel_Date, travel_time, pickup_location, destination_province, car_id, passenger_count, car_brand, car_model,num_days,line_id,b_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";

        // ส่งคำสั่ง SQL ไปที่ฐานข้อมูล
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "sssssssssssss", $customerName, $phoneNumber, $travelDate, $travelTime, $pickupLocation, $destinationProvince, $carID, $passengerCount, $carBrand, $carModel, $numDays, $lineId, $status_b);
            mysqli_stmt_execute($stmt);
            $bookingID = mysqli_insert_id($conn);
            $status = 1;
            $currentDateTime = date("Y-m-d H:i:s");

            // เพิ่มข้อมูลลงในตาราง car_rental
            $carRentalSql = "INSERT INTO car_rental (bookings_id, customer_name, car_id, status, rental_date) VALUES (?, ?, ?, ?, ?)";
            $carRentalStmt = mysqli_stmt_init($conn);
            $prepareCarRentalStmt = mysqli_stmt_prepare($carRentalStmt, $carRentalSql);

            if ($prepareCarRentalStmt) {
                mysqli_stmt_bind_param($carRentalStmt, "issis", $bookingID, $customerName, $carID, $status, $currentDateTime);
                mysqli_stmt_execute($carRentalStmt);
            } else {
                echo "การเพิ่มข้อมูลในตาราง car_rental ผิดพลาด: " . mysqli_error($conn);
            }
            echo "<div class='alert alert-success'>ระบบทำการบันทึกการจองเรียบร้อบเเล้ว กรุณารอการติดต่อกลับ <a href='index.php'>หน้าหลัก</a></div>";
            echo "
            <div class='modal fade' id='myModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'> บริษัท รถเช่าพร้อมคนขับอยุธยา (Private Car Rent) จำกัด</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                        <div class='card'>
  <div class='card-body'>
  <h5 class='card-title'>คุณลูกค้า : $customerName </h5>
  <p class='card-text'>ทำการจองรถ $carBrand $carModel <br> สถานที่นัดรับ: $pickupLocation เดินทางวันที่ $travelDate  $travelTime <br>เพื่อเดินทางไปยัง $destinationProvince เป็นจำนวน $numDays วัน </p>
  <p class='card-text text-danger'>**ราคารอยืนยันจากบริษัท**</p>
  </div>
</div>
                       
                        <div class='row'>
                        <p>ติดต่อเรา</p>
          <div class='col-4'>
          <img width=100% height=auto src='image/lineID.png' alt='Car Image'>

          </div>
          <div class='col-6'>
          <p class='card-text'>Tel : 084-7753409 </p>
          <p class='card-text'>LINE ID : amnat-04 </p>
          <p class='card-text'>Facebook : รถเช่าพร้อมคนขับ-อยุธยา Private Car Rent </p>
          <p class='card-text'>Email : privatecarrent.ayutthaya@gmail.com  </p>
          </div>
        </div>
       
                    </div> 
                    <p>ขอบคุณที่ทำการจองรถกับเรา</p>
                    <p>เราจะติดต่อกลับโดยเร็วที่สุดเพื่อยืนยันการจองและแจ้งรายละเอียดเพิ่มเติม</p>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal' href='index.php'>ปิด</button>
                    </div>
                    </div>
                </div>
            </div>
            <script>
                var myModal = new bootstrap.Modal(document.getElementById('myModal'));
                myModal.show();
            </script>
            ";
        } else {
            echo "การเพิ่มข้อมูลการจองรถผิดพลาด: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
    ?>

    <h1 class="font-weight-light">บริษัท รถเช่าพร้อมคนขับ อยุธยา (Private Car Rent) จำกัด</h1>
    <p>"เปิดประสบการณ์ใหม่กับบริการรถเช่าพร้อมคนขับอยุธยา ที่จะทำให้คุณเดินทางไปถึงจุดหมายด้วยความสะดวกสบายและความปลอดภัยที่ไม่เคยมีมาก่อน ร่วมกับ Private Car Rent และสัมผัสประสบการณ์ที่ดีที่สุดในการเดินทางของคุณ"</p>
    <h4 class="font-weight-light">บริการ: เช่าพร้อมคนขับ <span class="text-danger">**ราคารอยืนยันจากบริษัท**</span></h4>
    <form action="" method="POST" enctype="multipart/form-data" class="container mt-4 " style="border-radius: 6px; background-color: #bdbdbd;">
        <div class="mb-3">
            <label class="form-label" for="customer_name">ชื่อ-นามสกุล:</label>
            <input type="text" name="customer_name" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="phone_number">เบอร์โทรศัพท์:</label>
            <input type="tel" name="phone_number" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="line_id">LINE id (ถ้ามี):</label>
            <input type="text" name="line_id" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="destination_province">จังหวัดที่ต้องการเดินทาง:</label>
            <input type="text" name="destination_province" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="pickup_location">จุดนัดรับ:</label>
            <input type="text" name="pickup_location" class="form-control">
        </div>

        <div class="col mb-3">
            <label class="form-label" for="travel_date">วันที่เดินทาง:</label>
            <input type="date" name="travel_date" class="form-control">
        </div>
        <div class="col mb-3">
            <label class="form-label" for="travel_date_time">เวลานัดรับ:</label>
            <input type="time" name="travel_date_time" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label" for="num_days">จำนวนวันเช่า:</label>
            <input type="number" name="num_days" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="passenger_count">จำนวนคน:</label>
            <input type="number" name="passenger_count" class="form-control">
        </div>
        <div class="">
            <label class="form-label" for="car_id"></label>
            <input type="hidden" name="car_id" value="<?php echo isset($car_id) ? $car_id : ''; ?>">
        </div>
        <div>
            <button type="submit" class="btn  mb-2" style="background-color: #003b6d; color: #ffffff;" name="submit">บันทึก</button>
        </div>
    </form>


</html>