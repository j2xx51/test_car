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
    <div class="tab-content" id="myTabContent">

    <div class="page-content page-container" id="page-content">
      <div class="padding">
        <div class="row container d-flex justify-content-center">

          <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Basic Table</h4>
                <p class="card-description">
                  Basic table with card
                </p>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">รถ</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">เปิด/ปิด</th>
                        <th scope="col">จัดการ</th>
                      </tr>
                    </thead>
                    <tbody>
            <?php
            require_once "database.php";
            $sql = "SELECT cars.*, images.image_name 
            FROM cars
            JOIN images ON cars.car_id = images.car_id
            ORDER BY cars.car_id DESC
            ";

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
              $i = 1;
              while ($row = mysqli_fetch_assoc($result)) {
                $car_id = $row['car_id'];
                $car_brand = $row['car_brand'];
                $car_model = $row['car_model'];
                $status_car = $row['status_car'];


                echo '<tr>';
                echo '<th scope="row">' . $i++ . '</th>';
                echo '<td>' . $car_brand . ' ' . $car_model . '</td>';
                echo '<td>' . $status_car .  '</td>';
                echo '<td>
                            <form method="POST" action="">
                                <input type="hidden" name="car_id" value="' . $row['car_id'] . '">
                                <input type="hidden" name="status_car" value="' . $row['status_car'] . '">';
                if ($status_car == 'Ready') {
                  echo '<button type="submit" class="btn btn-warning" name="complete_status">ปิดจอง</button>';
                } else {
                  echo '<button type="submit" class="btn btn-outline-warning" name="complete_status">เปิดจอง</button>';
                }
                echo '</form>

                        </td>';
                echo '<td>
                <div class="d-grid gap-2 d-md-flex">
                        <a class="btn btn-sm btn-warning me-md-2" href="car_update.php?car_id=' . $row['car_id'] . '">แก้ไข</a>
                        <form action="" method="POST">
                          <input type="hidden" name="car_id" value="' . $row['car_id'] . '">
                          <button class="btn btn-sm btn-warning" type="submit" name="delete_car" value="Submit">ลบ</button>
                        </form>
                        </div>
                      </td>';



                echo '</tr>';
              }
              if (isset($_POST['delete_car'])) {
                $car_id = $_POST['car_id'];

                // ลบข้อมูลในตาราง car_rental
                $sql_car_rental = "DELETE FROM car_rental WHERE car_id = ?";
                $stmt_car_rental = $conn->prepare($sql_car_rental);
                $stmt_car_rental->bind_param("i", $car_id);
                if ($stmt_car_rental->execute()) {
                  echo "";
                } else {
                  echo "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง car_rental: " . $stmt_car_rental->error;
                }

                // ลบข้อมูลในตาราง bookings
                $sql_bookings = "DELETE FROM bookings WHERE car_id = ?";
                $stmt_bookings = $conn->prepare($sql_bookings);
                $stmt_bookings->bind_param("i", $car_id);
                if ($stmt_bookings->execute()) {
                  echo "";
                } else {
                  echo "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง bookings: " . $stmt_bookings->error;
                }

                // ลบข้อมูลในตาราง images
                $sql_images = "DELETE FROM images WHERE car_id = ?";
                $stmt_images = $conn->prepare($sql_images);
                $stmt_images->bind_param("i", $car_id);
                if ($stmt_images->execute()) {
                  echo "";
                } else {
                  echo "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง images: " . $stmt_images->error;
                }

                // ลบข้อมูลในตาราง cars
                $sql_cars = "DELETE FROM cars WHERE car_id = ?";
                $stmt_cars = $conn->prepare($sql_cars);
                $stmt_cars->bind_param("i", $car_id);
                if ($stmt_cars->execute()) {
                  echo "";
                } else {
                  echo "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง cars: " . $stmt_cars->error;
                }
                echo "<div class='alert alert-danger' role='alert'>ลบทั้งหมดเรียบร้อย <a href='car_check3.php'>รีเฟรชข้อมูลใหม่</a></div>";
              }



              if (isset($_POST["complete_status"])) {
                $carID = $_POST["car_id"];
                $status = $_POST["status_car"];

                if ($status == 'Ready') {
                  $sqlUpdate = "UPDATE cars SET status_car = 'Not Ready' WHERE car_id = $carID";
                } elseif ($status == 'Not Ready') {
                  $sqlUpdate = "UPDATE cars SET status_car = 'Ready' WHERE car_id = $carID";
                }

                // ดำเนินการอัปเดต
                if (mysqli_query($conn, $sqlUpdate)) {
                  echo '<div class="alert alert-success">อัปเดตสถานะเรียบร้อยแล้ว<a href="car_check3.php"> รีเฟรชข้อมูลใหม่</a></div>';
                } else {
                  echo '<div class="alert alert-danger">เกิดข้อผิดพลาดในการอัปเดตสถานะ<a href="car_check3.php"> รีเฟรชข้อมูลใหม่</a></div>';
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