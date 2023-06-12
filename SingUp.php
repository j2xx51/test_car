<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container" style="font-family: 'Sarabun', sans-serif;">
        <?php
        // print_r($_POST);
        if (isset($_POST["submit"])) {
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repeat_password = $_POST["repeat_password"];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();
            if (empty($fullname) or empty($email) or empty($password) or empty($repeat_password)) {
                array_push($errors, "กรุณากรอกข้อมูลให้ครบ");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "อีเมลไม่ถูกต้อง");
            }
            if (strlen($password) < 4) {
                array_push($errors, "รหัสสั้นไป");
            }
            if ($password !== $repeat_password) {
                array_push($errors, "ยืนยันรหัสผิดพลาด");
            }
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email' ";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "email ซ๊ำ");
            }


            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'> $error</div>";
                }
            } else {
                $sql = "INSERT INTO users (fullname, email, password) VALUES (?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>สมัครเรียบร้อย <a href='login.php'>เข้าสู่ระบบที่นี่</a></div>";
                } else {
                    die("Sorry we failed to connect: ");
                }
            }
        }
        ?>


    </div>
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">สมัครสมาชิก</h1>
                        <p class="lead">
                        บริษัท รถเช่าพร้อมคนขับ อยุธยา (Private Car Rent) จำกัด
                        </p>
                    </div>

                    <div class="card  bg-light">
                        <div class="card-body">
                            <div class="m-sm-4">
                                <form action="index.php" method="post">
                                    <div class="mb-3">
                                        <label for="exampleInputFullname" class="form-label">Fullname</label>
                                        <input type="text" class="form-control" name="fullname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword" class="form-label">Repeat_Password</label>
                                        <input type="password" class="form-control" name="repeat_password">
                                    </div>
                                    <button type="submit" class="btn btn-warning" value="Register" name="submit">สมัคร</button>
                                    <a href="login.php" class="btn  btn-warning">เข้าสู่ระบบ</a>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>