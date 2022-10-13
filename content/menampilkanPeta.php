<!DOCTYPE html>
<html>
<!-- membutuhkan koneksi db -->
<?php include "../db/koneksi.php"; ?>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Mengaktifkan jQuery -->
  <script src="../assets/jquery-3.5.1.min.js"></script>

  <!-- Mengaktifkan Leaflet -->
  <link rel="stylesheet" type="text/css" href="../leaflet/leaflet.css" />
  <script src="../leaflet/leaflet.js"></script>

  <!-- Mengaktfikan Bootstrap -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
  <script src="../js/bootstrap.js"></script>

  <!-- Mengaktifkan MapBox -->
  <script src='https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.css' rel='stylesheet' />

  <!-- Mengaktifkan Leaflet.Easybutton -->
  <link rel="stylesheet" href="../assets/Leaflet.EasyButton-master/src/easy-button.css">
  <script src="../assets/Leaflet.EasyButton-master/src/easy-button.js"></script>

  <!-- mengaktifkan leaflet-tag-filter-button -->
  <!-- <link rel="stylesheet" href="assets/leaflet-tag-filter-button-master/docs/assets/css/leaflet.css" /> -->
  <link rel="stylesheet" href="../assets/leaflet-tag-filter-button-master/docs/assets/css/leaflet-easy-button.css" />
  <link rel="stylesheet" href="../assets/leaflet-tag-filter-button-master/src/leaflet-tag-filter-button.css" />
  <link rel="stylesheet" href="../assets/leaflet-tag-filter-button-master/docs/assets/css/ripple.min.css" />
  <!-- <script src="assets/leaflet-tag-filter-button-master/docs/assets/js/leaflet.js"></script> -->
  <script src="../assets/leaflet-tag-filter-button-master/docs/assets/js/leaflet-easy-button.js"></script>
  <script src="../assets/leaflet-tag-filter-button-master/src/leaflet-tag-filter-button.js"></script>

  <!-- Mengaktifkan ajax -->
  <link rel="stylesheet" href="../assets/leaflet-panel-layers-master/src/leaflet-panel-layers.css" />
  <script src="../assets/leaflet-panel-layers-master/src/leaflet-panel-layers.js"></script>
  <script src="../assets/leaflet-ajax-gh-pages/dist/leaflet.ajax.js"></script>

  <style>
    #map {
      border: 1px solid grey;
      margin: 0px;
      -moz-border-radius: 5px;
      box-shadow: 0 0 10px #000000;
      float: left;
      display: ;
      position: absolute;
      top: 55px;
      left: 0px;
      right: 0px;
      bottom: 0px;
    }

    .leaflet-map {
      height: 500px;
      width: 100%;
    }

    .easy-button-button {
      display: block !important;
    }

    .tag-filter-tags-container {
      left: 30px;
    }

    /*Legend specific*/
    .legend {
      padding: 6px 8px;
      font: 12px Arial, Helvetica, sans-serif;
      background: white;
      background: rgba(255, 255, 255, 0.8);
      /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
      /*border-radius: 5px;*/
      line-height: 24px;
      color: #555;
    }
    .legend h4 {
      text-align: center;
      font-size: 16px;
      margin: 2px 12px 8px;
      color: #777;
    }

    .legend span {
      position: relative;
      bottom: 3px;
    }

    .legend i {
      width: 18px;
      height: 18px;
      float: left;
      margin: 0 8px 0 0;
      opacity: 0.7;
    }

    .legend i.icon {
      background-size: 16px;
      background-color: rgba(255, 255, 255, 1);
    }
  </style>
</head>

<body>
  <!-- Navbar menu -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="../index.php">GIS Pengolahan Sampah</a>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="menampilkanPeta.php">Peta <span class="sr-only"></span></a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Menampilkan peta -->
  <div id="map"></div>
  <script type="text/javascript">

    // $(function(argument) {
    // Inisialisasi Link basemaps
    var mapTiler = L.tileLayer('https://api.maptiler.com/maps/basic/{z}/{x}/{y}.png?key=GPYXez7OqjRIJ0QBikUq');
    var mapBox = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FnYXNhbmRhaDEyIiwiYSI6ImNrYnUwMHFscTBmM3IyemxjZWloOGJlNWcifQ.MxcYWHqW0tGWRtVGe89B_A');
    var openStreetMaps = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png');
  // });
    //Inisialisasi poiGroup
    var bankSampah = new L.LayerGroup();
    var fasilitator = new L.LayerGroup();
    var tps = new L.LayerGroup();
    var tpa = new L.LayerGroup();
    var tpst = new L.LayerGroup();
    var tempatpublik = new L.LayerGroup();


    //Konfigurasi CSS setiap kecamatan
    var kedungkandangStyle = {
      "color": "#FF0000",
      "weight": 3,
      "opacity": 2
    };

    var klojenStyle = {
      "color": "#0000FF",
      "weight": 3,
      "opacity": 2
    };

    var blimbingStyle = {
      "color": "#008000",
      "weight": 3,
      "opacity": 2
    };

    var lowokwaruStyle = {
      "color": "#ffbf00",
      "weight": 3,
      "opacity": 2
    };

    var sukunStyle = {
      "color": "#ff4000",
      "weight": 3,
      "opacity": 2
    };

    //Menampilkan popup masing masing kecamatan
    function popUp(f, l) {
      var out = [];
      if (f.properties) {
        out.push("Kecamatan : " + f.properties['Kecamatan']);
        l.bindPopup(out.join("<br />"));
      }
    };

    //Inisialisasi Kecamatan
    var Kedungkandang = new L.GeoJSON.AJAX(["../assets/json/kecamatan_kedungkandang.geojson"], {
      onEachFeature: popUp,
      style: kedungkandangStyle
    });

    var Klojen = new L.GeoJSON.AJAX(["../assets/json/kecamatan_klojen.geojson"], {
      onEachFeature: popUp,
      style: klojenStyle
    });

    var Sukun = new L.GeoJSON.AJAX(["../assets/json/kecamatan_sukun.geojson"], {
      onEachFeature: popUp,
      style: sukunStyle
    });

    var Lowokwaru = new L.GeoJSON.AJAX(["../assets/json/kecamatan_lowokwaru.geojson"], {
      onEachFeature: popUp,
      style: lowokwaruStyle
    });

    var Blimbing = new L.GeoJSON.AJAX(["../assets/json/kecamatan_blimbing.geojson"], {
      onEachFeature: popUp,
      style: blimbingStyle
    });

    //Inisialisasi map
    var map = L.map('map', {
      center: [-7.98, 112.63],
      zoom: 13,
      layers: [mapTiler,bankSampah,tempatpublik,Sukun,Kedungkandang,Klojen,Lowokwaru,Blimbing]
    });

    var baseMap = [{
      group: "Base Map",
      collapsed: true,
      layers: [

      {
        name: "MapTiler",
        layer: mapTiler
      },
      {
        name: "MapBox",
        layer: mapBox
      },
      {
        name: "OpenStreetMaps",
        layer: openStreetMaps
      }
      ]
    }];

    var poiGroup = [{
      group: "Point",
      collapsed: true,
      layers: [{
        active: true,
        name: "Bank Sampah",
        layer: bankSampah

      },
      {
        name: "Fasilitator 3R",
        layer: fasilitator
      },
      {
        name: "Tempat Penampungan Sementara",
        layer: tps

      },
      {
        name: "Tempat Pengolahan Sampah Terpadu",
        layer: tpst
      },
      {
        name: "Tempat Pembuangan Akhir",
        layer: tpa

      },
      {
        name: "Tempat Publik",
        layer: tempatpublik
      }
      ]
    }, {
      group: "Kecamatan",
      collapsed: true,
      layers: [{
        name: "Kedungkandang",
        layer: Kedungkandang
      },
      {
        name: "Klojen",
        layer: Klojen
      },
      {
        name: "Sukun",
        layer: Sukun

      },
      {
        name: "Lowokwaru",
        layer: Lowokwaru

      },
      {
        name: "Blimbing",
        layer: Blimbing

      }

      ]
    }

    ]

    // Layermap 
    var panelLayers = new L.Control.PanelLayers(baseMap, poiGroup, {
      //compact: true,
      //collapsed: true,
      collapsibleGroups: true
    });

    map.addControl(panelLayers);

    // variabel memasukkan icon
    var LeafIcon = L.Icon.extend({
      options: {
        iconSize: [25, 25]
      }
    });
    var bsicon = new LeafIcon({
      iconUrl: '../icon/bank_sampah1.png'
    });
    var f3r = new LeafIcon({
      iconUrl: '../icon/3r.png'
    });
    var psicon = new LeafIcon({
      iconUrl: '../icon/waste.png'
    });
    var dumpicon = new LeafIcon({
      iconUrl: '../icon/dump.png'
    });
    var pst = new LeafIcon({
      iconUrl: '../icon/tpst.png'
    });
    var pblc = new LeafIcon({
      iconUrl: '../icon/public.png'
    });

    /*Legend specific*/
    var legend = L.control({ position: "bottomleft" });

    legend.onAdd = function(map) {
      var div = L.DomUtil.create("div", "legend");
      div.innerHTML += "<h4>Legend</h4>";
      // div.innerHTML += '<i style="background: #477AC2"></i><span>Water</span><br>';
      div.innerHTML += '<i class="icon" style="background-image: url(../icon/bank_sampah1.png);background-repeat: no-repeat;"></i><span>Bank Sampah</span><br>';
      div.innerHTML += '<i class="icon" style="background-image: url(../icon/3r.png);background-repeat: no-repeat;"></i><span>FAsilitator 3 R</span><br>';
      div.innerHTML += '<i class="icon" style="background-image: url(../icon/waste.png);background-repeat: no-repeat;"></i><span>Tempat Penampungan Sementara (TPS)</span><br>';
      div.innerHTML += '<i class="icon" style="background-image: url(../icon/dump.png);background-repeat: no-repeat;"></i><span>Tempat Pengolahan Sampah Terpadu (TPST)</span><br>';
      div.innerHTML += '<i class="icon" style="background-image: url(../icon/tpst.png);background-repeat: no-repeat;"></i><span>Tempat Pembuangan Akhir (TPA)</span><br>';
      // div.innerHTML += '<i style="background: #448D40"></i><span>Forest</span><br>';
      // div.innerHTML += '<i style="background: #E6E696"></i><span>Land</span><br>';
      // div.innerHTML += '<i style="background: #E8E6E0"></i><span>Residential</span><br>';
      // div.innerHTML += '<i style="background: #FFFFFF"></i><span>Ice</span><br>';
      div.innerHTML += '<i class="icon" style="background-image: url(../icon/public.png);background-repeat: no-repeat;"></i><span>Tempat Publik</span><br>';

      return div;
    };

    legend.addTo(map);


    //======================================== Bank Sampah ================================================
    //======================================== Open 2019 ================================================
    //menampilkan data 2019 dari database bank_sampah
    <?php
    $sql1  = "SELECT * FROM `bank_sampah`,`lokasi` WHERE bank_sampah.tahun='2019' AND bank_sampah.id_tempat=lokasi.id_tempat";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var bankSampah19 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: bsicon,
        tags: ['2019', '<?php echo $ck['bulan']; ?>']
      }).addTo(bankSampah).bindPopup("<?php echo "Nama: " . $ck['nama_tempat']; ?> <br><?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasional']; ?> <br>", {
        maxWidth: "1000"
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== Close 2019 ================================================
    //======================================== Open 2020 =================================================
    // menampilkan data 2020 dari database bank_sampah
    <?php
    $sql1  = "SELECT * FROM `bank_sampah` WHERE bank_sampah.tanggal='2020'";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var bankSampah20 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        tags: ['2020', '<?php echo $ck['bulan']; ?>']
      }).addTo(bankSampah).bindPopup("<?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasional']; ?> <br>", {
        maxWidth: "1000",
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== close 2020 =================================================

    //======================================== Fasilitator 3R =============================================
    //======================================== open 2019 ==================================================
    // menampilkan data 2019 dari database fasilitator
    <?php
    $sql1  = "SELECT * FROM `fasilitator_3r`,`lokasi` WHERE fasilitator_3r.tahun='2019' AND fasilitator_3r.id_tempat=lokasi.id_tempat";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var fTigaR19 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: f3r,
        tags: ['2019', '<?php echo $ck['bulan']; ?>']
      }).addTo(fasilitator).bindPopup("<?php echo "Nama: " . $ck['nama']; ?> <br> <?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasional']; ?> <br>", {
        maxWidth: "1000"
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== close 2019 =================================================
    //======================================== open 2020 ==================================================
    // menampilkan data 2020 dari database fasilitator
    <?php
    $sql1  = "SELECT * FROM `fasilitator_3r` WHERE fasilitator_3r.tanggal='2020'";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var fTigaR20 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: f3r,
        tags: ['2020', '<?php echo $ck['bulan']; ?>']
      }).addTo(fasilitator).bindPopup("<?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasional']; ?> <br>", {
        maxWidth: "1000"
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== close 2020 =================================================

    //======================================== Tempat Pembuangan Akhir ====================================
    //======================================== open 2019 ==================================================
    // menampilkan data 2019 dari database tempat_pembuangan_akhir
    <?php
    $sql1  = "SELECT * FROM `tps`,`lokasi` WHERE tps.tahun='2019' AND tps.id_tempat=lokasi.id_tempat";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var tpa19 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: psicon,
        tags: ['2019', '<?php echo $ck['bulan']; ?>']
      }).addTo(tps).bindPopup("<?php echo "Nama: " . $ck['nama_tempat']; ?> <br><?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasional']; ?> <br>", {
        maxWidth: "1000"
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== close 2019 =================================================
    //======================================== open 2020 ==================================================
    // menampilkan data 2020 dari database tempat_pembuangan_akhir
    <?php
    $sql1  = "SELECT * FROM `tempat_penampungan_sementara` WHERE tempat_penampungan_sementara.tanggal='2020'";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var tpa20 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: dumpicon,
        tags: ['2020', '<?php echo $ck['bulan']; ?>']
      }).addTo(tpa).bindPopup("<?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasional']; ?> <br>", {
        maxWidth: "1000"
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== close 2020 =================================================

    //======================================== Tempat Pembuangan Sampah Terpadu ===========================
    //======================================== open 2019 ==================================================
    // menampilkan data 2019 dari database tpst
    <?php
    $sql1  = "SELECT * FROM `tpst`,`lokasi` WHERE tpst.tahun='2019' AND tpst.id_tempat=lokasi.id_tempat";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var tpst19 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: pst,
        tags: ['2019', '<?php echo $ck['bulan']; ?>']
      }).addTo(tpst).bindPopup("<?php echo "Nama: " . $ck['nama_tempat']; ?> <br> <?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasional']; ?> <br>", {
        maxWidth: "1000"
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== close 2019 =================================================
    //======================================== open 2020 ==================================================
    // menampilkan data 2020 dari database tpst
    <?php
    $sql1  = "SELECT * FROM `tpst` WHERE tpst.tanggal='2020'";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var tpst20 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: pst,
        tags: ['2020', '<?php echo $ck['bulan']; ?>']
      }).addTo(tpst).bindPopup("<?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasioanl']; ?> <br>", {
        maxWidth: "1000"
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== close 2020 =================================================

    //======================================== Tempat Pembuangan Sampah Lainnya ===========================
    //======================================== open 2019 ==================================================
    // menampilkan data 2019 dari database pengolah_sampah
    <?php
    $sql1  = "SELECT * FROM `tpa`,`lokasi` WHERE tpa.tahun='2019' AND tpa.id_tempat=lokasi.id_tempat ";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var ps19 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: dumpicon,
        tags: ['2019', '<?php echo $ck['bulan']; ?>']
      }).addTo(tpa).bindPopup("<?php echo "Nama: " . $ck['nama_tempat']; ?> <br> <?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasional']; ?> <br>", {
        maxWidth: "1000"
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== close 2019 =================================================
    //======================================== open 2020 ==================================================
    // menampilkan data 2020 dari database tpst
    <?php
    $sql1  = "SELECT * FROM `pengolah_sampah` WHERE pengolah_sampah.tanggal='2020'";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var ps20 = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: psicon,
        tags: ['2020', '<?php echo $ck['bulan']; ?>']
      }).addTo(pengolahSampah).bindPopup("<?php echo "Alamat: " . $ck['alamat']; ?> <br> <?php echo "Kecamatan: " . $ck['kecamatan']; ?> <br> <?php echo "Jenis Sampah: " . $ck['jenis_sampah']; ?> <br> <?php echo "Jumlah Sampah: " . $ck['jml_sampah']; ?> <br> <?php echo "Jumlah Sampah yang diolah: " . $ck['jml_penanganan']; ?> <br> <?php echo "Biaya: " . $ck['biaya_operasional']; ?> <br>", {
        maxWidth: "1000"
      });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
    //======================================== close 2020 =================================================
    //======================================== open 2019 ==================================================

    <?php
    $sql1  = "SELECT * FROM `tempat_publik`";
    $data1 = mysqli_query($koneksi, $sql1);
    while ($ck = mysqli_fetch_assoc($data1)) {
    ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var tempatPublik = L.marker([<?php echo $lat = $ck['latitude']; ?>, <?php echo $long = $ck['longitude']; ?>], {
        icon: pblc}).addTo(tempatpublik).bindPopup("<?php echo "Nama: " . $ck['nama']; ?> <br><?php echo "Alamat: " . $ck['alamat']; ?>", {
          maxWidth: "1000"
        });
      //tutup script javascript + buka tag php kurawal penutup looping
    <?php } ?>
     //======================================== close 2019 =================================================

    // filter bulan dan tahun
    // variabel filter tahun
    // var yearFilterButton = new L.control.tagFilterButton({
    //   data: ['2019', '2020'],
    //   filterOnEveryClick: true,
    var yearFilterButton = new L.control.tagFilterButton({
      data: ['2019'],
      filterOnEveryClick: true,
      // icon: '<i class="fa fa-pagelines"></i>',
      icon: '<img src="../icon/filterYear.png">',
    }).addTo(map);
    // variabel filter bulan
    var monthFilterButton = new L.control.tagFilterButton({
      data: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
      filterOnEveryClick: true,
      // icon: '<i class="fa fa-suitcase"></i>',
      icon: '<img src="../icon/filterMonth.png">',
    }).addTo(map);
    // merelasikan bulan ke tahun
    // yearFilterButton.addToReleated(monthFilterButton);

    jQuery('.easy-button-button').click(function() {
      target = jQuery('.easy-button-button').not(this);
      target.parent().find('.tag-filter-tags-container').css({
        'display': 'none',
      });
    });

    //Perbatasan kecamatan
  </script>
</body>

</html>