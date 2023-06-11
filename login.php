<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container" style="font-family: 'Sarabun', sans-serif;">
        <?php
        // print_r($_POST);
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $enteredPassword = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $user = mysqli_fetch_assoc($result);
                if ($user) {
                    $storedPassword = $user['password'];
                    // if (password_verify($enteredPassword, $user["password"])) {
                    if (password_verify($enteredPassword, $storedPassword)) {
                        session_start();
                        $_SESSION["email"] = $email;
                        header("Location: home.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger '>รหัสผ่านไม่ถูกต้อง</div>";
                        // echo "รหัสผ่านไม่ถูกต้อง $enteredPassword  AND  $storedPassword";
                    }
                } else {
                    echo "<div class='alert alert-danger '>ไม่พบอีเมลในระบบ</div>";
                }
            } else {
                echo "<div class='alert alert-success '>เกิดข้อผิดพลาดในการตรวจสอบในฐานข้อมูล</div>" . mysqli_error($conn);
            }
        }
        ?>
      

      <div class="container mt-5" style="margin-right: auto; margin-left: auto; padding-right: 15px; padding-left: 15px; width: 100%;">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-group mb-0">
                        <div class="card p-4">
                            <div class="card-body">
                                <h1>เข้าสู่ระบบ</h1>
                                <p class="text-muted">Sign In to your account</p>
                                <form action="login.php" method="post">
                                    <div class="form-group">
                                        <input type="email" placeholder="Enter Email:" name="email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" placeholder="Enter Password:" name="password" class="form-control">
                                    </div>
                                    <div class="form-btn d-grid gap-2 col-6 mx-auto">
                                        <input type="submit" value="Login" name="login" class="btn btn-warning">
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                        <div class="card text-white bg-warning py-5 d-md-down-none" style="width:44%">
                            <div class="card-body text-center">
                                <div>
                                    <h2>สมัครสมาชิก</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <!-- <button type="button" class="btn btn-warning"  href="index.php">Register Now!</button> -->
                                    <a class="btn btn-light"  href="index.php" >Register Now!</a>
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