<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navs and Tabs Example</title>
  <!-- Link to Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun&display=swap">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <script src="js/scripts.js"></script>
</head>

<body>
  <?php include 'navbar.php'; ?>
  <div class="container py-2">
    <div class="page-content page-container" id="page-content">
      <div class="padding">
        <div class="row container d-flex justify-content-center">

          <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">ยืนยันการเช่า</h4>
                <p class="card-description">
                  รายการจองมาใหม่ รอการยืนยัน
                </p>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">ลูกค้า</th>
                        <th scope="col">รถ</th>
                        <th scope="col">รปแบบการจอง</th>
                        <th scope="col">สถานะ</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      require_once "database.php";

                      $sql = "SELECT * FROM `bookings` WHERE status_rental = '';";

                      $result = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($result) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                          $car_id = $row['car_id'];
                          $car_brand = $row['car_brand'];
                          $car_model = $row['car_model'];
                          $customer_name = $row["customer_name"];
                          $travel_date = $row['travel_date'];
                          $return_date = $row["return_date"];
                          $status_rental = $row["status_rental"];
                          $b_status = $row["b_status"];
                          
                          echo '<tr>';
                          echo '<th scope="row">' . $i++ . '</th>';
                          echo '<td>' . $customer_name . '</td>';
                          echo '<td>' . $car_brand . ' ' . $car_model . '</td>';
                          echo '<td>' . $b_status . '</td>';
                          echo '<td>';
                          if (empty($status_rental)) {
                            echo '<form method="POST" action="">';
                            echo '<input type="hidden" name="bookingID" value="' . $row['id'] . '">';
                            echo '<input type="hidden" name="customerName" value="' . $row['customer_name'] . '">';
                            echo '<input type="hidden" name="carID" value="' . $row['car_id'] . '">';
                            echo '<button type="submit" class="btn btn-success" name="confirm_rental">ยืนยันการจอง</button>';
                            echo '</form>';
                          } else {
                            echo '<span class="badge text-bg-warning ">รอการยืนยัน</span>';
                          }
                          echo '</td>';
                          echo '</tr>';
                        }

                        if (isset($_POST['confirm_rental'])) {
                          $bookingID = $_POST['bookingID'];
                          $status = 2;
                          $carID = $_POST['carID'];
                          $customerName = $_POST['customerName'];
                          $currentDateTime = date("Y-m-d H:i:s");

                          // เพิ่มข้อมูลใหม่ในตาราง car_rental
                          $carRentalSql = "INSERT INTO car_rental (bookings_id, customer_name, car_id, status, rental_date) VALUES (?, ?, ?, ?, ?)";
                          $carRentalStmt = mysqli_stmt_init($conn);
                          $prepareCarRentalStmt = mysqli_stmt_prepare($carRentalStmt, $carRentalSql);

                          if ($prepareCarRentalStmt) {
                            mysqli_stmt_bind_param($carRentalStmt, "issis", $bookingID, $customerName, $carID, $status, $currentDateTime);
                            mysqli_stmt_execute($carRentalStmt);
                            echo "<div class='alert alert-success'>เพิ่มข้อมูลสำเร็จ <a href='car_check2.php'>รีเฟรชข้อมูลใหม่</a></div>";
                          } else {
                            echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . mysqli_error($conn);
                          }

                          // อัปเดตค่า status_rental ในตาราง bookings
                          $updateBookingSql = "UPDATE bookings SET status_rental = 1 WHERE id = ?";
                          $updateBookingStmt = mysqli_stmt_init($conn);
                          $prepareUpdateBookingStmt = mysqli_stmt_prepare($updateBookingStmt, $updateBookingSql);

                          if ($prepareUpdateBookingStmt) {
                            mysqli_stmt_bind_param($updateBookingStmt, "i", $bookingID);
                            mysqli_stmt_execute($updateBookingStmt);
                            echo "";
                          } else {
                            echo "เกิดข้อผิดพลาดในการอัปเดตสถานะการจอง: " . mysqli_error($conn);
                          }
                        }
                      } else {
                        echo '<tr><td colspan="5">No data found.</td></tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>

</html>