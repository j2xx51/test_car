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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>

</head>
</head>
<?php include 'navbar.php'; ?>
<body style="background-color: #EBEDF3;">
    
    <div>
        <div class="p-2" style="font-family: 'Sarabun', sans-serif;">

            <div class="col gx-4 py-4 text-center">
                <img class="img-fluid w-100  rounded mb-4 mb-lg-0" src="image/8ab5c6a2-5590-4e48-93b0-469b159ae475.jpg" alt="..." />
            </div>
            <div class="col gx-4  text-center ">
                <h1 class="font-weight-light">บริษัท รถเช่าพร้อมคนขับ อยุธยา (Private Car Rent) จำกัด</h1>
                <p>"เปิดประสบการณ์ใหม่กับบริการรถเช่าพร้อมคนขับอยุธยา ที่จะทำให้คุณเดินทางไปถึงจุดหมายด้วยความสะดวกสบายและความปลอดภัย ร่วมกับ Private Car Rent และสัมผัสประสบการณ์ที่ดีที่สุดในการเดินทางของคุณ"</p>
              
            </div>
            <div class="card-body">
  <div class="card text-white my-5 py-4 text-center" style="background-color: #676767; box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;">
    <p class="text-white m-0">👉 ไม่ต้องใช้บัตรเครดิต
      👉 ลูกค้าขับเอง เราบริการส่งรถ
      👉 ลูกค้าเช่าพร้อมคนขับ เราบริการรับถึงบ้าน 
      👉 ราคาถูก ประหยัดจริง
      👉 จองง่าย สะดวกรวดเร็ว ตรงเวลา
    </p>
  </div>
</div>

              
            <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#myCarousel" data-bs-slide-to="1"></li>
                    <li data-bs-target="#myCarousel" data-bs-slide-to="2"></li>
                </ol>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="image/CatShow (1).jpg" class="d-block w-100" alt="Image 1" style="width: 250px; height: 500px;">

                    </div>
                    <div class="carousel-item">
                        <img src="image/CatShow (2).jpg" class="d-block w-100" alt="Image 2" style="width: 250px; height: 500px;">

                    </div>
                    <div class="carousel-item">
                        <img src="image/CatShow (3).jpg" class="d-block w-100" alt="Image 3" style="width: 250px; height: 500px;">

                    </div>
                </div>

                <!-- Controls -->
                <a class="carousel-control-prev" href="#myCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#myCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>

            <script>
                // Auto slide every 3 seconds
                setInterval(function() {
                    document.querySelector('#myCarousel').carousel('next');
                }, 3000);
            </script>

        </div>
        <footer class="py-5 "  style="background-color: #6699cc;">
            <div class="container px-4 px-lg-5">
                <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
            </div>
        </footer>



    </div>

</body>

</html>