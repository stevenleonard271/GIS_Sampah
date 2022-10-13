$sql1  = "SELECT * FROM `bank_sampah` WHERE bank_sampah.tanggal='2019'";
      $data1 = mysqli_query($koneksi,$sql1);
      while ($ck = mysqli_fetch_assoc($data1)) {
      ?> //tutup php kurawal pembuka looping agar bisa masuk script javascript
      //masuk script javascript
      var bankSampah19 = L.marker([<?php echo $lat = $ck['latitude'];?>,<?php echo $long= $ck['longitude'];?>], { tags: ['2019'] }).addTo(bankSampah); 
      //tutup script javascript + buka tag php kurawal penutup looping
      <?php}
