

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div style="font-family: 'Sarabun', sans-serif;">
        <div class="container p-2">
            <div class="d-grid gap-2 col-6 mx-auto">
                <form method="GET" action="">
                    <div class="form-group">
                        <label for="searchWord">ค้นหารายการเช่ารถ:</label>
                        <input type="text" class="form-control" id="searchWord" name="search_word" placeholder="กรอกชื่อแบรนด์รถ รุ่นรถ ชื่อลูกค้า ที่ต้องการค้นหา">
                        <button type="submit" class="btn btn-primary mt-2 d-grid btn-sm gap-2 col-6 mx-auto">ค้นหา</button>
                    </div>
                </form>
            </div>
            <table class="table table-bordered border-primary text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ลูกค้า</th>
                        <th scope="col">เบอรโทร</th>
                        <th scope="col">การเช่า</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">การเดินทาง</th>
                        <th scope="col">เพิ่มเติม</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once "database.php";
                    if (isset($_GET['search_word'])) {
                        $searchWord = $_GET['search_word']; // รับค่าคำค้นหาแบรนด์รถ
                        $sql = "SELECT bookings.*, car_rental.* 
                                FROM bookings
                                JOIN car_rental ON car_rental.bookings_id = bookings.id
                                JOIN cars ON cars.car_id = bookings.car_id
                                WHERE cars.car_brand LIKE '%$searchWord%' or bookings.customer_name LIKE '%$searchWord%' or  cars.car_model LIKE '%$searchWord%'  -- เพิ่มเงื่อนไขการค้นหาแบรนด์รถ
                                ORDER BY cars.car_id DESC";
                    } else {
                        $sql = "SELECT bookings.*, car_rental.* 
                                FROM bookings
                                JOIN car_rental ON car_rental.bookings_id = bookings.id
                                JOIN cars ON cars.car_id = bookings.car_id
                                ORDER BY cars.car_id DESC";
                    }
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $bookings_id = $row['bookings_id'];
                            $car_id = $row['car_id'];
                            $car_brand = $row['car_brand'];
                            $car_model = $row['car_model'];
                            $customer_name = $row["customer_name"];
                            $travel_date = $row['travel_date'];
                            $return_date = $row["return_date"];
                            $status = $row["status"];
                            $rental_date = $row["rental_date"];
                            $pickup_location  = $row["pickup_location"];
                            $destination_province  = $row["destination_province"];
                            $phone_number  = $row["phone_number"];


                            echo '<tr>';
                            echo '<th scope="row">' . $i++ . '</th>';
                            echo '<td>' . $customer_name . '</td>';
                            echo '<td>' . $phone_number . '</td>';
                            echo '<td>' . $car_brand . ' ' . $car_model . '</td>';

                            echo '<td>';
                            if ($status == 1) {
                                echo 'รอการยืนยัน';
                            } elseif ($status == 2) {
                                echo 'รอรับรถ';
                            } elseif ($status == 3) {
                                echo 'เช่าอยู่';
                            } else {
                                echo 'สิ้นสุดการเช่า';
                            }

                            echo ' เมื่อวันที่ :' . $rental_date . '</td>';
                            echo '<td>' . $pickup_location . '-->' . $destination_province . '</td>'; ?>
                            <td>
                                <a class="btn btn-warning mt-auto" href="booking_detail.php?bookings_id=<?php echo $bookings_id; ?>">ดูรายละเอียด</a>

                            </td><?php
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5">No data found.</td></tr>';
                            }
                                    ?>
                </tbody>
            </table>
        </div>


        </section>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </div>
</body>

</html>