<!DOCTYPE html>
<html>

<head>
    <!-- Mengaktfikan Bootstrap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.min.css" />

    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</head>
<style>
    .img-container {
        text-align: center;
    }

    .img-fluid {
        margin: 25px 25px 25px 25px;
    }

    /* Make the image fully responsive */
    .carousel-inner img {
        width: 100%;
              
    }

    .page-footer {
        color: #fff;
        background: #343a40 !important;
    }

    .card-body {
        background-color: 	#505050;
    }

    #mama {
        margin: 40px 40px 40px 40px;
    }

    .col-sm3 {
        width: 360px;
        height: 300px;
        padding: 10px;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">GIS Pengolahan Sampah</a>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="content/menampilkanPeta.php">Peta <span class="sr-only"></span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="img-container">


        <div id="demo" class="carousel slide" data-ride="carousel">

            <!-- Indicators -->
            <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
            </ul>

            <!-- The slideshow -->
            <div class="carousel-inner">



                <div class="carousel-item active">
                    <img src="https://cdn.pixabay.com/photo/2013/07/05/12/20/rubbish-143465_1280.jpg" alt="Los Angeles" width="1000" height="500">
                </div>
                <div class="carousel-item">
                    <img src="https://cdn.pixabay.com/photo/2019/01/29/13/26/plastic-waste-3962409_1280.jpg" alt="Chicago" width="1000" height="500">
                </div>
                <div class="carousel-item">
                    <img src="https://cdn.pixabay.com/photo/2012/12/19/18/12/scrapyard-70908_1280.jpg" alt="New York" width="1000" height="500">
                </div>

            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>

        </div>

        <div class="container-fluid-xl p-3 my-3 bg-dark text-white">

            <h1>Sistem Informasi Geografis Pengelolaan Sampah</h1>
            <p id="mama">WEBGIS Pengelolaan Sampah merupakan WEBGIS yang dibuat dan ditujukan kepada masyarakat Malang, agar dapat melakukan analisa mengenai sampah-sampah .
                WEBGIS Pengelolaan Sampah dapat menunjukkan lokasi lokasi dan data mengenai Bank Sampah, TPA (Tempat Pembuangan Akhir), TPS (Tempat Penampungan Sementara), TPST (Tempat Pengelolaan Sampah Terpadu), dan Fasilitator 3R.
            </p>
            <h2>Fitur : </h2>
            <div class="card-deck">
                <div class="card">
                    <img class="card-img-top" src="icon/fitur1.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"> 3 Peta dasar </h5>
                        <p class="card-text"> MapTiler, MapBox, dan OpenStreetMaps sebagai peta yang akurat dan dapat dipercaya.</p>

                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="icon/fitur2.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"> Filtering </h5>
                        <p class="card-text">Ringkasan informasi pengelolaan Kota Malang setiap bulan.</p>

                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="icon/fitur3.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Legenda dan Area</h5>
                        <p class="card-text">Menampilkan legenda yang diinginkan berdasarkan per kecamatan di Kota Malang.</p>

                    </div>
                </div>
            </div>
        </div>

</body>

<!-- Footer -->
<footer class="page-footer font-small blue">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">Copyright © 2020 GIS Pengelolaan Sampah Kota Malang. All Right Reserved<br>
        Email :
        <a href="https://mdbootstrap.com/">webgissampahkotamalang@gmail.com</a>
        <br> 
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->

</html>