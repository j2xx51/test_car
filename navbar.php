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
    <div  style="font-family: 'Sarabun', sans-serif;">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"> <img width=100% height="50" src="image/Corvette-logo.png" alt="Navbar Logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="car_list.php">รายการรถ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">เกี่ยวกับเรา</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="condition.php">ข้อตกลง</a>
                        </li>

                        <?php
                        session_start();
                        if (isset($_SESSION["email"])) {
                            $email = $_SESSION["email"];
                            echo '<li class="nav-item">
                            <a class="nav-link" href="car_add.php">เพิ่มรถ</a>
                            </li> 
                            <li class="nav-item">
                          <a class="nav-link" href="car_check.php">เช็คยอด</a>
                          </li> 
                            </ul>';
                          
                            // echo '<p>สวัสดีคุณ ' . $email . '!</p>';
                            echo '<a class="btn btn-outline-warning" href="logout.php" role="button">ออกจากระบบ</a>';
                        } else {
                            echo ' </ul> <a href="login.php">
                            <img src="image/welcome.png" alt="ไอคอน Admin"  width="70">
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