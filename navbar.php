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

<body>
    <div style="font-family: 'Sarabun', sans-serif;">
        <nav class="navbar navbar-expand-md navbar-dark " style="background-color: #6699cc ;">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img width="100%" height="70" src="image/Corvette-logo.png" alt="Navbar Logo">
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="car_list.php">รายการรถ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="contact.php">เกี่ยวกับเรา</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="condition.php">ข้อตกลง</a>
                        </li>

                        <?php
                        session_start();
                        if (isset($_SESSION["email"])) {
                            $email = $_SESSION["email"];
                            echo '
                        <li class="nav-item">
                            <a class="nav-link" href="car_add.php">เพิ่มรถ</a>
                        </li> 
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          เช็คยอด
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="car_check.php">รายการสะสม</a></li>
                             <li><a class="dropdown-item" href="car_check2.php">รายการรอยืนยัน</a></li>
                          <li><a class="dropdown-item" href="car_check3.php">จัดการสถานะรถ</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="car_search.php">ค้นหาประวัติ</a></li>
                        </ul>
                      </li>
                    </ul>';
                            echo ' <a href="https://line.me/ti/p/Zu9X_iijE-">
                            <img src="image/line.png" width="30" style="margin-right: 5px;" alt="Line">
                        </a>
                        <a href="tel:0847753409">
                            <img src="image/call.png" width="30" style="margin-right: 5px;" alt="Call">
                        </a>
                        <a class="btn btn-outline-warning" href="logout.php" role="button">ออกจากระบบ</a>
                        ';
                        } else {
                            echo '
                        </ul>
                        <a href="https://line.me/ti/p/Zu9X_iijE-"> <img src="image/line.png."style="margin-right: 5px;" width="30"></a>
                        <a href="tel:0847753409"><img src="image/call.png" style="margin-right: 5px;" width="30" alt="Call"></a>
                        <a href="login.php">
                            <img src="image/welcome.png" alt="ไอคอน Admin" width="70">
                        </a>
                    ';
                        }
                        ?>
                </div>
            </div>
        </nav>
    </div>
</body>

</html>