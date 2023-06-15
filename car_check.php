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
                <h4 class="card-title">รายการเช่ารถ</h4>
                <p class="card-description">
                  รายการการบันทึกเช่ารถ
                </p>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">ลูกค้า</th>
                        <th scope="col">รถ</th>
                        <th scope="col">วันที่</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">เพิ่มเติม</th>
                      </tr>
                    </thead>
                    <tbody>
          <?php
          require_once "database.php";
          $sql = "SELECT bookings.*, car_rental.* 
                        FROM bookings
                        JOIN car_rental ON car_rental.bookings_id = bookings.id
                        ORDER BY car_rental.rental_id DESC";

          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
              $bookings_id = $row['bookings_id'];
              $car_id = $row['car_id'];
              $car_brand = $row['car_brand'];
              $car_model = $row['car_model'];
              $customer_name = $row["customer_name"];
              $status = $row["status"];
              $rental_date = $row["rental_date"];

              echo '<tr>';
              echo '<th scope="row">' . $i++ . '</th>';
              echo '<td>' . $customer_name . '</td>';
              echo '<td>' . $car_brand . ' ' . $car_model . '</td>';
              echo '<td>' . $rental_date . '</td>';
              echo '<td>';
              if ($status == 1) {
                echo '<span class="badge text-bg-warning ">รอการยืนยัน</span>';
              } elseif ($status == 2) {
                echo '<span class="badge text-bg-info ">รอรับรถ</span>';
              } elseif ($status == 3) {
                echo '<span class="badge text-bg-success">เช่าอยู่</span>';
              } else {
                echo '<span class="badge text-bg-dark">สิ้นสุดการเช่า</span>';
              }

              echo '</td>'; ?>
              <td>
                <div class="d-grid gap-2 d-md-flex">
                  <a class="btn btn-warning btn-sm " href="booking_detail.php?bookings_id=<?php echo $bookings_id; ?>">ดูรายละเอียด</a>
                  <form action="" method="POST">
                    <input type="hidden" name="bookings_id" value="<?php echo $row['bookings_id']; ?>">
                    <button class="btn btn-outline-warning" type="submit" name="delete_data" value="Submit">ลบ</button>
                  </form>
                </div>



              </td><?php
                    echo '</tr>';
                  }
                } else {
                  echo '<tr><td colspan="5">No data found.</td></tr>';
                }
                    ?>
          <?php
          if (isset($_POST['delete_data'])) {
            $bookings_id = $_POST['bookings_id'];

            // ลบข้อมูลในตาราง car_rental
            $sql = "DELETE FROM car_rental WHERE bookings_id = $bookings_id";
            if ($conn->query($sql) === TRUE) {
              echo "";
            } else {
              echo "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง car_rental: ";
            }

            // ลบข้อมูลในตาราง booking
            $sql = "DELETE FROM bookings WHERE id = $bookings_id";
            if ($conn->query($sql) === TRUE) {
              echo "<div class='alert alert-danger' role='alert'>
                                    ลบข้อมูลเรียบร้อย <a href='car_check.php'>รีเฟรชข้อมูลใหม่</a>
                                  </div>";
            } else {
              echo "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง booking: ";
            }
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